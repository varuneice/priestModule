<style>
    #gz-abc-calendar-container-2>div.gzABCalCellLegend>div:nth-child(2) {
        display: none;
    }

    #gz-abc-calendar-container-2>div.gzABCalCellLegend>div:nth-child(5) {
        display: none;
    }
</style>


<?php

require_once CONTROLLERS_PATH . 'App.php';

class RentalABCalendar extends App
{

    var $view_month = 1;
    var $show_weeks = true;
    var $calendar_id = null;
    var $startDay = 0;
    var $prevLink = "&lt;";
    var $nextLink = "&gt;";
    var $weekTitle = "#";
    var $dayNames = array();
    var $monthNames = array();
    var $calendar_capacity = 1;
    var $calendar_arr = array();
    var $reservationsInfo = array();
    var $option_arr = array();
    var $month = 1;
    var $year = 1;
    var $default_language = array();
    var $slots = array();
    var $slots_count = 0;
    var $selected_slots = array();
    var $monthShortNames = array();
    var $custom_dates = array();
    var $booked_slots = array();
    var $all_booked_slots_data = array();
    var $locations_map = array();

    function __construct($m, $day, $y, $cid, $view_month, $option_arr_values, $default_language)
    {
        GzObject::loadFiles('Model', array('Calendar'));
        $CalendarModel = new CalendarModel();

        $this->default_language = $default_language;
        $this->month = $m;
        $this->year = $y;
        $this->dayNames = __('dayNames');
        $this->monthNames = __('monthNames');
        $this->monthShortNames = __('monthShortNames');
        $this->weekTitle = __('weekTitle');
        $this->calendar_id = $cid;
        $this->view_month = $view_month;
        $this->option_arr = $option_arr_values;
        $this->calendar_arr = $CalendarModel->getI18n($cid);
        $this->calendar_capacity = (!empty($this->calendar_arr['limit'])) ? $this->calendar_arr['limit'] : 0;
        $this->startDay = $option_arr_values['week_first_day'];

        $this->serReservationsInfo($m, $day, $y);
        $this->serTimeSlot();
        $this->setSlotsCount();
        $this->setSelectedSlots();
    }

    function setSlotsCount()
    {

        if (!empty($_SESSION[$this->default_product]['slots'][$this->calendar_id])) {
            foreach ($_SESSION[$this->default_product]['slots'][$this->calendar_id] as $c) {
                if ($c > 0) {
                    $this->slots_count += $c;
                }
            }
        }
    }

    function setSelectedSlots()
    {
        if (!empty($_SESSION[$this->default_product]['slots'][$this->calendar_id])) {
            foreach ($_SESSION[$this->default_product]['slots'][$this->calendar_id] as $i => $count) {
                $html = '';
                $date = strtotime(date("Y-m-d", $i));
                switch (date('N', $i)) {
                    case '1':
                        $slot_lenght = $this->slots['monday_slot_lenght'];
                        $price = $this->slots['monday_price'];
                        $count = $this->slots['monday_count'];
                        break;
                    case '2':
                        $slot_lenght = $this->slots['tuesday_slot_lenght'];
                        $price = $this->slots['tuesday_price'];
                        $count = $this->slots['tuesday_count'];
                        break;
                    case '3':
                        $slot_lenght = $this->slots['wednesday_slot_lenght'];
                        $price = $this->slots['wednesday_price'];
                        $count = $this->slots['wednesday_count'];
                        break;
                    case '4':
                        $slot_lenght = $this->slots['thursday_slot_lenght'];
                        $price = $this->slots['thursday_price'];
                        $count = $this->slots['thursday_count'];
                        break;
                    case '5':
                        $slot_lenght = $this->slots['friday_slot_lenght'];
                        $price = $this->slots['friday_price'];
                        $count = $this->slots['friday_count'];
                        break;
                    case '6':
                        $slot_lenght = $this->slots['saturday_slot_lenght'];
                        $price = $this->slots['saturday_price'];
                        $count = $this->slots['saturday_count'];
                        break;
                    case '7':
                        $slot_lenght = $this->slots['sunday_slot_lenght'];
                        $price = $this->slots['sunday_price'];
                        $count = $this->slots['sunday_count'];
                        break;
                }
                $html .= '<tr>
                            <td>
                                ' . date($this->option_arr['time_format'], $i) . ' -
                            </td>
                            <td>
                                ' . date($this->option_arr['time_format'], ($i + $slot_lenght * 60)) . '
                            </td>
                            <td>
                                x ' . $count . '
                            </td>
                            </tr>';
                $this->selected_slots[$date][] = $html;
            }
        }
    }

    function serTimeSlot()
    {
        GzObject::loadFiles('Model', array('TimePrice', 'CustomDate'));
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();

        $opts = array();
        $opts['calendar_id'] = $this->calendar_id;
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {
                    $this->custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = array();
        $opts['calendar_id = :cal_id'] = array(':cal_id' => $this->calendar_id);
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->slots = $working_times[0];
        }
    }

    function serReservationsInfo($m, $day, $y)
    {
        GzObject::loadFiles('Model', array('RentalBookingSlot', 'RentalBooking'));
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $RentalBookingModel = new RentalBookingModel();

        $now = mktime(0, 0, 0, $m, $day, $y);
        $from = $now - (60 * 24 * 60 * 60);
        $to = $now + ($this->view_month * 60 * 24 * 60 * 60);

        $before = time() - 5 * 60;

        $sql = "SELECT * FROM " . $RentalBookingSlotModel->getTable() . " as t1 LEFT JOIN  " . $RentalBookingModel->getTable() . " as t2 ON t1.booking_id = t2.id WHERE (t2.status = 'confirmed' OR (t2.status = 'pending' AND t2.created >= " . $before . " )) AND t1.timestamp BETWEEN " . $from . "  AND " . $to . " AND t1.calendar_id = " . $this->calendar_id . " ";
        $arr = $RentalBookingSlotModel->execute($sql);

        foreach ($arr as $key => $value) {
            $date = strtotime(date('Y-m-d', $value['timestamp']));
            if (!empty($this->reservationsInfo[$date])) {
                $this->reservationsInfo[$date] += $value['count'];
            } else {
                $this->reservationsInfo[$date] = $value['count'];
            }

            if (!empty($this->booked_slots[$value['timestamp']])) {
                $this->booked_slots[$value['timestamp']] += $value['count'];
            } else {
                $this->booked_slots[$value['timestamp']] = $value['count'];
            }
        }

        // Cache all booked slot data and location map in ONE query each
        $this->all_booked_slots_data = $RentalBookingSlotModel->getAllRentalBookingSlotData();
        $allLocations = $RentalBookingSlotModel->getAllBookingRentalLocations();
        foreach ((array)$allLocations as $row) {
            $this->locations_map[$row['finalDate']] = $row['location'];
        }
    }

    function setPrevLink($value)
    {
        $this->prevLink = $value;
    }

    function setNextLink($value)
    {
        $this->nextLink = $value;
    }

    function getPrevLink()
    {
        return $this->prevLink;
    }

    function getNextLink()
    {
        return $this->nextLink;
    }

    function getMonthView($month = null, $year = null)
    {
        if (!empty($month)) {
            $this->month = $month;
        }
        if (!empty($year)) {
            $this->year = $year;
        }
        if (empty($this->month)) {
            $this->month = date('n');
        }
        if (empty($this->year)) {
            $this->year = date('Y');
        }

        $date = getdate(mktime(12, 0, 0, $this->month, 1, $this->year));

        $prevMonth = ($this->month - 1) < 1 ? 12 : ($this->month - 1);
        $prevYear = ($this->month - 1) < 1 ? ($this->year - 1) : $this->year;
        $nextMonth = ($this->month + 1) > 12 ? 1 : ($this->month + 1);
        $nextYear = ($this->month + 1) > 12 ? ($this->year + 1) : $this->year;

        $daysInMonth = days_in_month($this->month, $this->year);

        $cols = $this->show_weeks ? 8 : 7;
        $cal = "";

        if (date('n') == $this->month) {
            $cal .= "<div class='gzCalHeader gzABCalCellMonth row col-sm-12'>";
            $cal .= "<div class=\"text-left col-sm-10\" colspan=\"" . ($cols - 2) . "\"><div class=\"float-left margin-bottom-30\"><span class=\"gzCalDay\">" . date('j') . "</span><span class=\"gzCalMonth\">" . @$this->monthNames[$this->month] . " " . $this->year . "<a class='showMinCalendar' href=\"javascript:\"><i class=\"fa fa-fw fa-angle-down\"></i></a></span></div></div>";
        } else {
            $cal .= "<div class='gzCalHeader gzABCalCellMonth row col-sm-12'>";
            $cal .= "<div class=\"text-left col-sm-10\" colspan=\"" . ($cols - 2) . "\"><div class=\"float-left margin-bottom-30\"><span class=\"gzCalDay\">" . @$this->monthNames[$this->month] . "</span><span class=\"gzCalYear\">" . $this->year . "<a class='showMinCalendar' href=\"javascript:\"><i class=\"fa fa-fw fa-angle-down\"></i></a></span></div></div>";
        }
        $cal .= "<div class=\"col-sm-2\">";
        $cal .= "<div class=\"gzABCalCellArrow\" data-timestamp=\"" . mktime(0, 0, 0, $this->month, $daysInMonth, $this->year) . "\" rev=\"" . $this->calendar_id . "\" data-month=\"" . $nextMonth . "\" data-year=\"" . $nextYear . "\"><a href=\"javascript:\"><i class=\"fa fa-fw fa-angle-double-right\"></i></a></div>";
        $cal .= "<div class=\"gzABCalCellArrow \" data-timestamp=\"" . mktime(0, 0, 0, $this->month, 1, $this->year) . "\" rev=\"" . $this->calendar_id . "\" data-month=\"" . $prevMonth . "\" data-year=\"" . $prevYear . "\"><a href=\"javascript:\"><i class=\"fa fa-fw fa-angle-double-left\"></i></a></div></div>";
        $cal .= "<table class='miniCalendar' id='miniCalendarId'>";
        $cal .= "<tr><td colspan='3'><h2>" . $this->year . "</h2></td></tr>";
        foreach ($this->monthShortNames as $key => $month) {
            if ($key == 1 || ($key - 1) % 3 == 0) {
                $cal .= "<tr>";
            }
            if ($key == $this->month) {
                $cal .= "<td><a href='javascript:' class=\"gzABCalCellArrow currentMonth\" data-timestamp=\"" . mktime(0, 0, 0, $key, 1, $this->year) . "\" rev=\"" . $this->calendar_id . "\" data-month=\"" . $key . "\" data-year=\"" . $this->year . "\">" . $month . "</a></td>";
            } else {
                $cal .= "<td><a href='javascript:' class=\"gzABCalCellArrow\" data-timestamp=\"" . mktime(0, 0, 0, $key, 1, $this->year) . "\" rev=\"" . $this->calendar_id . "\" data-month=\"" . $key . "\" data-year=\"" . $this->year . "\">" . $month . "</a></td>";
            }
            if (($key) % 3 == 0) {
                $cal .= "</tr>";
            }
        }
        $cal .= "</table>";
        $cal .= "</div>";
        $cal .= "<table class=\"gzABCalendarTable\" cellspacing=\"0\" cellpadding=\"0\">";
        $cal .= "<tr>";
        if ($this->show_weeks) {
            $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->weekTitle . "</td>";
        }
        $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->dayNames[($this->startDay - 1) % 7] . "</td>";
        $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->dayNames[($this->startDay) % 7] . "</td>";
        $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->dayNames[($this->startDay + 1) % 7] . "</td>";
        $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->dayNames[($this->startDay + 2) % 7] . "</td>";
        $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->dayNames[($this->startDay + 3) % 7] . "</td>";
        $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->dayNames[($this->startDay + 4) % 7] . "</td>";
        $cal .= "<td class=\"gzABCalCellWeekDay\">" . $this->dayNames[($this->startDay + 5) % 7] . "</td>";
        $cal .= "</tr>";
        $day = $this->startDay + 1 - $date["wday"];
        while ($day > 0) {
            $day -= 7;
        }
        $rows = 0;
        while ($day <= $daysInMonth) {
            $cal .= "<tr>";
            $timestamp = mktime(0, 0, 0, $this->month, $day, $this->year);
            if ($this->show_weeks) {
                $cal .= '<td class="gzABCalCellWeek">' . date("W", $timestamp) . '</td>';
            }
            for ($i = 0; $i < 7; $i++) {
                $timestamp = mktime(0, 0, 0, $this->month, $day, $this->year);
                $class = $this->getCalendarDateClassNew($day, $this->year, $this->month);

                //For show tootip msg of selected locations 
                // $CheckDate = str_pad($day, 2, '0', STR_PAD_LEFT) . "-" . str_pad($this->month, 2, '0', STR_PAD_LEFT) . "-" . $this->year;
                $CheckDate = $this->year . "-" . str_pad($this->month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                $selectedLocation = $this->GetSelectedLocations($CheckDate);
                $tooltip = "";
                if (!empty($selectedLocation)) {
                    if (strtolower($selectedLocation) === 'both') {
                        $tooltip = "Fully Booked";
                    } elseif (strpos($selectedLocation, ',') !== false) {
                        $tooltip = "Fully Booked";
                    } else {
                        $tooltip = $selectedLocation . " Not Available";
                    }
                }

                if (!empty($this->custom_dates[$timestamp])) {
                    $title = $this->custom_dates[$timestamp]['tooltip'];
                    $start_time = explode(':', $this->custom_dates[$timestamp]['start']);
                    $end_time = explode(':', $this->custom_dates[$timestamp]['end']);

                    $launch_start_time = explode(':', $this->custom_dates[$timestamp]['lunch_start']);
                    $launch_end_time = explode(':', $this->custom_dates[$timestamp]['lunch_end']);

                    $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                    $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                    $slot_lenght = $this->custom_dates[$timestamp]['slot_lenght'];
                    $price = $this->custom_dates[$timestamp]['price'];
                    $count = $this->custom_dates[$timestamp]['count'];

                    $is_day_off = $this->custom_dates[$timestamp]['is_day_off'];


                    // $CheckDate = str_pad($day, 2, '0', STR_PAD_LEFT) . "-" . str_pad($this->month, 2, '0', STR_PAD_LEFT) . "-" . $this->year;
                    // $CheckDate = getdate(mktime(12, 0, 0, $this->month, 1, $this->year));
                    $CheckDate = $this->year . "-" . str_pad($this->month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $GetSelectedLocations = $this->GetSelectedLocations($CheckDate);

                    if ($timestamp >= mktime(0, 0, 0, date('n'), date('d'), date('Y')) && $class != 'gzABCalCellEmpty') {
                        // $class .= " gzABCalCellEvent";
                        
                        if (!empty($GetSelectedLocations) && $GetSelectedLocations == "Auditorium") {
                            $class = "gzABCalColorADBlocked";
                        } elseif (!empty($GetSelectedLocations) && $GetSelectedLocations == "Kalabhavan") {
                            $class = "gzABCalColorKBBlocked";
                        } 
                        
                         elseif (strtolower($GetSelectedLocations ?? '') == 'both') {
                        // $class = 'gzABCalCellReserved';
                        $class = "gzABCalCellReservedBlocked";
                             
                         } 
                         elseif (strpos($GetSelectedLocations ?? '', ',') !== false) {
                        // $class = 'gzABCalCellReserved';
                         $class = "gzABCalCellReservedBlocked";
                         }
                        
                        else {
                            $class .= " gzABCalCellEvent";
                        }


                    }
                } else if (!empty($this->slots)) {
                    $title = '';
                    switch (date('N', $timestamp)) {
                        case '1':
                            // $title = $this->slots['monday_tooltip'];
                            $title = $tooltip;
                            $start_time = explode(':', $this->slots['monday_start']);
                            $end_time = explode(':', $this->slots['monday_end']);

                            $launch_start_time = explode(':', $this->slots['monday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['monday_lunch_end']);

                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                            $slot_lenght = $this->slots['monday_slot_lenght'];
                            $price = $this->slots['monday_price'];
                            $count = $this->slots['monday_count'];
                            $is_day_off = $this->slots['monday_is_day_off'];
                            break;
                        case '2':
                            // $title = $this->slots['tuesday_tooltip'];
                            $title = $tooltip;
                            $start_time = explode(':', $this->slots['tuesday_start']);
                            $end_time = explode(':', $this->slots['tuesday_end']);

                            $launch_start_time = explode(':', $this->slots['tuesday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['tuesday_lunch_end']);

                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                            $slot_lenght = $this->slots['tuesday_slot_lenght'];
                            $price = $this->slots['tuesday_price'];
                            $count = $this->slots['tuesday_count'];
                            $is_day_off = $this->slots['tuesday_is_day_off'];
                            break;
                        case '3':
                            // $title = $this->slots['wednesday_tooltip'];
                            $title = $tooltip;
                            $start_time = explode(':', $this->slots['wednesday_start']);
                            $end_time = explode(':', $this->slots['wednesday_end']);

                            $launch_start_time = explode(':', $this->slots['wednesday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['wednesday_lunch_end']);

                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                            $slot_lenght = $this->slots['wednesday_slot_lenght'];
                            $price = $this->slots['wednesday_price'];
                            $count = $this->slots['wednesday_count'];
                            $is_day_off = $this->slots['wednesday_is_day_off'];
                            break;
                        case '4':
                            // $title = $this->slots['thursday_tooltip'];
                            $title = $tooltip;
                            $start_time = explode(':', $this->slots['thursday_start']);
                            $end_time = explode(':', $this->slots['thursday_end']);

                            $launch_start_time = explode(':', $this->slots['thursday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['thursday_lunch_end']);

                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                            $slot_lenght = $this->slots['thursday_slot_lenght'];
                            $price = $this->slots['thursday_price'];
                            $count = $this->slots['thursday_count'];
                            $is_day_off = $this->slots['thursday_is_day_off'];
                            break;
                        case '5':
                            // $title = $this->slots['friday_tooltip'];
                            $title = $tooltip;
                            $start_time = explode(':', $this->slots['friday_start']);
                            $end_time = explode(':', $this->slots['friday_end']);

                            $launch_start_time = explode(':', $this->slots['friday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['friday_lunch_end']);

                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                            $slot_lenght = $this->slots['friday_slot_lenght'];
                            $price = $this->slots['friday_price'];
                            $count = $this->slots['friday_count'];
                            $is_day_off = $this->slots['friday_is_day_off'];
                            break;
                        case '6':
                            // $title = $this->slots['saturday_tooltip'];
                            $title = $tooltip;
                            $start_time = explode(':', $this->slots['saturday_start']);
                            $end_time = explode(':', $this->slots['saturday_end']);

                            $launch_start_time = explode(':', $this->slots['saturday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['saturday_lunch_end']);

                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                            $slot_lenght = $this->slots['saturday_slot_lenght'];
                            $price = $this->slots['saturday_price'];
                            $count = $this->slots['saturday_count'];
                            $is_day_off = $this->slots['saturday_is_day_off'];
                            break;
                        case '7':
                            // $title = $this->slots['sunday_tooltip'];
                            $title = $tooltip;
                            $start_time = explode(':', $this->slots['sunday_start']);
                            $end_time = explode(':', $this->slots['sunday_end']);

                            $launch_start_time = explode(':', $this->slots['sunday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['sunday_lunch_end']);

                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $timestamp), (int)date('j', $timestamp), (int)date('Y', $timestamp));

                            $slot_lenght = $this->slots['sunday_slot_lenght'];
                            $price = $this->slots['sunday_price'];
                            $count = $this->slots['sunday_count'];
                            $is_day_off = $this->slots['sunday_is_day_off'];
                            break;
                    }
                }

                if ($timestamp >= mktime(0, 0, 0, date('n'), date('d'), date('Y')) && $is_day_off != 1 && !empty($title)) {

                    $tooltip .= '<h1>' . $title . '</h1>';

                    /* for ($t = mktime($start_time[0], $start_time[1], 0, date('n', $timestamp), date('j', $timestamp), date('Y', $timestamp)); $t < mktime($end_time[0], $end_time[1], 0, date('n', $timestamp), date('j', $timestamp), date('Y', $timestamp)); $t += $slot_lenght * 60) {
                      if ($t > time()) {
                      if(($t >= $launch_start && $t <= $launch_end)){
                      $t = $launch_end;
                      }
                      $booked = 0;
                      foreach ($this->booked_slots as $booked_timestamp => $booked_count) {
                      if ($booked_timestamp >= $t && $booked_timestamp < ($t + $slot_lenght * 60)) {
                      $booked += $booked_count;
                      }
                      }

                      $tooltip .= '<p>' . date($this->option_arr['date_format'] . ' ' . $this->option_arr['time_format'], $t) . ' - ' . date($this->option_arr['date_format'] . ' ' . $this->option_arr['time_format'], ($t + $slot_lenght * 60)) . '</p>'
                      . '<p>' . __('availability_tickets') . ' ' . ($count - $booked) . '/' . $count . '</p>';
                      }
                      } */
                }

                if ($timestamp == mktime(0, 0, 0, date('n'), date('d'), date('Y'))) {
                    $class .= " gzABCalCellToDay";
                }
                if ($class != 'gzABCalCellEmpty') {
                    if (!empty($tooltip)) {
                        $cal .= '<td data-timestamp="' . $timestamp . '" class="gzABCalCell ' . $class . '" id="' . $this->calendar_id . '_' . $timestamp . '" title="' . $tooltip . '">';
                    } else {
                        $cal .= '<td data-timestamp="' . $timestamp . '" class="gzABCalCell ' . $class . '" id="' . $this->calendar_id . '_' . $timestamp . '" >';
                    }
                } else {
                    $cal .= '<td class="gzABCalCell ' . $class . '" id="' . $this->calendar_id . '_' . $timestamp . '">';
                }
                $cal .= '<div class="gzABCalCellDivInner" >';
                if ($day > 0 && $day <= $daysInMonth) {
                    $cal .= '<div class="gzABCalDate">' . $day . '</div>';
                } else {
                    $cal .= "&nbsp;";
                }
                $cal .= '</div>';
                $cal .= "</td>";
                $day++;
            }
            $cal .= "</tr>";
            $rows++;
        }
        if ($rows == 5) {
            $cal .= "<tr>" . str_repeat('<td class="calendarEmpty">&nbsp;</td>', $cols) . "</tr>";
        }
        $cal .= "</table>";

        return $cal;
    }

    function getMultiViewMonth()
    {
        if ($this->view_month < 1 && $this->view_month > 12) {
            return false;
        }
        $month = array();

        $month[1] = $this->month;
        foreach (range(2, 12) as $i) {
            $month[$i] = ($month[1] + $i - 1) > 12 ? $month[1] + $i - 1 - 12 : $month[1] + $i - 1;
        }

        $year[1] = $this->year;
        foreach (range(2, 12) as $i) {
            $year[$i] = ($month[1] + $i - 1) > 12 ? $year[1] + 1 : $year[1];
        }

        switch ($this->view_month) {
            case '2':
                $col_sm = "col-sm-6";
                break;
            case '3':
                $col_sm = "col-sm-4";
                break;
            case '4':
                $col_sm = "col-sm-6";
                break;
            case '5':
                $col_sm = "col-sm-4";
                break;
            case '6':
                $col_sm = "col-sm-4";
                break;
            default:
                $col_sm = "col-sm-4";
                break;
        }

        $prevMonth = ($this->month - $this->view_month) < 1 ? (12 + ($this->month - $this->view_month)) : ($this->month - $this->view_month);
        $prevYear = ($this->month - $this->view_month) < 1 ? ($this->year - 1) : $this->year;

        $nextMonth = ($this->month + $this->view_month) > 12 ? (($this->month + $this->view_month) - 12) : ($this->month + $this->view_month);
        $nextYear = ($this->month + $this->view_month) > 12 ? ($this->year + 1) : $this->year;

        $daysInMonth = days_in_month($nextMonth, $nextYear);

        $str = "<div class=\"col-sm-12\">";
        $str .= "<h1>";
        $str .= "<div class=\"left\">";
        $str .= "<a href=\"javascript:\" class=\"gzABCalCellArrow\" data-timestamp=\"" . mktime(0, 0, 0, $this->month, 1, $this->year) . "\" rev=\"" . $this->calendar_id . "\" data-month=\"" . $prevMonth . "\" data-year=\"" . $prevYear . "\"><i class=\"fa fa-fw fa-chevron-circle-left\"></i></a>";
        $str .= "</div>";
        $str .= "<div class=\"left\">";
        $str .= "<a href=\"javascript:\" class=\"gzABCalCellArrow\" data-timestamp=\"" . mktime(0, 0, 0, $nextMonth, 1, $daysInMonth) . "\" rev=\"" . $this->calendar_id . "\" data-month=\"" . $nextMonth . "\" data-year=\"" . $nextYear . "\"><i class=\"fa fa-fw fa-chevron-circle-right\"></i></a>";
        $str .= "</div>";
        $str .= $this->calendar_arr['i18n'][$this->default_language['id']]['title'] . "</h1>";
        $str .= "</div>";

        if (($this->view_month % 3) == 0) {
            foreach (range(1, $this->view_month) as $i) {
                if (($i - 1) % 3 == 0 || $i == 1) {
                    $str .= "<div class=\"row col-sm-12\">";
                }
                $str .= "<div class=\"" . $col_sm . "\">";
                $str .= $this->getMonthView($month[$i], $year[$i]);
                $str .= "</div>";
                if ($i % 3 == 0) {
                    $str .= "</div>";
                }
            }
            $str .= $this->getLegend();
        } elseif (($this->view_month % 4) == 0) {
            foreach (range(1, $this->view_month) as $i) {
                if (($i - 1) % 4 == 0 || $i == 1) {
                    $str .= "<div class=\"row col-sm-12\">";
                }
                $str .= "<div class=\"" . $col_sm . "\">";
                $str .= $this->getMonthView($month[$i], $year[$i]);
                $str .= "</div>";
                if ($i % 4 == 0) {
                    $str .= "</div>";
                }
            }
            $str .= $this->getLegend();
        } else {
            foreach (range(1, $this->view_month) as $i) {
                if (($i - 1) % 2 == 0 || $i == 1) {
                    $str .= "<div class=\"row col-sm-12\">";
                }
                $str .= "<div class=\"" . $col_sm . "\">";
                $str .= $this->getMonthView($month[$i], $year[$i]);
                $str .= "</div>";
                if ($i % 2 == 0) {
                    $str .= "</div>";
                }
            }
            $str .= $this->getLegend();
        }
        return $str;
    }

    function getCalendarDateClassNew($d, $y, $m)
    {
        $today = getdate();
        $date = mktime(0, 0, 0, $m, $d, $y);
        $daysInMonth = days_in_month($m, $y);
        $arr1 = $this->all_booked_slots_data;
        $class = "";

        // $CheckDate = str_pad($d, 2, '0', STR_PAD_LEFT) . "-" . str_pad($m, 2, '0', STR_PAD_LEFT) . "-" . $y;
         $CheckDate = $y . "-" . str_pad($m, 2, '0', STR_PAD_LEFT) . "-" . str_pad($d, 2, '0', STR_PAD_LEFT);
        $GetSelectedLocations = $this->GetSelectedLocations($CheckDate);

        if ($y == $today["year"] && $m == $today["mon"] && $d == $today["mday"]) {
            // if ($GetSelectedLocations && !empty($GetSelectedLocations)) {
            //     $class = "gzABCalColorPartial";

            // } 

            if (!empty($GetSelectedLocations)) {
                if ($GetSelectedLocations == "Auditorium") {

                    $class = "gzABCalColorAD";
                } elseif ($GetSelectedLocations == "Kalabhavan") {

                    $class = "gzABCalColorKB";
                }
            } elseif (!empty($this->slots)) {
                $class = 'gzABCalCellAvil';
            }
        } elseif ($d < 1 || $d > $daysInMonth) {
            $class = 'gzABCalCellEmpty';
        } elseif ($date < $today[0]) {
            $class = 'gzABCalCellPast';
        } else {
            // if ($GetSelectedLocations && !empty($GetSelectedLocations)) {
            //     $class = "gzABCalColorPartial";

            // } 


            if (!empty($GetSelectedLocations)) {
                if ($GetSelectedLocations == "Auditorium") {

                    $class = "gzABCalColorAD";
                } elseif ($GetSelectedLocations == "Kalabhavan") {

                    $class = "gzABCalColorKB";
                }
            } elseif (!empty($this->slots)) {
                $class = 'gzABCalCellAvil';
            }

        }
        $now = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
        if ($date >= $now) {

            $count = $this->custom_dates[$date]['count'] ?? 0;
            if (!empty($this->slots)) {
                if (!empty($this->custom_dates[$date])) {

                    $start_time = explode(':', $this->custom_dates[$date]['start']);
                    $end_time = explode(':', $this->custom_dates[$date]['end']);
                    $launch_start_time = explode(':', $this->custom_dates[$date]['lunch_start']);
                    $launch_end_time = explode(':', $this->custom_dates[$date]['lunch_end']);
                    $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                    $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                    $slot_lenght = $this->custom_dates[$date]['slot_lenght'];
                    $is_day_off = $this->custom_dates[$date]['is_day_off'];
                } else {
                    switch (date('N', $date)) {
                        case 1:
                            $count = $this->slots['monday_count'];
                            $start_time = explode(':', $this->slots['monday_start']);
                            $end_time = explode(':', $this->slots['monday_end']);
                            $launch_start_time = explode(':', $this->slots['monday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['monday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['monday_slot_lenght'];
                            $is_day_off = $this->slots['monday_is_day_off'];
                            break;
                        case 2:
                            $count = $this->slots['tuesday_count'];
                            $start_time = explode(':', $this->slots['tuesday_start']);
                            $end_time = explode(':', $this->slots['tuesday_end']);
                            $launch_start_time = explode(':', $this->slots['tuesday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['tuesday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['tuesday_slot_lenght'];
                            $is_day_off = $this->slots['tuesday_is_day_off'];
                            break;
                        case 3:
                            $count = $this->slots['wednesday_count'];
                            $start_time = explode(':', $this->slots['wednesday_start']);
                            $end_time = explode(':', $this->slots['wednesday_end']);
                            $launch_start_time = explode(':', $this->slots['wednesday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['wednesday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['wednesday_slot_lenght'];
                            $is_day_off = $this->slots['wednesday_is_day_off'];
                            break;
                        case 4:
                            $count = $this->slots['thursday_count'];
                            $start_time = explode(':', $this->slots['thursday_start']);
                            $end_time = explode(':', $this->slots['thursday_end']);
                            $launch_start_time = explode(':', $this->slots['thursday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['thursday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['thursday_slot_lenght'];
                            $is_day_off = $this->slots['thursday_is_day_off'];
                            break;
                        case 5:
                            $count = $this->slots['friday_count'];
                            $start_time = explode(':', $this->slots['friday_start']);
                            $end_time = explode(':', $this->slots['friday_end']);
                            $launch_start_time = explode(':', $this->slots['friday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['friday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['friday_slot_lenght'];
                            $is_day_off = $this->slots['friday_is_day_off'];
                            break;
                        case 6:
                            $count = $this->slots['saturday_count'];
                            $start_time = explode(':', $this->slots['saturday_start']);
                            $end_time = explode(':', $this->slots['saturday_end']);
                            $launch_start_time = explode(':', $this->slots['saturday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['saturday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['saturday_slot_lenght'];
                            $is_day_off = $this->slots['saturday_is_day_off'];
                            break;
                        case 7:
                            $count = $this->slots['sunday_count'];
                            $start_time = explode(':', $this->slots['sunday_start']);
                            $end_time = explode(':', $this->slots['sunday_end']);
                            $launch_start_time = explode(':', $this->slots['sunday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['sunday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['sunday_slot_lenght'];
                            $is_day_off = $this->slots['sunday_is_day_off'];
                            break;
                    }
                }
            }

            if (!empty($start_time) && !empty($end_time) && !empty($count)) {
                $start_time = mktime($start_time[0], $start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                $end_time = mktime($end_time[0], $end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                $count = ceil(($end_time - $start_time) / ($slot_lenght * 60)) * $count - ceil(($launch_end - $launch_start) / ($slot_lenght * 60)) * $count;

            }


            // $CheckDate = str_pad($d, 2, '0', STR_PAD_LEFT) . "-" . str_pad($m, 2, '0', STR_PAD_LEFT) . "-" . $y;
             $CheckDate = $y . "-" . str_pad($m, 2, '0', STR_PAD_LEFT) . "-" . str_pad($d, 2, '0', STR_PAD_LEFT);
            $GetSelectedLocations = $this->GetSelectedLocations($CheckDate);

            foreach ($arr1 as $key => $value) {
                if ($value['timestamp'] == $date) {
                    //sleep(5);
                    $class = 'gzABCalCellReserved';
                }
            }
            if (!empty($is_day_off) && $is_day_off == 1) {
                // $class = 'gzABCalCellDayOff';


                if (!empty($GetSelectedLocations)) {
                    if (strtolower($GetSelectedLocations) == 'both') {
                        // $class = 'gzABCalCellReserved';
                         $class = "gzABCalCellReservedBlocked";
                    } elseif (strpos($GetSelectedLocations, ',') !== false) {
                        // $class = 'gzABCalCellReserved';
                         $class = "gzABCalCellReservedBlocked";
                    } elseif ($GetSelectedLocations == "Auditorium") {

                        $class = "gzABCalColorADBlocked";
                    } elseif ($GetSelectedLocations == "Kalabhavan") {

                        $class = "gzABCalColorKBBlocked";
                    }
                } else {
                    $class = 'gzABCalCellDayOff';
                }

            }
        }
        return $class;
    }

    function getCalendarDateClassBackup($d, $y, $m)
    {
        $today = getdate();
        $date = mktime(0, 0, 0, $m, $d, $y);
        $daysInMonth = days_in_month($m, $y);

        $class = "";

        if ($y == $today["year"] && $m == $today["mon"] && $d == $today["mday"]) {
            if (!empty($this->slots)) {
                $class = 'gzABCalCellAvil';
            }
        } elseif ($d < 1 || $d > $daysInMonth) {
            $class = 'gzABCalCellEmpty';
        } elseif ($date < $today[0]) {
            $class = 'gzABCalCellPast';
        } else {
            if (!empty($this->slots)) {
                $class = 'gzABCalCellAvil';
            }

        }
        $now = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
        if ($date >= $now) {

            if (!empty($this->slots)) {
                if (!empty($this->custom_dates[$date])) {
                    $count = $this->custom_dates[$date]['count'] ?? 0;
                    $start_time = explode(':', $this->custom_dates[$date]['start']);
                    $end_time = explode(':', $this->custom_dates[$date]['end']);
                    $launch_start_time = explode(':', $this->custom_dates[$date]['lunch_start']);
                    $launch_end_time = explode(':', $this->custom_dates[$date]['lunch_end']);
                    $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                    $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                    $slot_lenght = $this->custom_dates[$date]['slot_lenght'];
                    $is_day_off = $this->custom_dates[$date]['is_day_off'];
                } else {
                    switch (date('N', $date)) {
                        case 1:
                            $count = $this->slots['monday_count'];
                            $start_time = explode(':', $this->slots['monday_start']);
                            $end_time = explode(':', $this->slots['monday_end']);
                            $launch_start_time = explode(':', $this->slots['monday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['monday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['monday_slot_lenght'];
                            $is_day_off = $this->slots['monday_is_day_off'];
                            break;
                        case 2:
                            $count = $this->slots['tuesday_count'];
                            $start_time = explode(':', $this->slots['tuesday_start']);
                            $end_time = explode(':', $this->slots['tuesday_end']);
                            $launch_start_time = explode(':', $this->slots['tuesday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['tuesday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['tuesday_slot_lenght'];
                            $is_day_off = $this->slots['tuesday_is_day_off'];
                            break;
                        case 3:
                            $count = $this->slots['wednesday_count'];
                            $start_time = explode(':', $this->slots['wednesday_start']);
                            $end_time = explode(':', $this->slots['wednesday_end']);
                            $launch_start_time = explode(':', $this->slots['wednesday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['wednesday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['wednesday_slot_lenght'];
                            $is_day_off = $this->slots['wednesday_is_day_off'];
                            break;
                        case 4:
                            $count = $this->slots['thursday_count'];
                            $start_time = explode(':', $this->slots['thursday_start']);
                            $end_time = explode(':', $this->slots['thursday_end']);
                            $launch_start_time = explode(':', $this->slots['thursday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['thursday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['thursday_slot_lenght'];
                            $is_day_off = $this->slots['thursday_is_day_off'];
                            break;
                        case 5:
                            $count = $this->slots['friday_count'];
                            $start_time = explode(':', $this->slots['friday_start']);
                            $end_time = explode(':', $this->slots['friday_end']);
                            $launch_start_time = explode(':', $this->slots['friday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['friday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['friday_slot_lenght'];
                            $is_day_off = $this->slots['friday_is_day_off'];
                            break;
                        case 6:
                            $count = $this->slots['saturday_count'];
                            $start_time = explode(':', $this->slots['saturday_start']);
                            $end_time = explode(':', $this->slots['saturday_end']);
                            $launch_start_time = explode(':', $this->slots['saturday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['saturday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['saturday_slot_lenght'];
                            $is_day_off = $this->slots['saturday_is_day_off'];
                            break;
                        case 7:
                            $count = $this->slots['sunday_count'];
                            $start_time = explode(':', $this->slots['sunday_start']);
                            $end_time = explode(':', $this->slots['sunday_end']);
                            $launch_start_time = explode(':', $this->slots['sunday_lunch_start']);
                            $launch_end_time = explode(':', $this->slots['sunday_lunch_end']);
                            $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, (int)date('n', $date), (int)date('j', $date), (int)date('Y', $date));
                            $slot_lenght = $this->slots['sunday_slot_lenght'];
                            $is_day_off = $this->slots['sunday_is_day_off'];
                            break;
                    }
                }
            }
            if (!empty($start_time) && !empty($end_time) && !empty($count)) {
                $start_time = mktime($start_time[0], $start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                $end_time = mktime($end_time[0], $end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                $count = ceil(($end_time - $start_time) / ($slot_lenght * 60)) * $count - ceil(($launch_end - $launch_start) / ($slot_lenght * 60)) * $count;

            }

            if (!empty($is_day_off) && $is_day_off == 1) {
                $class = 'gzABCalCellDayOff';
            } elseif (!empty($this->reservationsInfo[$date]) && $this->reservationsInfo[$date] >= $count) {
                $class = 'gzABCalCellReserved';
            } elseif (!empty($this->reservationsInfo[$date])) {
                $class = 'gzABCalCellPending';
            }
        }
        return $class;
    }

    function getLegend()
    {

        $html = '<div class="gzABCalCellLegend" cellspacing="1" cellpadding="2">
                     <div style="display: flex; column-gap: 4rem;"> 

                    <div> 
                    <div class="gzABCalCellLabel2">' . __('available') . '<div class="gzABCalCellColor gzABCalColorAvil">&nbsp;</div></div>
                    <div class="gzABCalCellLabel2">' . __('full_booked') . '<div class="gzABCalCellColor gzABCalColorReserved">&nbsp;</div></div>
                    <div class="gzABCalCellLabel2">Not Available / Facility is Closed<div class="gzABCalCellColor gzABCalColorDayEvent">&nbsp;</div></div>
                    </div>

                    <div> 
                    <div class="gzABCalCellLabel2">Kalabhavan is Booked<div class="gzABCalCellColor gzABCalColorKBLegend">&nbsp;</div></div>
                    <div class="gzABCalCellLabel2">Auditorium is Booked<div class="gzABCalCellColor gzABCalColorADLegend">&nbsp;</div></div>
                    </div>
        
        </div>';

        if (!empty($this->slots_count)) {
            $html .= '<div class="gzABCalCellSlots">' . str_replace('%d', $this->slots_count, __('selected_slots')) . '</div>';
            $html .= '<div class="gzABCalButton">
                        <a data-style="expand-left" href="javascript:" class="btn btn-warning ladda-button" id="booking_frm_btn_id" autocomplete="off" value="' . __('booking') . '" name="submit" tabindex="9" type="submit">
                            <span class="ladda-label"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;' . __('booking') . '</span>
                            <span class="ladda-spinner"></span>
                        </a> 
                    </div>
		</div>';
        } else {
            $html .= '<div class="gzABCalButton">
                        <a data-style="expand-left" href="javascript:" class="btn btn-warning ladda-button disabled" id="booking_frm_btn_id" autocomplete="off" value="' . __('booking') . '" name="submit" tabindex="9" type="submit">
                            <span class="ladda-label"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;' . __('booking') . '</span>
                            <span class="ladda-spinner"></span>
                        </a> 
                    </div>
		</div>';
        }
        return $html;
    }

    // 21-APR-2025 new method added for get booked location

    function GetSelectedLocations($bookingDate)
    {
        $date = isset($bookingDate) ? trim($bookingDate) : null;
        return $this->locations_map[$date] ?? null;
    }


}
