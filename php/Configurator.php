<?php

require_once 'vendor/autoload.php';

use \Jose\Factory\JWKFactory;
use \Jose\Object\JWKInterface;

class Configurator
{
  private $options;

  public static function createDefaultConfigurations()
  {
    $now = time();

    $options = [
      'keys_path' => realpath(__DIR__ . '/../keys'),
      'supported_signatures_algorithms' => ['RS256'],
      'signature_headers' => [
        'alg' => 'RS256',
        'crit' => ['exp', 'aud']
      ],

      'private_key' => "signature.key",
      'public_key'  => "signature.key.pub",
      'passphrase'  => '123456',

      'claims' => [
        'nbf' => $now,
        'iat' => $now,
        'exp' => $now + 3600,
        'iss' => 'HomerefillIssuer',
        'aud' => 'HomerefillAudience',
        'sub' => 'HomerefillSubject',
        'is_root' => true,
      ],

      'signature_key_headers' => [
        'kid' => 'HomerefillBackofficeAccessSignatureKey',
        'alg' => 'RS256',
        'use' => 'sig',
      ],
    ];

    return new self($options);
  }

  public function __construct(array $options)
  {
    $this->options = $options;
  }

  public function getOption($key)
  {
    return $this->options[$key];
  }

  public function getPrivateKey():JWKInterface
  {
    $key = $this->options['keys_path'] . '/' . $this->options['private_key'];
    $passphrase = $this->options['passphrase'];
    $headers = $this->options['signature_key_headers'];
    return JWKFactory::createFromKeyFile(
        $key,
        $passphrase,
        $headers
    );
  }

  public function getPublicKey():JWKInterface
  {
    $key = $this->options['keys_path'] . '/' . $this->options['public_key'];
    $headers = $this->options['signature_key_headers'];
    return JWKFactory::createFromKeyFile(
        $key,
        null,
        $headers
    );
  }
}
