<?php
namespace payment;
class authorization {

  private $gatewayUrl = "https://banamex.dialectpayments.com/api/rest";
  private $merchantId = "1042601HPP";
  private $apiUsername = "merchant.TEST1042601HPP";
  private $password = "f0e31ab0b049cd9a109dfab75e75930c";
  private $version = "49";

  function checkGateway() {
    $url = $this->gatewayUrl.'/version/'.$this->version.'/information';

    $respon = $this->curlRequest($url, 'GET', json_decode('{}'), false);
    return $respon;
  }

  function authorization($orderID, $params, $transactionID) {
    $url = $this->gatewayUrl.'/version/'.$this->version.'/merchant/'.$this->merchantId.'/order/'.$orderID.'/transaction/'.$transactionID;

    $respon = $this->curlRequest($url, 'PUT', $params, true);
    return $respon;
  }

  function curlRequest($url, $method = 'GET', $params, $authorization = false) {

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    if($authorization){
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic '.base64_encode($apiUsername.":".$password)
      ));
    }

    $resp = curl_exec($curl);
    curl_close($curl);

    return $resp;
  }
}
?>
