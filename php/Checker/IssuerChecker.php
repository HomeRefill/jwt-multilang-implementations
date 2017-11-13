<?php

class IssuerChecker extends \Jose\Checker\IssuerChecker
{
  private $issuer;

  public function __construct($issuer)
  {
    $this->issuer = $issuer;
  }

  protected function isIssuerAllowed($issuer) 
  {
    return $issuer === $this->issuer;
  }
}
