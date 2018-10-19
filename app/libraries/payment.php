<?php
namespace payment;
class authorization {

  private $gatewayUrl = "https://banamex.dialectpayments.com/api/rest";
  private $merchantId = "TEST1042601HPP";
  private $apiUsername = "merchant.TEST1042601HPP";
  private $password = "dd0e5d508264839d833d7bb49e21ace7";
  private $version = "49";

  function checkGateway() {
    $url = $this->gatewayUrl.'/version/'.$this->version.'/information';

    $respon = $this->curlRequest($url, 'GET', json_decode('{}'), false);
    return $respon;
  }

  function pay($orderID, $params, $transactionID) {
    $url = $this->gatewayUrl.'/version/'.$this->version;
    $url .= '/merchant/'.$this->merchantId;
    $url .= '/order/'.$orderID;
    $url .= '/transaction/'.$transactionID;

    $respon = $this->curlRequest($url, 'PUT', $params, true);

    return $respon;
  }

  function curlRequest($url, $method = 'GET', $params, $authorization = false) {

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);

    if($authorization){
      curl_setopt($curl, CURLOPT_USERPWD, $this->apiUsername . ":" . $this->password);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: Application/json"));
    }

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    if($method != 'GET'){
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $resp = curl_exec($curl);
    curl_close($curl);

    return $resp;
  }
}
?>
