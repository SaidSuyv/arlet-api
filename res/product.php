<?php

require 'arlet.php';

class cProduct extends cArlet
{
  private $cAuth;

  public function __construct()
  {
    $this->cAuth = new cAuth();
  }

  

}