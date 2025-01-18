const plusButton = document.getElementById('plus-button');
const additionalInformationsDiv = document.getElementById('div-additionalInformations');
const additionalInformationsHiddenInput = document.getElementById('additionalInformationsHidden');


if (additionalInformationsHiddenInput.value !== null && additionalInformationsHiddenInput.value.length !== 0) {
    let additionalInformationsHiddenInputValues = JSON.parse(additionalInformationsHiddenInput.value);

    if (additionalInformationsHiddenInputValues.length !== 0) {
        Object.values(additionalInformationsHiddenInputValues).forEach(values => {
            createCustomLabels(values['field'], values['label'], values['id'], true);
        });
    } else createCustomLabels('', '', null, false);
} else createCustomLabels('', '', null, false);

plusButton.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();

    createCustomLabels('', '', null, true);
});

function createCustomLabels(field, label, id, addButton) {
    const parent = document.createElement('div');
    parent.classList.add('d-flex', 'column-gap-4', 'mb-4');
    parent.setAttribute("name", "div-additional-information");
    additionalInformationsDiv.appendChild(parent);

    var fieldInput = document.createElement("input");
    fieldInput.setAttribute("type", "text");
    fieldInput.setAttribute("value", field);
    fieldInput.classList.add('form-control');
    fieldInput.setAttribute("placeholder", "Enter Field");
    parent.appendChild(fieldInput);

    var labelInput = document.createElement("input");
    labelInput.setAttribute("type", "text");
    labelInput.setAttribute("value", label);
    labelInput.classList.add('form-control');
    labelInput.setAttribute("placeholder", "Enter Label");
    parent.appendChild(labelInput);

    var hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("value", id);
    parent.appendChild(hiddenInput);

    if (addButton === true) {
        const button = document.createElement('button');
        button.classList.add('btn', 'px-0');
        button.addEventListener("click", (event) => {
            event.stopPropagation();
            event.preventDefault();

            additionalInformationsDiv.removeChild(parent);
        });
        parent.appendChild(button);

        const i = document.createElement('i');
        i.classList.add('bx', 'bx-x', 'bx-sm', 'ms-auto');
        button.appendChild(i);
    }


}


function isEmpty(value) {
    return (value == null || (typeof value === "string" && value.trim().length === 0));
}

function saveContent() {
    const additionalInformationsArray = [];
    const additionalInformationDiv = document.getElementsByName('div-additional-information');
    for (let i = 0; i < additionalInformationDiv.length; i++) {
        let additionalInformation = additionalInformationDiv[i];

        let field = additionalInformation.children[0].value;
        let label = additionalInformation.children[1].value;
        let id = additionalInformation.children[2].value;

        if (!isEmpty(field) && !isEmpty(label)) {
            var additionalInformationArray = { "id": id === 'null' ? null : id, "field": field, "label": label };
            additionalInformationsArray.push(additionalInformationArray);
        }

    }

    let jsonData = JSON.stringify(additionalInformationsArray);
    additionalInformationsHiddenInput.value = jsonData;
}

