<?php

require 'sql_str.php';
require 'auth.php';

class cCompany extends cMain
{
  private $cAuth;
  public function __construct()
  {
    parent::__construct("arlet.digysoft");
    $this->cAuth = new cAuth();
  }

  protected function f_get_last_id()
  {
    $q = $this->cDatabase->execute(
      "SELECT MAX(id) + 1 as 'last' FROM company;",
      [],
      "one"
    );
    if( $q['last'] == null )
      return 1;
    else
      return $q['last'];
  }

  protected function f_company_exists($ruc)
  {
    $q = $this->cDatabase->execute(
      "SELECT id FROM company WHERE ruc = :ruc;",
      [":ruc" => $ruc],
      "one"
    );
    return $q;
  }

  public function f_register_company($data)
  {
    $auth_params = [
      "trade_name",
      "tax_type",
      "tax_amount",
      "country_currency",
      "localization",
      "fiscal_address",
      "annex_facility",
      "email",
      "company_name",
      "ruc",
      "certificate_path",
      "certificate_pwd",
      "scnd_sunat_user",
      "scnd_sunat_pwd",
      "sunat_server",
      "consulting_website"
    ];

    if( $this->check_params( $data , $auth_params ) )
    {
      foreach( $data as $k => &$v )
      {
        switch($k)
        {
          case "tax_type":
          case "tax_amount":
          case "country_currency":
          case "ruc":
            continue;
          default:
            $v = $this->cCrypto->encrypt($v);
        }
      }

      $data = $this->convert_params($data);

      $id = array( ":id" => $this->f_get_last_id() );
      $parse = array_merge( $id , $data );

      $exists = $this->f_company_exists($data[':ruc']);

      if( $exists != false )
        $this->set_error("ERROR: COMPANY WITH RUC ".$data[':ruc']." ALREADY REGISTERED");

      $c = $this->cDatabase->execute(
        COMPANY_INSERTION,
        $parse
      );
      
      // CREATE ROOT COMPANY ADMIN FOR SERVICE MANAGEMENT
      $u = $this->cDatabase->execute(
        USER_INSERTION,
        array(
          ":name" => $this->cCrypto->encrypt("admin"),
          ":lastname" => $this->cCrypto->encrypt("admin"),
          ":email" => $this->cCrypto->encrypt("admin"),
          ":username" => $data[':ruc'],
          ":pwd" => $this->cCrypto->encrypt($data[':ruc']),
          ":company" => $id[':id'],
          ":role" => 1
        )
      );

      return true;
    }
    else die();
  }

  public function f_get_data()
  {
    $this->cAuth->m_check_token();
    $q = $this->cDatabase->execute(
      "SELECT * FROM company;"
    );
    echo json_encode($q , true);
  }
}