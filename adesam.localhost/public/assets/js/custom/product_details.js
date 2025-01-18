const productFeaturedImage = document.getElementById('product-featured-image');
const productImages = document.getElementsByName('product-image');
const minusBtn = document.getElementById('minus-btn');
const plusBtn = document.getElementById('plus-btn');
const quantityButton = document.getElementById('quantity');
const addToCartAnchor = document.getElementById('addToCart');
const enquiryForm = document.getElementById('enquiry-form');
const submitEnquiry = document.getElementById('submit-enquiry');

var currencyDataset = addToCartAnchor.dataset.currency;
var productUnique = addToCartAnchor.dataset.productUnique;
var productName = addToCartAnchor.dataset.productName;


for (let i = 0; i < productImages.length; i++) {
    let productImage = productImages[i];

    productImage.addEventListener("click", (event) => {

        productFeaturedImage.src = productImage.src;
        productFeaturedImage.alt = productImage.alt;
    });

}

var swiper = new Swiper(".product-image-swiper", {
    slidesPerView: 4,
    spaceBetween: 16,

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});


minusBtn.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();

    if (quantityButton.textContent > 1) {
        quantityButton.textContent = parseInt(quantityButton.textContent) - 1;
    }
});

plusBtn.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();

    quantityButton.textContent = parseInt(quantityButton.textContent) + 1;
});


addToCartAnchor.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();

    var quantity = parseInt(quantityButton.textContent);

    if (userDataset === 'true') {
        const formData = new FormData();
        formData.append('quantity', quantity);
        formData.append('productUnique', productUnique);

        postAjax(baseUrlDataset + 'shop/cart', formData,
            function (output) {
                successAlert('&quot;' + productName + '&quot;' + ' has been added to your cart');
            },
            function (jqXHR, textStatus, errorThrown) {
                errorAlert('An error occur when adding ' + productName + '&quot;' + ' to your cart');
            }
        );

    } else {
        var productId = addToCartAnchor.dataset.productId;
        var productPrice = addToCartAnchor.dataset.productPrice;
        var productImageSrc = addToCartAnchor.dataset.productImageSrc;
        var productImageAlt = addToCartAnchor.dataset.productImageAlt;
        var stringProductPrice = addToCartAnchor.dataset.stringProductPrice;

        localStorage.setItem('shippingType', 'LOCAL_PICKUP');
        localStorage.setItem('paymentMethod', 'CREDIT_CARD');

        var items = JSON.parse(localStorage.getItem('items'));
        if (items == null) {
            var map = new Map();
            map.set('productId', productId);
            map.set('quantity', quantity);
            map.set('productName', productName);
            map.set('productUnique', productUnique);
            map.set('productPrice', productPrice);
            map.set('fileSrc', productImageSrc);
            map.set('fileAlt', productImageAlt);
            map.set('stringProductPrice', stringProductPrice);
            map.set('total', quantity * parseFloat(productPrice));
            map.set('stringTotal', formatCurrency(currencyDataset, quantity * parseFloat(productPrice)));

            var mapList = new Map();
            mapList.set(productUnique, Object.fromEntries(map));

            localStorage.setItem('items', JSON.stringify(Object.fromEntries(mapList)));

        } else {
            var mapList = new Map(Object.entries(items));
            var localObject = mapList.get(productUnique);
            if (localObject == null) {
                var map = new Map();
                map.set('productId', productId);
                map.set('quantity', quantity);
                map.set('productName', productName);
                map.set('productUnique', productUnique);
                map.set('productPrice', productPrice);
                map.set('fileSrc', productImageSrc);
                map.set('fileAlt', productImageAlt);
                map.set('stringProductPrice', stringProductPrice);
                map.set('total', quantity * parseFloat(productPrice));
                map.set('stringTotal', formatCurrency(currencyDataset, quantity * parseFloat(productPrice)));

                mapList.set(productUnique, Object.fromEntries(map));

            } else {
                localObject.quantity = parseInt(localObject.quantity) + quantity;
                mapList.set(productUnique, localObject);
            }

            localStorage.setItem('items', JSON.stringify(Object.fromEntries(mapList)));

        }

        successAlert('&quot;' + productName + '&quot;' + ' has been added to your cart');


    }



});

submitEnquiry.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();

    var formData = getFormData(enquiryForm);

    postAjax(enquiryForm.action, formData,
        function (output) {
            successAlert('Your enquiry submitted successfully');
        },
        function (jqXHR, textStatus, errorThrown) {
            errorAlert('An error occur when submitting enquiry' );
        }
    );

});


function formatCurrency(currencyCode, amount) {
    let currency = new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: currencyCode,
    });
    return currency.format(amount);
}

function getFormData(object) {
    const formData = new FormData();
    Object.values(object).forEach(item => {
        formData.append(item.name, item.value);
    });
    formData.delete('submit');
    return formData;
}


