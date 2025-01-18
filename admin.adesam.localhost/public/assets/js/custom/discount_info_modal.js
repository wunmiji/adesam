const discountInfoModal = document.getElementById("discountInfoModal");
const discountInfoModalBodyDiv = document.getElementById("discountInfoModalBodyDiv");


discountInfoModal.addEventListener("show.bs.modal", (event) => {
    const map = new Map();
    map.set('Name', event.relatedTarget.getAttribute('data-name'));
    map.set('Type', event.relatedTarget.getAttribute('data-type'));
    map.set('Value', event.relatedTarget.getAttribute('data-value'));
    map.set('Count', event.relatedTarget.getAttribute('data-count'));
    map.set('Created', event.relatedTarget.getAttribute('data-created'));

    const tbl = document.createElement("table");
    tbl.classList.add('table');
    const tblBody = document.createElement("tbody");

    map.forEach((values, keys) => {
        let row = document.createElement("tr");

        const cell1 = document.createElement("th");
        cell1.setAttribute('scope', 'row');
        const cellText1 = document.createTextNode(keys);
        cell1.appendChild(cellText1);
        row.appendChild(cell1);

        const cell2 = document.createElement("td");
        const cellText2 = document.createTextNode(values);
        cell2.appendChild(cellText2);
        row.appendChild(cell2);
        
        tblBody.appendChild(row);
    });



    tbl.appendChild(tblBody);
    discountInfoModalBodyDiv.appendChild(tbl);
});

discountInfoModal.addEventListener("hidden.bs.modal", (event) => {
    discountInfoModalBodyDiv.innerHTML = '';
});

