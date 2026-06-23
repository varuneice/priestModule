# ACH + Recurring Subscription Plan

## Scope

Project: PHP MVC priest module

Goal: Add recurring donation/subscription payments using ACH bank account payment, without building a full user login system.

Existing assumption:
- Admin login already exists.
- Public donation flow already exists.
- Stripe card payment already exists, but current implementation is legacy charge/token based.
- User login will not be added.

## Recommended Approach

Use Stripe Billing subscriptions with ACH as the payment method.

The user will create a recurring donation from the public donation page. Subscription management will be handled through:
- Admin panel for admin-driven cancellation and status review.
- Email/OTP verified manage link for donor-side cancellation, if required.

Full username/password login is not required.

## User Flow

1. Donor opens donation page.
2. Donor selects donation amount.
3. Donor selects recurring frequency:
   - Monthly
   - Quarterly
   - Yearly
4. Donor selects payment method:
   - ACH / Bank Account
5. Donor enters required contact details:
   - Name
   - Email
   - Phone, optional
   - Address, if required for receipt/reporting
6. Stripe collects and verifies bank account details.
7. Donor accepts ACH mandate authorization.
8. System creates Stripe customer and subscription.
9. Local DB stores subscription details.
10. Donor receives confirmation email.
11. Future payment success/failure is synced through Stripe webhook.

## ACH Payment Behavior

ACH is asynchronous. Payment is not final immediately.

Possible statuses:
- Pending
- Processing
- Succeeded
- Failed
- Canceled

The app must not treat ACH as fully paid until Stripe webhook confirms success.

## Screens Required

### 1. Public Recurring Donation Form

Location: existing donation page or separate page like `Recurring Donation`.

Fields:
- Donation amount
- Frequency: Monthly / Quarterly / Yearly
- Donor name
- Email
- Phone
- Donation purpose/category
- Payment method: ACH Bank Account

Actions:
- Continue to bank payment
- Show pending confirmation after Stripe setup

### 2. Subscription Confirmation Screen

Shown after donor completes Stripe bank setup.

Content:
- Thank you message
- Subscription status
- Amount
- Frequency
- Note that ACH may take 2-4 business days to confirm

### 3. Admin Subscription List

New admin screen.

Columns:
- Donor name
- Email
- Amount
- Frequency
- Stripe subscription ID
- Status
- Last payment status
- Next billing date
- Created date
- Action: View / Cancel

Filters:
- Active
- Pending
- Failed
- Canceled
- Frequency

### 4. Admin Subscription Detail

Details:
- Donor information
- Subscription amount/frequency
- Stripe customer ID
- Stripe subscription ID
- Payment method type
- Payment history
- Webhook event history, optional

Actions:
- Cancel future payments
- Refresh/sync status from Stripe

### 5. Admin Cancel Confirmation

Before cancellation:
- Show donor name
- Amount/frequency
- Warning that future payments will stop

Action:
- Confirm cancel

Result:
- Cancel Stripe subscription
- Update local DB status to canceled
- Send cancellation email

### 6. Optional Donor Manage Link Page

No login required.

Flow:
1. Donor clicks manage link from confirmation email.
2. Donor enters email or receives OTP.
3. Donor verifies OTP.
4. Donor sees subscription status.
5. Donor can cancel future payments.

This is optional for phase 1. Admin-only cancellation is simpler.

## Admin-Only vs Donor Self-Cancel

### Phase 1 Recommendation

Use admin-only cancellation first.

Reason:
- No user login needed.
- Lower security risk.
- Faster implementation.
- Client can manually handle donor cancellation requests.

### Phase 2 Optional

Add donor manage link with OTP verification.

Reason:
- Still avoids full user login.
- Donor can cancel without admin involvement.
- Uses email verification instead of password accounts.

## Database Changes

Add a new table: `recurring_subscriptions`

Suggested columns:
- `id`
- `donor_name`
- `email`
- `phone`
- `amount`
- `currency`
- `frequency`
- `payment_method`
- `stripe_customer_id`
- `stripe_subscription_id`
- `stripe_payment_method_id`
- `stripe_latest_invoice_id`
- `status`
- `last_payment_status`
- `next_billing_date`
- `cancelled_at`
- `created_at`
- `updated_at`

Add a new table: `stripe_webhook_events`

Suggested columns:
- `id`
- `stripe_event_id`
- `event_type`
- `object_id`
- `payload`
- `processed_at`
- `created_at`

Purpose:
- Prevent duplicate webhook processing.
- Debug payment/subscription issues.

Optional table: `subscription_payments`

Suggested columns:
- `id`
- `recurring_subscription_id`
- `stripe_invoice_id`
- `stripe_payment_intent_id`
- `amount`
- `status`
- `paid_at`
- `created_at`

Purpose:
- Local payment history for admin reporting.

## Stripe Objects Required

Use:
- Customer
- Price or dynamic price data
- Subscription
- SetupIntent or Checkout subscription flow
- PaymentMethod: `us_bank_account`
- Webhook endpoint

Recommended implementation path:
- Use Stripe Checkout or embedded Stripe flow for subscription setup.
- Avoid manually storing bank account details.
- Do not store routing/account number in local DB.

## Webhooks Required

Minimum events:
- `customer.subscription.created`
- `customer.subscription.updated`
- `customer.subscription.deleted`
- `invoice.paid`
- `invoice.payment_failed`
- `payment_intent.succeeded`
- `payment_intent.payment_failed`

Webhook responsibilities:
- Update subscription status.
- Update last payment status.
- Record successful recurring payments.
- Record failed ACH payments.
- Prevent duplicate event processing.

## Cancellation / Withdraw Flow

Meaning of withdraw:
- Stop future recurring payments.

Admin cancellation flow:
1. Admin opens subscription detail.
2. Admin clicks Cancel.
3. System calls Stripe subscription cancel API.
4. Local DB updates status to canceled.
5. Donor receives cancellation email.

Important:
- Cancellation stops future charges.
- It does not automatically refund previous payments.

Refund is separate scope.

## Refund Scope

Not included in initial ACH recurring subscription scope unless client asks.

If required later:
- Admin refund button
- Stripe refund API
- Refund reason
- Refund status tracking
- Email notification

Estimate for refund feature: 2-4 additional working days.

## Security Requirements

Do not store bank account number or routing number.

Use Stripe-hosted or Stripe Elements bank account collection.

Store only:
- Stripe customer ID
- Stripe subscription ID
- Stripe payment method ID
- Status and metadata

Webhook must verify Stripe signature.

Admin cancel action must require admin login.

Optional donor self-cancel must require email OTP verification.

## Existing Code Areas Likely Affected

Controllers:
- `application/controllers/Donations.php`
- New controller for recurring subscriptions, or extension under Donations
- New webhook controller/action

Models:
- New `RecurringSubscription.model.php`
- New `StripeWebhookEvent.model.php`
- Optional `SubscriptionPayment.model.php`

Views:
- Existing donation view
- New admin subscription list
- New admin subscription detail
- Optional donor manage page

Config:
- Stripe secret key
- Stripe publishable key
- Stripe webhook signing secret

## Implementation Phases

### Phase 1: Admin-Managed ACH Recurring Subscription

Deliverables:
- Recurring donation form
- Stripe ACH subscription creation
- Local subscription DB table
- Stripe webhook endpoint
- Admin subscription list
- Admin subscription detail
- Admin cancel future payments
- Confirmation/cancellation emails

Estimate: 10-14 working days

### Phase 2: Donor Manage Link Without Login

Deliverables:
- Manage subscription link in email
- Email OTP verification
- Donor view subscription page
- Donor cancel future payments

Estimate: 3-5 working days

### Phase 3: Refund Support, If Needed

Deliverables:
- Admin refund action
- Stripe refund API integration
- Refund status/history
- Refund email

Estimate: 2-4 working days

## Total Estimate

Recommended minimum version:
- Phase 1 only: 10-14 working days

Better complete version:
- Phase 1 + Phase 2: 13-19 working days

With refund support:
- Phase 1 + Phase 2 + Phase 3: 15-23 working days

## Open Questions For Client

1. Frequencies required: monthly, quarterly, yearly, or only monthly/quarterly?
2. Should donor self-cancel be available, or admin-only cancellation is enough?
3. Should cancellation happen immediately or at the end of current billing period?
4. Should recurring donation support only ACH, or card recurring also?
5. Should failed ACH payment trigger email to donor/admin?
6. Should subscription donations map to existing donation categories/purpose?
7. Is refund required in this phase?

## Recommendation

Build Phase 1 first with admin-managed cancellation.

Reason:
- It satisfies the main client requirement.
- No user login is required.
- It keeps payment control under admin.
- It reduces implementation and security risk.

After Phase 1 is stable, add donor manage link with OTP if client wants self-service cancellation.
