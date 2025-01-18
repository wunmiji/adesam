const itemsHidden = document.getElementById('items');
const shippingTypeHidden = document.getElementById('shipping-type');
const paymentMethodHidden = document.getElementById('payment-method');
const submitBtn = document.getElementById('submit');


submitBtn.addEventListener('click', function (event) {
    if(localStorage.getItem('items') != null) {
        shippingTypeHidden.setAttribute("value", localStorage.getItem('shippingType'));
        paymentMethodHidden.setAttribute("value", localStorage.getItem('paymentMethod'));
        itemsHidden.setAttribute("value", localStorage.getItem('items'));

        localStorage.clear();
    } 

});





