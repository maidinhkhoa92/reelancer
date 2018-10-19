<?php

include 'libraries/payment.php';

error_reporting(E_ERROR | E_PARSE);

use payment\authorization;

$authorization = new authorization();
$return = json_decode($authorization->checkGateway());

if($return->status == "OPERATING"){
  $params = new \stdClass;
  $data = json_decode(file_get_contents("data.json"));

  // convert data into params
  for($i=0; $i < count($data->cartItems); $i++){
    $params->order->item[$i]->name = $data->cartItems[$i]->name;
    $params->order->item[$i]->unitPrice = $data->cartItems[$i]->price;
    $params->order->item[$i]->quantity = $data->cartItems[$i]->quantity;
    $params->order->item[$i]->sku = $data->cartItems[$i]->id;
  }

  // submit action
  if(isset($_POST['checkout'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $cardNumber = str_replace(" ","",$_POST['cardNumber']);
    $cardExpired = $_POST['cardExpired'];
    list($cardExpiredMonth, $cardExpiredYear) = explode('/', $cardExpired);
    $cardCVC = $_POST['cardCVC'];

    $params->apiOperation =  "PAY";
    $params->order->currency =  "USD";
    $params->order->amount =  1240.00;
    $params->sourceOfFunds->provided->card->expiry->month = $cardExpiredMonth;
    $params->sourceOfFunds->provided->card->expiry->year = substr($cardExpiredYear, -2);
    $params->sourceOfFunds->provided->card->number = $cardNumber;
    $params->sourceOfFunds->provided->card->nameOnCard = $firstName.' '.$lastName;
    $params->sourceOfFunds->provided->card->securityCode = $cardCVC;
    $params->sourceOfFunds->type = 'CARD';

    // call request
    $return = json_decode($authorization->pay($_POST['orderId'], $params, $_POST['transactionID']));
    print_r($return);
  }

?>
<div class="card">
    <div class="card-header">
        <h6 class="m-0">Tarjeta de credito</h6>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-12 mb-3"><label for="ccname">First name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="border-right-0 input-group-text"><i class="fa fa-user"></i></div>
                        </div> <input type="text" id="ccname" name="firstName" placeholder="Nombre del titular de la tarjeta" class="form-control">
                    </div>
                </div>
                <div class="col-12 mb-3"><label for="cclastname">Surnames</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="border-right-0 input-group-text"><i class="fa fa-user"></i></div>
                        </div> <input type="text" name="lastName" autocomplete="cc-lastname" placeholder="Apellidos del titular de la tarjeta" class="form-control">
                    </div>
                </div>
                <div class="col-12 mb-3"><label for="cardnumber">Card number</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="border-right-0 input-group-text"><i class="fa fa-credit-card"></i></div>
                        </div>
						            <input maxlength="19" type="text" id="cardnumber" name="cardNumber" placeholder="0000 0000 0000 0000" class="form-control" onkeypress="return cardNumberChange()">

                    </div>
                </div>
                <div class="col-md-6 mb-3"><label for="ccexp">Date of Expiry</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="border-right-0 input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <input maxlength="7" type="text" id="ccexp" name="cardExpired" placeholder="--/----" class="form-control" onkeypress="dateChange()">
                    </div>
                </div>
                <div class="col-md-6 mb-3"><label for="cccvc">Security code</label>
                    <div class="input-group position-relative">
                        <div class="input-group-prepend">
                            <div class="border-right-0 input-group-text"><i class="fa fa-lock"></i></div>
                        </div> <input maxlength="3" type="text" id="cccvc" name="cardCVC" placeholder="3 dígitos" class="form-control" onkeypress="return cvvChange(event)">
                        <div id="csc" class="csc"></div>
                    </div>
                </div>
                <div id="check_typeCard"></div>
                <div class="col-12">
                  <input type="hidden" name="orderId" value="2" />
                  <input type="hidden" name="transactionID" value="3" />
                  <button name="checkout" type="submit" id="submit" class="btn btn-primary" onclick="">Pagar</button>
                </div>
            </div>
        </form>

    </div>
</div>
<?php } ?>
