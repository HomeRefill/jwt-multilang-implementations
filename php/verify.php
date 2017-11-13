<?php

require_once __DIR__ . '/Configurator.php';
require_once __DIR__ . '/Checker/IssuerChecker.php';
require_once __DIR__ . '/Checker/SubjectChecker.php';

$config = Configurator::createDefaultConfigurations();

$supported_signatures_algorithms = $config
  ->getOption('supported_signatures_algorithms');
$claims = $config->getOption('claims');
$signature_key = $config->getPublicKey();

$verifier = Jose\Verifier::createVerifier(
  $supported_signatures_algorithms);

$input = end($argv);

$manager = new Jose\Checker\CheckerManager();

$checkers = [];
$checkers[] = new Jose\Checker\AudienceChecker($claims['aud']);
$checkers[] = new Jose\Checker\IssuedAtChecker();
$checkers[] = new Jose\Checker\NotBeforeChecker();
$checkers[] = new Jose\Checker\ExpirationTimeChecker();
$checkers[] = new IssuerChecker($claims['iss']);
$checkers[] = new SubjectChecker($claims['sub']);

foreach ($checkers as $checker) {
  $manager->addClaimChecker($checker);
}

$headerCheckers = [];
$headerCheckers[] = new Jose\Checker\CriticalHeaderChecker();

foreach ($headerCheckers as $checker) {
  $manager->addHeaderChecker($checker);
}

$signature_keyset = new Jose\Object\JWKSet();
$signature_keyset->addKey($signature_key);

$loader = new Jose\JWTLoader($manager, $verifier);

try {
  $jws = $loader->load($input);
  $loader->verify($jws, $signature_keyset);
} catch (Exception $e) {
  print "Failed with " . $e->getMessage();
  exit(1);
}

print 'ok';
exit(0);
