<?php

require $_SERVER['DOCUMENT_ROOT'].'/global/main.php';

class cUser extends cMain
{
  public function f_Login($data)
  {
    $authorized_params = ['u','p'];
    if( $this->check_params( $data , $authorized_params ) )
    {
      $u = $this->cDatabase->execute(
        "call p_get_user(:u);",
        array(':u' => $data['u'])
      );
      var_dump($u);
    }
    else die();
  }

  public function f_Register($data)
  {
    $authorized_params = ['n','ln','u','e','p'];
    if( $this->check_params( $data , $authorized_params ) )
    {
      $this->cDatabase->execute(
        "call p_register_admin(:n,:ln,:u,:e,:p);"
      );
    }
    else die();
  } 
}