const htmlDocument = document.documentElement;
const totalCartSpan = document.getElementById('totalCart');


var baseUrlDataset = htmlDocument.dataset.baseUrl;
var userDataset = htmlDocument.dataset.user;
var userIdDataset = htmlDocument.dataset.userId;

htmlDocument.setAttribute('data-bs-theme',
    (sessionStorage.getItem('data-bs-theme') == null) ? 'light' : sessionStorage.getItem('data-bs-theme')
);


if (userDataset === 'true') {
    var cart;
    getAjax(baseUrlDataset + 'shop/cart',
        function (output) {
            cart = JSON.parse(output);
            var total = Object.keys(cart.items).length;
            totalCartSpan.appendChild(document.createTextNode(total));
        }
    );

    const logoutAnchor = document.getElementById('logout');

    logoutAnchor.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        getAjax(baseUrlDataset + 'shop/cart',
            function (output) {
                var cart = JSON.parse(output);

                localStorage.clear();
                localStorage.setItem('shippingType', cart.shippingType);
                localStorage.setItem('paymentMethod', cart.paymentMethod);
                localStorage.setItem('items', JSON.stringify(cart.items));

                setTimeout(function () {
                    window.location.href = baseUrlDataset + 'logout';
                }, 50);

            }
        );


    });

} else {
    var itemsJson = localStorage.getItem('items');
    if (itemsJson == null) totalCartSpan.appendChild(document.createTextNode(0));
    else {
        var items = JSON.parse(itemsJson);
        var total = Object.keys(items).length;
        totalCartSpan.appendChild(document.createTextNode(total));
    }

}


function dataBsTheme(x) {
    if (htmlDocument.getAttribute('data-bs-theme') == 'light') {
        sessionStorage.setItem("data-bs-theme", "dark");
        htmlDocument.setAttribute('data-bs-theme', sessionStorage.getItem('data-bs-theme'));
    } else {
        sessionStorage.setItem("data-bs-theme", "light");
        htmlDocument.setAttribute('data-bs-theme', sessionStorage.getItem('data-bs-theme'));
    }

    if (x.classList.contains('bxs-moon')) {
        x.classList.remove('bxs-moon');
        x.classList.add('bx-sun');
    } else {
        x.classList.remove('bx-sun');
        x.classList.add('bxs-moon');
    }

}

function searchValidation(id) {
    var textField = document.getElementById(id);
    var x = textField.value.trim();

    if (x === '') return false;
    else return true;
}

function getAjax(url, handleData) {
    $.ajax({
        url: url,
        success: function (data) {
            handleData(data);
        }
    });
}

function deleteAjax(url, success) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            console.log(data);
            if (data === true) success;
        }
    });
}

function postAjax(url, formData, success, error) {
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            success(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            error(jqXHR, textStatus, errorThrown);
        }
    });
}

function successAlert(message) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    return toastr.success(message);
}

function errorAlert(message) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    return toastr.error(message);
}


