<?php

class SubjectChecker extends \Jose\Checker\SubjectChecker
{
  private $subject;
  
  public function __construct($subject)
  {
    $this->subject = $subject;
  }

  protected function isSubjectAllowed($subject) 
  {
    return $subject === $this->subject;
  }
}
