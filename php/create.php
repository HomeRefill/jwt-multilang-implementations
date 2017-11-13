<?php

require_once __DIR__ . '/Configurator.php';

$config = Configurator::createDefaultConfigurations();

$supported_signatures_algorithms = $config->getOption('supported_signatures_algorithms');
$claims = $config->getOption('claims');
$signature_headers = $config->getOption('signature_headers');
$signature_key = $config->getPrivateKey();

$signer = Jose\Signer::createSigner($supported_signatures_algorithms);
$creator = new Jose\JWTCreator($signer);

$token = $creator->sign(
  $claims, 
  $signature_headers, 
  $signature_key
);

print $token;
