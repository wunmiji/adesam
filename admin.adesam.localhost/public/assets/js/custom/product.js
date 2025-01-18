const costPriceInput = document.getElementById('costPriceInput');
const sellingPriceInput = document.getElementById('sellingPriceInput');

let regExp = new RegExp(/^\d{0,6}(?:\.\d{0,2})?$/);

var costPriceInputValue = costPriceInput.value;
var sellingPriceInputValue = sellingPriceInput.value;


function quantityKey(evt) {
    // Only ASCII character in that range allowed
    let ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function costPriceKey(evt) {
    if (regExp.test(evt.value)) {
        costPriceInputValue = evt.value;
    } else {
        evt.value = costPriceInputValue;
    }
}

function sellingPriceKey(evt) {
    if (regExp.test(evt.value)) {
        sellingPriceInputValue = evt.value;
    } else {
        evt.value = sellingPriceInputValue;
    }
}



