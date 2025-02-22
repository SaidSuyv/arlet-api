<?php

if( $_SERVER['REQUEST_METHOD'] != "POST" ) die();

$input = json_decode( file_get_contents("php://input") , true );

if( !isset($input) )
  die();

require '../res/company.php';

$cAPI = new cCompany();

echo $cAPI->f_register_company($input);