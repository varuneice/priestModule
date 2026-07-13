<?php

abstract class Stripe
{
  /**
   * @var string The Stripe API key to be used for requests.
   */
  public static $apiKey;
  private static $useDefaultApiKeyFallback = true;

  /**
   * @var string The base URL for the Stripe API.
   */
  public static $apiBase = 'https://api.stripe.com';
  /**
   * @var string|null The version of the Stripe API to use for requests.
   */
  public static $apiVersion = null;
  /**
   * @var boolean Defaults to true.
   */
  public static $verifySslCerts = true;
  const VERSION = '1.13.0';

  /**
   * @return string The API key used for requests.
   */
  public static function getApiKey()
  {
    $apiKey = trim((string) self::$apiKey);
    if ($apiKey !== '') {
      return $apiKey;
    }

    if (!self::$useDefaultApiKeyFallback) {
      return self::$apiKey;
    }

    return self::getDefaultApiKey();
  }

  private static function getDefaultApiKey()
  {
    foreach (array('STRIPE_API_KEY', 'STRIPE_SECRET_KEY') as $envKey) {
      if (defined($envKey)) {
        $apiKey = trim((string) constant($envKey));
        if ($apiKey !== '') {
          return $apiKey;
        }
      }

      $apiKey = trim((string) getenv($envKey));
      if ($apiKey !== '') {
        return $apiKey;
      }
    }

    try {
      if (defined('MODELS_PATH') && class_exists('GzObject')) {
        GzObject::loadFiles('Model', 'Option');
        if (class_exists('OptionModel')) {
          $OptionModel = new OptionModel();
          $options = $OptionModel->getAllPairValues();
          $apiKey = trim((string) ($options['stripe_api_key'] ?? ''));
          if ($apiKey !== '') {
            return $apiKey;
          }
        }
      }
    } catch (Throwable $e) {
    } catch (Exception $e) {
    }

    return '';
  }

  /**
   * Sets the API key to be used for requests.
   *
   * @param string $apiKey
   */
  public static function setApiKey($apiKey)
  {
    self::$apiKey = trim((string) $apiKey);
    self::$useDefaultApiKeyFallback = true;
  }

  public static function setApiKey1($apiKey)
  {
    self::setApiKey($apiKey);
  }

  public static function setApiKey2($apiKey, $paymentAccount, $apiSecretKey)
  {
    self::$useDefaultApiKeyFallback = false;

    if ($paymentAccount == 'Regularaccount') {
      self::$apiKey = trim((string) $apiKey);
      return;
    }

    if ($paymentAccount == 'Pujaaccount') {
      self::$apiKey = trim((string) $apiSecretKey);
      return;
    }

    $secretKey = trim((string) $apiSecretKey);
    self::$apiKey = ($secretKey !== '') ? $secretKey : trim((string) $apiKey);
  }

  /**
   * @return string The API version used for requests. null if we're using the
   *    latest version.
   */
  public static function getApiVersion()
  {
    return self::$apiVersion;
  }

  /**
   * @param string $apiVersion The API version to use for requests.
   */
  public static function setApiVersion($apiVersion)
  {
    self::$apiVersion = $apiVersion;
  }

  /**
   * @return boolean
   */
  public static function getVerifySslCerts()
  {
    return self::$verifySslCerts;
  }

  /**
   * @param boolean $verify
   */
  public static function setVerifySslCerts($verify)
  {
    self::$verifySslCerts = $verify;
  }
}