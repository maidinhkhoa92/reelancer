function cardNumberChange() {
  var charCode = (event.which) ? event.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57)){
    return false;
  }else{
    var value = document.getElementById("cardnumber").value;
    document.getElementById("cardnumber").value = value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
    var lastletter = value.slice(-1);
    if(lastletter === " "){
      document.getElementById("cardnumber").value = value.replace(/.$/,"")
    }
    return true;
  }
}
function dateChange() {
  var charCode = (event.which) ? event.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57)){
    return false;
  }else{
    var value = document.getElementById("ccexp").value;
    if(value.length === 2){
      document.getElementById("ccexp").value = value + "/"
    }
    return true;
  }
}
function cvvChange(event) {
  var charCode = (event.which) ? event.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}
function checkCard() {
  myCardNo = document.getElementById('cardnumber').value.split(' ').join('');
  if (checkCreditCard(myCardNo)) {
    var check = checkCreditCard(myCardNo);
    document.getElementById("check_typeCard").innerHTML = check.name;
  } else {
    document.getElementById("check_typeCard").innerHTML = "Invalid card";
  };
  return false;
}
