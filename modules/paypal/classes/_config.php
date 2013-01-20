<?php
// Set sandbox (test mode) to true/false.
$sandbox = false;

// Set PayPal API version and credentials.
$_credentials = $sandbox ? array(
      'USER' => '',
      'PWD' => '',
      'SIGNATURE' => '',
) : array(
      'USER' => '',
      'PWD' => '',
      'SIGNATURE' => '',
);
$_version = '89.0'; 
$_endPoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
//old
/*
$api_version = '91.0';
$api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';

$api_username = $sandbox ? 'jia_1333393695_biz_api1.lekstuga.info' : 'info_api1.lindacarlstad.se';
$api_password = $sandbox ? '1333393720' : 'EMZAXJ92C7YJHPTA';
$api_signature = $sandbox ? 'AXkD58.qNeySq9qEC-93piM2xE.1A77sky483em-5FAWZmO7Bk.tTHi9' : 'AlQJ4tcT6VCXbsBOviABWZHAyY45AzWzKZMKs.pL5niSzLb3HFtWnH1R';
*/
?>