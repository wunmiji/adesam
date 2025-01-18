const billingAddressRadios = document.getElementsByName('billingAddressRadio');
const shippingAddressRadios = document.getElementsByName('shippingAddressRadio');

const billingAddressHidden = document.getElementById('billing-address');
const shippingAddressHidden = document.getElementById('shipping-address');
const paymentMethodHidden = document.getElementById('payment-method');
const instructionHidden = document.getElementById('instruction');
const subtotalHidden = document.getElementById('subtotal');
const totalHidden = document.getElementById('total');

const yourOrderContainerDiv = document.getElementById('your-order-container');
const orderSummaryContainerDiv = document.getElementById('order-summary-container');

const orderBtn = document.getElementById('order-btn');




const itemArray = [];
var checkoutSubtotal = 0;
var checkoutTotal = 0;

if (billingAddressHidden !== null) selectAddress(billingAddressRadios, billingAddressHidden);
if (shippingAddressHidden !== null) selectAddress(shippingAddressRadios, shippingAddressHidden);


if (yourOrderContainerDiv !== null) {
    var currencyDataset = yourOrderContainerDiv.dataset.currency;

    order(yourOrderContainerDiv, currencyDataset);
}

if (orderBtn !== null) {
    orderBtn.addEventListener('click', function (event) {
        const instructionTextarea = document.getElementById('instruction-textarea');


        instructionHidden.value = instructionTextarea.value;
        subtotalHidden.value = checkoutSubtotal;
        totalHidden.value = checkoutTotal;
    });
}




function selectAddress(addressNodes, hiddenNode) {
    var address = '';
    for (let i = 0; i < addressNodes.length; i++) {
        let addressNode = addressNodes[i];

        addressNode.addEventListener('change', function (e) {
            if (this.checked) {
                hiddenNode.setAttribute("value", this.value);
                address = this.value;
            }
        });
    }

    return address;
}



function order(yourOrderNode, currency) {
    var items = JSON.parse(yourOrderNode.dataset.items);

    var subtotalH6 = document.getElementById('subtotal-h6');
    var shippingPriceSpan = document.getElementById('shipping-price-span');
    var totalH5 = document.getElementById('total-h5');

    var shippingPrice = shippingPriceSpan.dataset.shippingPrice

    let parent = document.createElement("div");
    parent.classList.add('row', 'g-3');
    yourOrderNode.appendChild(parent);

    Object.values(items).forEach((item) => {
        let div8 = document.createElement("div");
        div8.classList.add('col-8');
        div8.appendChild(productName(item.productName, item.fileSrc, item.fileAlt, item.quantity));
        parent.appendChild(div8);

        let div4 = document.createElement("div");
        div4.classList.add('col-4');
        const h6 = document.createElement('h6');
        h6.classList.add('mb-0', 'text-end');
        h6.style.color = 'var(--color-first-100)'; 
        h6.appendChild(document.createTextNode(item.stringProductPrice));
        div4.appendChild(h6);
        parent.appendChild(div4);

        var map = new Map();
        map.set('productId', item.productId);
        map.set('quantity', item.quantity);
        map.set('productPrice', item.productPrice);
        map.set('total', item.quantity * parseFloat(item.productPrice));
        itemArray.push(map);

        checkoutSubtotal += parseFloat(item.total);
    });

    checkoutTotal = checkoutSubtotal + parseFloat(shippingPrice);

    subtotalH6.appendChild(document.createTextNode(formatCurrency(currency, checkoutSubtotal)));
    shippingPriceSpan.appendChild(document.createTextNode('+(' + formatCurrency(currency, shippingPrice) + ')'));
    totalH5.appendChild(document.createTextNode(formatCurrency(currency, checkoutTotal)));


}

function productName(name, fileSrc, fileAlt, quantity) {
    var parent = document.createElement("div");
    parent.classList.add('d-flex');

    var div1 = document.createElement("div");
    div1.classList.add('flex-shrink-0');
    parent.appendChild(div1);
    var img = document.createElement("img");
    img.classList.add('object-fit-cover');
    img.setAttribute('width', '70px');
    img.setAttribute('height', '70px');
    img.setAttribute('src', fileSrc);
    img.setAttribute('alt', fileAlt);
    div1.appendChild(img);

    var div2 = document.createElement("div");
    div2.classList.add('flex-grow-1', 'ms-3', 'd-flex');
    parent.appendChild(div2);
    const paragraph = document.createElement('p');
    paragraph.classList.add('mb-0', 'fw-medium');
    paragraph.appendChild(document.createTextNode(name));
    div2.appendChild(paragraph);
    const span = document.createElement('span');
    span.classList.add('mb-0', 'fw-normal');
    span.appendChild(document.createTextNode('\u00A0\u00A0\u00A0x\u00A0\u00A0\u00A0 ' + quantity));
    paragraph.appendChild(span);

    return parent;
}

function itemArrayToJson() {
    var newItemArray = [];
    itemArray.forEach(element => {
        var obj = Object.fromEntries(element);
        newItemArray.push(obj);
    });

    return JSON.stringify(newItemArray);
}

function formatCurrency(currencyCode, amount) {
    let currency = new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: currencyCode,
    });
    return currency.format(amount);
}












