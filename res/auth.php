<?php

require $_SERVER['DOCUMENT_ROOT'].'/global/main.php';

class cAuth
{
  private $main;

  public function __construct()
  {
    $this->main = new cMain("arlet.digysoft");
  }

  // USER MANAGEMENT RELATED

  private function f_user_exists($u)
  {
    $q = $this->main->cDatabase->execute(
      "SELECT pwd FROM user WHERE username = :u;",
      array(":u" => $u),
      "one"
    );
    return $q;
  }

  public function f_internal_login($data)
  {
    $q = $this->f_user_exists($data['u']);
    if( $q != false )
    {
      $pwd = $this->main->cCrypto->decrypt($q['pwd']);
      if( $data['p'] === $pwd ) return true;
    }
    
    return false;
  }
  
  // TOKEN MANAGEMENT RELATED

  private function f_decrypt_token($token)
  {
    $str = explode("|",$this->main->cCrypto->decrypt($token));
    $d = [ $this->main->cCrypto->decrypt($str[0]) , $this->main->cCrypto->decrypt($str[2]) , $str[1] ];
    return $d;
  }

  public function f_generate_token($data)
  {
    $expiration = strtotime("+1 hour");

    $arr = [
      $this->main->cCrypto->encrypt($data['u']),
      $expiration,
      $this->main->cCrypto->encrypt($data['p']),
    ];

    $str = implode("|",$arr);
    $token = $this->main->cCrypto->encrypt($str);
    $this->f_set_cookie($token);
  }

  // COOKIES MANAGEMENT RELATED

  private function f_set_cookie($token)
  {
    setcookie("arlet_token",$token,[
      'expires' => time() + 3600,
      'path' => '/',
      'secure' => true,
      'httponly' => true,
      'sameSite' => 'Strict'
    ]);
  }

  // MAIN FUNCTIONS

  public function m_check_token()
  {
    if( isset($_COOKIE['arlet_token']) )
    {
      $t = $_COOKIE['arlet_token'];
      $token_d = $this->f_decrypt_token($t);

      $creds = [ "u" => $token_d[0] , "p" => $token_d[1] ];

      if( !$this->f_internal_login($creds) )
        $this->main->set_error("Authorization failed.");

      $expired = time() > (int)$token_d[2];
      if( $expired )
        $this->f_generate_token($creds);
    }
  }
}