const cartTableDiv = document.getElementById('cart-table');
const shoppingCartTableTds = document.getElementsByName('shopping-cart-table-td');
const totalTableSubtotalTd = document.getElementById('total_table_subtotal');
const totalTableTotalTd = document.getElementById('total_table_total');
const localPickupRadio = document.getElementById('localPickupRadio');
const flatRateRadio = document.getElementById('flatRateRadio');
const updateCartBtn = document.getElementById('update-cart-btn');
const emptyCartBtn = document.getElementById('empty-cart-btn');
const shippingRadios = document.getElementsByName('shipping-radio');
const paymentRadios = document.getElementsByName('payment');


const itemArray = [];
var cart;

var dbCartDataset = cartTableDiv.dataset.cart;
var currencyDataset = cartTableDiv.dataset.currency;




if (userDataset === 'true') {
    cart = JSON.parse(dbCartDataset);
} else {
    if (localStorage.getItem('items') == null) {
        cart = null;
    } else {
        const cartCreation = {
            shippingType: localStorage.getItem('shippingType'),
            paymentMethod: localStorage.getItem('paymentMethod'),
            items: JSON.parse(localStorage.getItem('items'))
        };

        cart = Object.create(cartCreation);
    }

}

if (cart == null || Object.keys(cart.items).length == 0) {
    var cartTableParentDiv = cartTableDiv.parentElement;
    cartTableParentDiv.innerHTML = '';
    cartTableParentDiv.appendChild(emptyCart());
}

var table = table(cart.items);
cartTableDiv.appendChild(table);

var shoppingCartTableSubtotal = 0;
var shoppingCartTableTotal = 0;
var shoppingCartTableShippingValue = 0;
var shoppingCartTableShippingType = cart.shippingType;
var shoppingPaymentMethod = cart.paymentMethod;
updateCart();



for (let i = 0; i < shippingRadios.length; i++) {
    let radio = shippingRadios[i];

    if (radio.dataset.enum == shoppingCartTableShippingType) {
        radio.checked = true;
    }

    radio.addEventListener('change', function (e) {
        if (this.checked) {
            shoppingCartTableShippingType = this.dataset.enum;
            shoppingCartTableShippingValue = this.value;
            shoppingCartTableTotal = shoppingCartTableSubtotal + parseFloat(shoppingCartTableShippingValue);
            totalTableTotalTd.innerHTML = '';
            totalTableTotalTd.appendChild(document.createTextNode(formatCurrency(currencyDataset, shoppingCartTableTotal)));
        }
    });
}

for (let i = 0; i < paymentRadios.length; i++) {
    let radio = paymentRadios[i];

    if (radio.value == shoppingPaymentMethod) {
        radio.checked = true;
    }

    radio.addEventListener('change', function (e) {
        if (this.checked) {
            shoppingPaymentMethod = this.value;
        }
    });
}

emptyCartBtn.addEventListener('click', function (event) {
    if (userDataset !== 'true') {
        localStorage.clear();
    }
});

updateCartBtn.addEventListener('click', function (event) {
    event.preventDefault();
    event.stopPropagation();

    if (userDataset === 'true') {
        var formData = new FormData();
        formData.append('items', itemArrayToJson());
        formData.append('shipping-type', shoppingCartTableShippingType);
        formData.append('payment-method', shoppingPaymentMethod);


        postAjax(baseUrlDataset + 'shop/update-cart', formData,
            function (output) {
                updateCart();
                successAlert('Cart updated successfully');
            },
            function (jqXHR, textStatus, errorThrown) {
                errorAlert('An error occur when updating cart');
            }
        );

    } else {
        localStorage.clear();
        localStorage.setItem('shippingType', shoppingCartTableShippingType);
        localStorage.setItem('paymentMethod', shoppingPaymentMethod);
        localStorage.setItem('items', itemArrayToJson());

        updateCart();
        successAlert('Cart updated successfully');
    }


});

function table(datas) {
    const tbl = document.createElement("table");
    tbl.setAttribute('id', 'cartTable');
    tbl.classList.add('table');
    const tblHead = document.createElement("thead");

    let row = document.createElement("tr");

    const cell2 = document.createElement("th");
    cell2.setAttribute('scope', 'col');
    const cellText2 = document.createTextNode('Product');
    cell2.appendChild(cellText2);
    row.appendChild(cell2);

    const cell3 = document.createElement("th");
    cell3.setAttribute('scope', 'col');
    const cellText3 = document.createTextNode('Price');
    cell3.appendChild(cellText3);
    row.appendChild(cell3);

    const cell4 = document.createElement("th");
    cell4.setAttribute('scope', 'col');
    const cellText4 = document.createTextNode('Quantity');
    cell4.appendChild(cellText4);
    row.appendChild(cell4);

    const cell5 = document.createElement("th");
    cell5.setAttribute('scope', 'col');
    const cellText5 = document.createTextNode('Subtotal');
    cell5.appendChild(cellText5);
    row.appendChild(cell5);

    const cell6 = document.createElement("th");
    cell6.setAttribute('scope', 'col');
    const cellText6 = document.createTextNode('');
    cell6.appendChild(cellText6);
    row.appendChild(cell6);

    tblHead.appendChild(row);
    tbl.appendChild(tblHead);

    const tblBody = document.createElement("tbody");
    tbl.appendChild(tblBody);

    Object.values(datas).forEach((item) => {
        var map = new Map();
        map.set('id', item.id);
        tblBody.appendChild(tableBodyRow(map, item));
        itemArray.push(map);
    });

    return tbl;
}

function tableBodyRow(map, item) {
    let row = document.createElement("tr");
    row.setAttribute("data-unique", item.productUnique);

    const cell1 = document.createElement("td");
    cell1.classList.add('pe-4', 'text-wrap');
    map.set('productId', item.productId);
    const cellNode1 = productName(item.productName, item.productUnique, item.fileSrc, item.fileAlt, map);
    cell1.appendChild(cellNode1);
    row.appendChild(cell1);

    const cell2 = document.createElement("td");
    cell2.classList.add('pe-4', 'text-nowrap');
    cell2.style.color = 'var(--color-first-100)';
    map.set('productPrice', item.productPrice);
    const cellText2 = document.createTextNode(formatCurrency(currencyDataset, item.productPrice));
    cell2.appendChild(cellText2);
    row.appendChild(cell2);

    const cell3 = document.createElement("td");
    cell3.classList.add('pe-4', 'text-nowrap');
    map.set('quantity', item.quantity);
    row.appendChild(cell3);

    const cell4 = document.createElement("td");
    cell4.classList.add('pe-4', 'text-nowrap');
    cell4.style.color = 'var(--color-first-100)';
    map.set('total', item.total);
    const cellText4 = document.createTextNode(formatCurrency(currencyDataset, item.total));
    cell4.appendChild(cellText4);
    row.appendChild(cell4);

    const cell5 = document.createElement("td");
    cell5.classList.add('pe-4', 'text-nowrap');
    const cellNode5 = removeProduct(item.productUnique);
    cell5.appendChild(cellNode5);
    row.appendChild(cell5);

    // loaded later because of subtotal
    const cellNode3 = quantity(item.quantity, item.productPrice, cell4, map);
    cell3.appendChild(cellNode3);

    return row;
}

function productName(name, unique, fileSrc, fileAlt, map) {
    var parent = document.createElement("div");
    parent.classList.add('d-flex');

    // Used in localStorage
    map.set('productName', name);
    map.set('productUnique', unique);
    map.set('fileSrc', fileSrc);
    map.set('fileAlt', fileAlt);

    var div1 = document.createElement("div");
    div1.classList.add('flex-shrink-0');
    parent.appendChild(div1);
    var img = document.createElement("img");
    img.classList.add('object-fit-cover');
    img.setAttribute('width', '100px');
    img.setAttribute('height', '100px');
    img.setAttribute('src', fileSrc);
    img.setAttribute('alt', fileAlt);
    div1.appendChild(img);

    var div2 = document.createElement("div");
    div2.classList.add('flex-grow-1', 'ms-3', 'd-flex', 'flex-column');
    parent.appendChild(div2);
    const anchor = document.createElement('a');
    anchor.classList.add('mb-0', 'fw-semibold');
    anchor.setAttribute('href', '/shop/' + unique);
    anchor.appendChild(document.createTextNode(name));
    div2.appendChild(anchor);
    const paragraph = document.createElement('p');
    paragraph.classList.add('mb-0', 'small');
    paragraph.appendChild(document.createTextNode('#' + unique));
    div2.appendChild(paragraph);

    return parent;

}

function quantity(value, price, cell4, map) {
    var parent = document.createElement("div");
    parent.classList.add('btn-group', 'btn-group-sm');
    parent.setAttribute('role', 'group');
    parent.setAttribute('aria-label', 'Basic outlined example');

    var button1 = document.createElement("button");
    button1.classList.add('btn', 'primary-outline-btn', 'px-3');
    parent.appendChild(button1);
    const idiomatic1 = document.createElement('i');
    idiomatic1.classList.add('bx', 'bx-minus');
    button1.appendChild(idiomatic1);
    button1.addEventListener("click", (event) => {
        if (value > 1) {
            value = value - 1;
            button2.textContent = value;
            map.set('quantity', value);

            var amount = price * value;
            const cellText4 = document.createTextNode(formatCurrency(currencyDataset, amount));
            cell4.innerHTML = '';
            cell4.appendChild(cellText4);
            map.set('total', amount);
            map.set('stringTotal', formatCurrency(currencyDataset, amount));
        }
    });

    var button2 = document.createElement("button");
    button2.classList.add('btn', 'primary-outline-btn', 'px-4');
    button2.style.cursor = 'default';
    button2.appendChild(document.createTextNode(value));
    parent.appendChild(button2);

    var button3 = document.createElement("button");
    button3.classList.add('btn', 'primary-outline-btn', 'px-3');
    parent.appendChild(button3);
    const idiomatic2 = document.createElement('i');
    idiomatic2.classList.add('bx', 'bx-plus');
    button3.appendChild(idiomatic2);
    button3.addEventListener("click", (event) => {
        value = value + 1;
        button2.textContent = value;
        map.set('quantity', value);

        var amount = price * value;
        const cellText4 = document.createTextNode(formatCurrency(currencyDataset, amount));
        cell4.innerHTML = '';
        cell4.appendChild(cellText4);
        map.set('total', amount);
        map.set('stringTotal', formatCurrency(currencyDataset, amount));
    });

    return parent;
}

function removeProduct(unique) {
    var a = document.createElement("a");
    a.classList.add('btn');
    const x = document.createElement('i');
    x.classList.add('bx', 'bx-x', 'bx-sm');
    a.appendChild(x);
    a.setAttribute('href', baseUrlDataset + 'shop/' + unique + '/remove');
    a.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        const rows = document.querySelectorAll("#cartTable tbody tr");
        if (userDataset === 'true') {
            deleteAjax(a.href, successAlert(unique + ' removed from cart successfully'));
        } else {
            var items = JSON.parse(localStorage.getItem('items'));
            var map = new Map(Object.entries(items));
            map.delete(unique);
            localStorage.setItem('items', JSON.stringify(Object.fromEntries(map)));
            successAlert(unique + ' removed from cart successfully')
        }

        for (const row of rows) {
            if (row.getAttribute('data-unique') === unique) row.remove();
        }


    });

    return a;
}

function formatCurrency(currencyCode, amount) {
    let currency = new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: currencyCode,
    });
    return currency.format(amount);
}

function selectPaymentMehod(paymentNodes) {
    for (let i = 0; i < paymentNodes.length; i++) {
        let paymentNode = paymentNodes[i];

        paymentNode.addEventListener('change', function (e) {
            if (this.checked) {
                shoppingPaymentMethod = this.value;
            }
        });
    }
}

function emptyCart() {
    var parent = document.createElement("div");
    parent.classList.add('text-center');

    var h2 = document.createElement("h2");
    h2.classList.add('mb-3');
    h2.appendChild(document.createTextNode('Currently, your cart contains no products.'));
    parent.appendChild(h2);

    var paragraph = document.createElement("p");
    paragraph.appendChild(document.createTextNode('You can review all the products that are currently available and purchase them in the store.'));
    parent.appendChild(paragraph);

    var anchor = document.createElement("a");
    anchor.classList.add('btn', 'primary-btn');
    anchor.setAttribute('href', '/shop');
    anchor.appendChild(document.createTextNode('RETURN TO SHOP'));
    parent.appendChild(anchor);

    return parent;
}

function updateCart() {
    shoppingCartTableSubtotal = 0;

    itemArray.forEach(element => {
        shoppingCartTableSubtotal = shoppingCartTableSubtotal + parseFloat(element.get('total'));
    });

    totalTableSubtotalTd.innerHTML = '';
    totalTableTotalTd.innerHTML = '';

    totalTableSubtotalTd.appendChild(document.createTextNode(formatCurrency(currencyDataset, shoppingCartTableSubtotal)));
    shoppingCartTableTotal = shoppingCartTableSubtotal + shoppingCartTableShippingValue;
    totalTableTotalTd.appendChild(document.createTextNode(formatCurrency(currencyDataset, shoppingCartTableSubtotal)));
}

function itemArrayToJson() {
    var newItemArray = [];

    itemArray.forEach(element => {
        newItemArray.push(Object.fromEntries(element));
    });

    return JSON.stringify(newItemArray);
}



