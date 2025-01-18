const tagInfoModal = document.getElementById("tagInfoModal");
const tagInfoModalBodyDiv = document.getElementById("tagInfoModalBodyDiv");


tagInfoModal.addEventListener("show.bs.modal", (event) => {
    const map = new Map();
    map.set('Name', event.relatedTarget.getAttribute('data-name'));
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
    tagInfoModalBodyDiv.appendChild(tbl);
});

tagInfoModal.addEventListener("hidden.bs.modal", (event) => {
    tagInfoModalBodyDiv.innerHTML = '';
});

