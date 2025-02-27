<?php

require 'arlet.php';
require 'auth.php';

class cUser extends cArlet
{
  private $cAuth;
  private $cDatabase;

  public function __construct()
  {
    $this->cAuth = new cAuth();
    $this->cDatabase = new cDatabase("arlet_digysoft");
  }

  public function f_login($data)
  {
    $params = ['u','p'];

    if( $this->check_params( $data , $params ) )
    {
      if( $this->cAuth->f_internal_login( $data["u"] , $data["p"] ) )
      {
        // Obtain important data for login procedure
        $id = $this->cAuth->f_get_id();

        if( $id == null )
          $this->set_error("SERVER ERROR: There was an unexpected server error. Please try again later.");

        $n = $this->cDatabase->execute(
          "SELECT b_new AS 'n' , IF( f_role = 1 , 1 , 0 ) AS 'a' FROM user WHERE id = :id;",
          [ "id" => $id ],
          "one"
        );

        // Generates token and sends it as a cookie
        $t = $this->cAuth->f_generate_token($data);
        $this->cAuth->f_generate_cookie("arlet_token",$t);

        // Returns login data
        return json_encode( $n , true );
      }
      else $this->set_error("Login failed. Please check credentials");
    }
    else die();
  }

  public function f_autologin()
  {
    if( $this->cAuth->f_check_token() )
    {
      $id = $this->cAuth->f_get_id();

      if( $id == null )
        $this->set_error("SERVER ERROR: There was an unexpected error in the server. Please try again later.");

      $n = $this->cDatabase->execute(
        "SELECT b_new AS 'n' , IF( f_role = 1 , 1 , 0 ) AS 'a' FROM user WHERE id = :id;",
        [ "id" => $id ],
        "one"
      );

      return json_encode( $n , true );
    }
    else $this->set_error("Authorization failed.");
  }
}