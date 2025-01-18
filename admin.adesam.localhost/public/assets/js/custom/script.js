const htmlDocument = document.documentElement;


var baseUrlDataset = htmlDocument.dataset.baseUrl;

function asideFunction() {
    var x = document.getElementById("wrapper");
    x.classList.toggle("toggled");
}

function getAjax(url, handleData) {
    console.log(url);
    $.ajax({
        url: url,
        success: function (data) {
            handleData(data);
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



