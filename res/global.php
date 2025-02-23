<?php

require $_SERVER['DOCUMENT_ROOT'].'/global/main.php';
require 'auth.php';

class cArlet extends cMain
{
  protected $cAuth;
  protected $cMain;

  public function __construct()
  {
    $this->cAuth = new cAuth();
    $this->cMain = new cMain("arlet.digysoft");
  }
}