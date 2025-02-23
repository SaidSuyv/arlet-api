<?php

require $_SERVER['DOCUMENT_ROOT'].'/global/crypto.php';

class cAuth
{
  private $cCrypto;
  
  public function __construct()
  {
    $this->cCrypto = new cCrypto();
  }

  public function f_generate_token( $data = [] )
  {
    $expiration = strtotime("+5 hours");

    
  }
}

// class cAuth extends cMain
// {
//   // USER MANAGEMENT RELATED

//   private function f_user_exists($u)
//   {
//     $q = $this->cDatabase->execute(
//       "SELECT pwd FROM user WHERE username = :u;",
//       array(":u" => $u),
//       "one"
//     );
//     return $q;
//   }

//   public function f_internal_login($data)
//   {
//     $q = $this->f_user_exists($data['u']);
//     if( $q != false )
//     {
//       $pwd = $this->cCrypto->decrypt($q['pwd']);
//       if( $data['p'] === $pwd ) return true;
//     }
    
//     return false;
//   }

//   public function f_get_id_by_token()
//   {
//     $t = $this->f_decrypt_token($_COOKIE["arlet_token"]);
//     $p = [":u" => $t[0]];
//     $q = $this->cDatabase->execute(
//       "SELECT id FROM user WHERE username = :u",
//       $p,
//       "one"
//     );
//     return $q;
//   }
  
//   // TOKEN MANAGEMENT RELATED

//   private function f_decrypt_token($token)
//   {
//     $str = explode("|",$this->cCrypto->decrypt($token));
//     $d = [ $this->cCrypto->decrypt($str[0]) , $this->cCrypto->decrypt($str[2]) , $str[1] ];
//     return $d;
//   }

//   public function f_generate_token($data)
//   {
//     $expiration = strtotime("+5 hour");

//     $arr = [
//       $this->cCrypto->encrypt($data['u']),
//       $expiration,
//       $this->cCrypto->encrypt($data['p']),
//     ];

//     $str = implode("|",$arr);
//     $token = $this->cCrypto->encrypt($str);
//     $this->f_set_cookie($token);
//   }

//   // COOKIES MANAGEMENT RELATED

//   private function f_set_cookie($token)
//   {
//     setcookie("arlet_token",$token,[
//       'expires' => time() + (3600 * 5),
//       'path' => '/',
//       'secure' => true,
//       'httponly' => true,
//       'samesite' => 'Strict'
//     ]);
//   }

//   // MAIN FUNCTIONS

//   public function m_check_token()
//   {
//     if( isset($_COOKIE['arlet_token']) )
//     {
//       echo "TOKEN EXISTS";
//       $t = $_COOKIE['arlet_token'];
//       $token_d = $this->f_decrypt_token($t);

//       $creds = [ "u" => $token_d[0] , "p" => $token_d[1] ];

//       if( !$this->f_internal_login($creds) )
//         $this->set_error("Authorization failed.");

//       $expired = time() > (int)$token_d[2];
//       if( $expired )
//         $this->f_generate_token($creds);
//     }
//     else
//     {
//       echo "NO EXISTS";
//       $this->set_error("Authorization failed.");
//     }
//   }
// }