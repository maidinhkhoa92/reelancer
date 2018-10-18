var ccErrorNo = 0;
var ccErrors = new Array ()

ccErrors [0] = "Unknown card type";
ccErrors [1] = "No card number provided";
ccErrors [2] = "Credit card number is in invalid format";
ccErrors [3] = "Credit card number is invalid";
ccErrors [4] = "Credit card number has an inappropriate number of digits";
ccErrors [5] = "Warning! This credit card number is associated with a scam attempt";

function checkCreditCard(cardnumber) {

  // Array to hold the permitted card characteristics
  var cards = new Array();

  // Define the cards we support. You may add addtional card types as follows.

  //  Name:         As in the selection box of the form - must be same as user's
  //  Length:       List of possible valid lengths of the card number for the card
  //  prefixes:     List of possible prefixes for the card
  //  checkdigit:   Boolean to say whether there is a check digit

  cards [0] = {name: "Visa",
               length: [13,16],
               prefixes: ["4"],
               checkdigit: true};
  cards [1] = {name: "MasterCard",
               length: [16],
               prefixes: ["51","52","53","54","55"],
               checkdigit: true};
  cards [2] = {name: "DinersClub",
               length: [14,16],
               prefixes: ["36","38","54","55"],
               checkdigit: true};
  cards [3] = {name: "CarteBlanche",
               length: [14],
               prefixes: ["300","301","302","303","304","305"],
               checkdigit: true};
  cards [4] = {name: "AmEx",
               length: [15],
               prefixes: ["34","37"],
               checkdigit: true};
  cards [5] = {name: "Discover",
               length: [16],
               prefixes: ["6011","622","64","65"],
               checkdigit: true};
  cards [6] = {name: "JCB",
               length: [16],
               prefixes: ["35"],
               checkdigit: true};
  cards [7] = {name: "enRoute",
               length: [15],
               prefixes: ["2014","2149"],
               checkdigit: true};
  cards [8] = {name: "Solo",
               length: [16,18,19],
               prefixes: ["6334","6767"],
               checkdigit: true};
  cards [9] = {name: "Switch",
               length: [16,18,19],
               prefixes: ["4903","4905","4911","4936","564182","633110","6333","6759"],
               checkdigit: true};
  cards [10] = {name: "Maestro",
               length: [12,13,14,15,16,18,19],
               prefixes: ["5018","5020","5038","6304","6759","6761","6762","6763"],
               checkdigit: true};
  cards [11] = {name: "VisaElectron",
               length: [16],
               prefixes: ["4026","417500","4508","4844","4913","4917"],
               checkdigit: true};
  cards [12] = {name: "LaserCard",
               length: [16,17,18,19],
               prefixes: ["6304","6706","6771","6709"],
               checkdigit: true};

  // check length
  var cardWithLength = [];
  var i = 0;
  var cardType = -1;
  cards.forEach(function(card) {
    if(card.length.includes(cardnumber.length)){
      var splitCardNumber = cardnumber.split("");
      var stringNumber = "";
      splitCardNumber.forEach(function(letter) {
        stringNumber = stringNumber + letter;
        if(card.prefixes.includes(stringNumber)){
          cardType = i;
        }
      })
    }
    i = i + 1;
  });
  // If card type not found, report an error
  if (cardType === -1) {
     return false;
  }

  return cards[cardType];
}
