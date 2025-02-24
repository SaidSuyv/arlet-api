<?php

require 'auth.php';

class cUser extends cMain
{
  private $auth;

  public function __construct()
  {
    parent::__construct("arlet.digysoft");
    $this->cAuth = new cAuth();
  }

  private function f_get_id_by_username($user)
  {
    $q = $this->cDatabase->execute(
      "SELECT id FROM user WHERE username = :u;",
      [ ":u" => $user ],
      "one"
    );
    return $q['id'];
  }

  public function f_Login($data)
  {
    $params = ['u','p'];

    if( $this->check_params( $data , $params ) )
    {
      if( $this->cAuth->f_internal_login( $data ) )
      {
        $id = $this->f_get_id_by_username($data['u']);
        $n = $this->cDatabase->execute(
          "SELECT b_new AS 'n' , IF( f_role = 1 , 1 , 0 ) AS 'a' FROM user WHERE id = :id;",
          [ ":id" => $id ],
          "one"
        );
        $this->cAuth->f_generate_token($data);
        return json_encode( $n , true );
      }
      else $this->set_error("Login failed. Please check credentials");
    }
    else die();
  }

  public function f_autologin()
  {
    echo "CHECKING...";
    $this->cAuth->m_check_token();
    $id = $this->cAuth->f_get_id_by_token();
    if( $id != false )
    {
      $n = $this->cDatabase->execute(
        "SELECT b_new AS 'n' , IF( f_role = 1 , 1 , 0 ) AS 'a' FROM user WHERE id = :id;",
        [ ":id" => $id['id'] ],
        "one"
      );
      return json_encode( $n , true );
    }
    else $this->set_error("Authorization failed.");
  }
}