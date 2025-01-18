const addressModal = document.getElementById('addressModal');
const addressHeaderModal = document.getElementById('address_header_modal');
const addressFormModal = document.getElementById('address_form_modal');

const firstNameInput = document.getElementById('firstNameInput');
const lastNameInput = document.getElementById('lastNameInput');
const countrySelect = document.getElementById('country');
const addressInputOne = document.getElementById('addressInputOne');
const addressInputTwo = document.getElementById('addressInputTwo');
const cityInput = document.getElementById('cityInput');
const postalCodeInput = document.getElementById('postalCodeInput');
const stateSelect = document.getElementById('state');
const emailInput = document.getElementById('emailInput');
const mobileInput = document.getElementById('mobileInput');




var countries = JSON.parse(countrySelect.dataset.countries);


//selectCountry(countrySelect, stateSelect);

loadCountries(countrySelect);

countrySelect.addEventListener('change', function (e) {
    var selectedValue = JSON.parse(e.target.value);

    stateSelect.options.length = 0;
    createDefaultOption(stateSelect, 'Select State / Province');

    for (let country of countries) {
        if (country.iso3 == selectedValue.code) {
            for (let state of country.states) {
                var stateArray = { "name": state.name, "code": state.state_code };
                var stateJson = JSON.stringify(stateArray);
                fillNode(stateSelect, state.name, stateJson);
            }
        }
    }
});


addressModal.addEventListener("show.bs.modal", (event) => {
    var title = event.relatedTarget.getAttribute('data-title');
    var action = event.relatedTarget.getAttribute('data-action');
    var method = event.relatedTarget.getAttribute('data-method');
    var type = event.relatedTarget.getAttribute('data-type');
    var cipher = event.relatedTarget.getAttribute('data-cipher');
    var addressJson = event.relatedTarget.getAttribute('data-address');

    addressHeaderModal.innerHTML = title;

    if (method === 'create')
        addressFormModal.setAttribute("action", action + '&method=' + method + '&type=' + type);
    else if (method === 'update')
        addressFormModal.setAttribute("action", action + '&method=' + method  + '&type=' + type + '&cipher=' + cipher);


    if (addressJson != null) {
        var address = JSON.parse(addressJson);

        firstNameInput.setAttribute("value", address.firstName);
        lastNameInput.setAttribute("value", address.lastName);
        iterateNode(countrySelect, address.countryCode);
        addressInputOne.setAttribute("value", address.addressOne);
        addressInputTwo.setAttribute("value", (address.addressTwo) ? address.addressTwo : '');
        cityInput.setAttribute("value", address.city);
        postalCodeInput.setAttribute("value", address.postalCode);
        emailInput.setAttribute("value", address.email);
        mobileInput.setAttribute("value", address.number);

        selectState(countrySelect, stateSelect, address.stateCode);
    }
});

addressModal.addEventListener("hidden.bs.modal", (event) => {
    firstNameInput.setAttribute("value", '');
    lastNameInput.setAttribute("value", '');
    addressInputOne.setAttribute("value", '');
    addressInputTwo.setAttribute("value", '');
    cityInput.setAttribute("value", '');
    postalCodeInput.setAttribute("value", '');
    emailInput.setAttribute("value", '');
    mobileInput.setAttribute("value", '');
    addressHeaderModal.innerHTML = '';
    addressFormModal.setAttribute("action", '');
    countrySelect.options[0].selected = true;
    stateSelect.options.length = 0;
    createDefaultOption(stateSelect, 'Select State / Province');
});



function loadCountries(countryNode) {
    for (let country of countries) {
        var stateArray = { "name": country.name, "code": country.iso3 };
        var countryJson = JSON.stringify(stateArray);

        fillNode(countryNode, country.name, countryJson);
    }
}

function selectState(countryNode, stateNode, match) {
    var selectedValue = JSON.parse(countryNode.value);

    stateNode.options.length = 0;
    createDefaultOption(stateNode, 'Select State / Province');

    for (let country of countries) {
        if (country.iso3 == selectedValue.code) {
            for (let state of country.states) {
                var stateArray = { "name": state.name, "code": state.state_code };
                var stateJson = JSON.stringify(stateArray);
                fillNode(stateNode, state.name, stateJson);
            }
        }
    }

    iterateNode(stateNode, match);
}

function fillNode(node, text, value) {
    var optionsNode = document.createElement("option");
    optionsNode.value = value;
    optionsNode.textContent = text;
    node.appendChild(optionsNode);
}

function createDefaultOption(node, content, match = null) {
    var optionNode = document.createElement("option");
    optionNode.textContent = content;
    optionNode.disabled = true;
    node.appendChild(optionNode);
    if (!match) optionNode.selected = true;
}

function iterateNode(node, match) {
    const options = [...node.options].slice(1, node.length);
    for (let option of options) {
        var countryObject = JSON.parse(option.value);
        if (countryObject.code === match) {
            option.selected = true;
        }
    }
}





