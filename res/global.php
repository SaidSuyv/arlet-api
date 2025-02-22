<?php

require $_SERVER['DOCUMENT_ROOT'].'/global/main.php';
require 'auth.php';

class cArlet
{
  protected $cAuth;
  protected $cMain;

  public function __construct()
  {
    $this->cAuth = new cAuth();
    $this->cMain = new cMain("arlet.digysoft");
  }

  public function f_call( $method , ...$args )
  {
    $args = $this->cAuth->m_check_token( $method , $args );

    if( method_exists( $this , $method ) )
    {
      return call_user_func_array([ $this , $method ] , $args);
    }
    else die();
  }
}