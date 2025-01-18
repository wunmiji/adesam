const filterBtn = document.getElementById('filter-btn');
const categoryCheckboxes = document.getElementsByName('category-checkbox');
const tagCheckboxes = document.getElementsByName('tag-checkbox');
const minPriceInput = document.getElementById('min-price-input');
const maxPriceInput = document.getElementById('max-price-input');
const sortRadios = document.getElementsByName('sort-radio');
const showRadios = document.getElementsByName('show-radio');
const applyBtn = document.getElementById('apply-btn');
const replyBtn = document.getElementById('reply-btn');



var href = '?';
var hrefCategory = '';
var hrefTag = '';
var hrefMinPrice = '';
var hrefMaxPrice = '';
var hrefSort = '';
var hrefShow = '';



var hrefCategoryArray = [];
var hrefTagArray = [];


var filterArray = filters();
filterArray.forEach(element => {
    if (element.startsWith('min-price')) {
        var elementArray = element.split('=');
        var elementValue = elementArray.pop();
        minPriceInput.value = elementValue;

        hrefMinPrice = '';
        hrefMinPrice = 'min-price=' + this.value;
    } else if (element.startsWith('max-price')) {
        var elementArray = element.split('=');
        var elementValue = elementArray.pop();
        maxPriceInput.value = elementValue;

        hrefMaxPrice = '';
        hrefMaxPrice = 'max-price=' + this.value;
    } else if (element.startsWith('category')) {
        var elementArray = element.split('=');
        var elementValues = elementArray.pop().split(',');
        elementValues.forEach(elementValue => {
            for (let i = 0; i < categoryCheckboxes.length; i++) {
                let checkbox = categoryCheckboxes[i];

                if (checkbox.value == elementValue) {
                    hrefCategoryArray.push(elementValue);
                    checkbox.checked = true;

                    hrefCategory = '';
                    hrefCategory = 'category=' + hrefCategoryArray.join(',');
                }
            }
        });
    } else if (element.startsWith('tag')) {
        var elementArray = element.split('=');
        var elementValues = elementArray.pop().split(',');
        elementValues.forEach(elementValue => {
            for (let i = 0; i < tagCheckboxes.length; i++) {
                let checkbox = tagCheckboxes[i];

                if (checkbox.value == elementValue) {
                    hrefTagArray.push(elementValue);
                    checkbox.checked = true;

                    hrefTag = '';
                    hrefTag = 'tag=' + hrefTagArray.join(',');
                }
            }
        });
    } else if (element.startsWith('sort')) {
        var elementArray = element.split('=');
        var elementValue = elementArray.pop();
        for (let i = 0; i < sortRadios.length; i++) {
            let radio = sortRadios[i];

            if (radio.value == elementValue) {
                radio.checked = true;

                hrefSort = '';
                hrefSort = 'sort=' + elementValue;
            }
        }
    } else if (element.startsWith('limit')) {
        var elementArray = element.split('=');
        var elementValue = elementArray.pop();
        for (let i = 0; i < showRadios.length; i++) {
            let radio = showRadios[i];

            if (radio.value == elementValue) {
                radio.checked = true;

                hrefShow = '';
                hrefShow = 'limit=' + elementValue;
            }
        }
    }
});
applyAction();



for (let i = 0; i < categoryCheckboxes.length; i++) {
    let categoryCheckbox = categoryCheckboxes[i];

    categoryCheckbox.addEventListener('change', function (e) {
        if (this.checked) {
            hrefCategoryArray.push(this.value);
        } else {
            var index = hrefCategoryArray.indexOf(this.value);
            if (index > -1) { // only splice array when item is found
                hrefCategoryArray.splice(index, 1); // 2nd parameter means remove one item only
            }
        }

        hrefCategory = '';
        hrefCategory = 'category=' + hrefCategoryArray.join(',');

        applyAction();
    });
}

minPriceInput.addEventListener('keyup', function (e) {
    if (this.value.length > 0) {
        hrefMinPrice = '';
        hrefMinPrice = 'min-price=' + this.value;

        applyAction();
    }
});

maxPriceInput.addEventListener('keyup', function (e) {
    if (this.value.length > 0) {
        hrefMaxPrice = '';
        hrefMaxPrice = 'max-price=' + this.value;

        applyAction();
    }
});

for (let i = 0; i < tagCheckboxes.length; i++) {
    let tagCheckbox = tagCheckboxes[i];

    tagCheckbox.addEventListener('change', function (e) {
        if (this.checked) {
            hrefTagArray.push(this.value);
        } else {
            var index = hrefTagArray.indexOf(this.value);
            if (index > -1) { // only splice array when item is found
                hrefTagArray.splice(index, 1); // 2nd parameter means remove one item only
            }
        }

        hrefTag = '';
        hrefTag = 'tag=' + hrefTagArray.join(',');

        applyAction();
    });
}

for (let i = 0; i < sortRadios.length; i++) {
    let sortRadio = sortRadios[i];

    sortRadio.addEventListener('change', function (e) {
        if (this.checked) {
            hrefSort = '';
            hrefSort = 'sort=' + this.value;

            applyAction();
        }
    });
}

for (let i = 0; i < showRadios.length; i++) {
    let showRadio = showRadios[i];

    showRadio.addEventListener('change', function (e) {
        if (this.checked) {
            hrefShow = '';
            hrefShow = 'limit=' + this.value;

            applyAction();
        }
    });
}

replyBtn.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();

    for (let i = 0; i < categoryCheckboxes.length; i++) {
        let checkbox = categoryCheckboxes[i];

        checkbox.checked = false;
    }
    minPriceInput.value = '';
    maxPriceInput.value = '';
    for (let i = 0; i < tagCheckboxes.length; i++) {
        let checkbox = tagCheckboxes[i];

        checkbox.checked = false;
    }
    for (let i = 0; i < sortRadios.length; i++) {
        let radio = sortRadios[i];

        radio.checked = false;
    }
    for (let i = 0; i < showRadios.length; i++) {
        let radio = showRadios[i];

        radio.checked = false;
    }

    applyBtn.href = baseUrlDataset + 'shop';
});

function applyAction() {
    const arrayQuery = [hrefCategory, hrefTag, hrefMinPrice, hrefMaxPrice, hrefSort, hrefShow];

    const newArrayQuery = [];
    for (let i = 0; i < arrayQuery.length; i++) {
        if (arrayQuery[i] !== undefined && arrayQuery[i] !== null && arrayQuery[i] !== "") {
            newArrayQuery.push(arrayQuery[i]);
        }
    }

    applyBtn.href = href + newArrayQuery.join('&');
}

function onlyNumberKey(evt) {

    // Only ASCII character in that range allowed
    let ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function filters() {
    var queryString = filterBtn.dataset.queryString;
    var queryStringArray = queryString.split('&');

    console.log(queryString);

    return queryStringArray;
}




