const filesModal = document.getElementById("filesModal");
const filesModalBodyDiv = document.getElementById("filesModalBodyDiv");
const foldersModalBodyLink = document.getElementsByClassName("folders-modal-body-link");
const addFilesModalButton = document.getElementById("addFilesModalButton");
const dropzoneDiv = document.getElementById("dropzone");
const dropszoneDiv = document.getElementById("dropszone");
const fileText = document.getElementById("fileText");
const filesText = document.getElementById("filesText");
const filesModalBreadCrumbOl = document.getElementById("filesModalBreadCrumb");
const filesModalPlacesFavourite = document.getElementById("filesModalPlacesFavourite");
const filesModalPlacesDiv = document.getElementById("filesModalPlaces");
const fileHiddenInput = document.getElementById("fileHidden");
const filesHiddenInput = document.getElementById("filesHidden");

var dataUploadedFileDiv;
var dataMultiple;
var dataFileManager;

var styles = ['border', 'border-5', 'p-3'];

if (fileText !== null) fileText.textContent = 'Click to upload featured Image';
if (filesText !== null) filesText.textContent = 'Click to upload files';
if (fileHiddenInput !== null && fileHiddenInput.length !== 0) {
    let fileHiddenInputValue = fileHiddenInput.value;
    let fileObject = JSON.parse(fileHiddenInputValue);

    let map = new Map();
    map.set('id', fileObject.id);
    map.set('fileId', fileObject.fileId);

    let myObj = Object.fromEntries(map);
    let json = JSON.stringify(myObj);

    dataUploadedFileDiv = document.getElementById(dropzoneDiv.dataset.output)
    dataMultiple = dropzoneDiv.dataset.multiple;
    createUploadedFile(dataUploadedFileDiv, fileObject.fileName, dataMultiple, json);
}
if (filesHiddenInput !== null && filesHiddenInput.length !== 0) {
    let filesHiddenInputValue = filesHiddenInput.value;
    let filesObject = JSON.parse(filesHiddenInputValue);

    Object.values(filesObject).forEach(fileObject => {
        let map = new Map();
        map.set('id', fileObject.id);
        map.set('fileId', fileObject.fileId);

        let myObj = Object.fromEntries(map);
        let json = JSON.stringify(myObj);

        dataUploadedFileDiv = document.getElementById(dropszoneDiv.dataset.output);
        dataMultiple = dropszoneDiv.dataset.multiple;
        createUploadedFile(dataUploadedFileDiv, fileObject.fileName, dataMultiple, json);
    });
}


filesModal.addEventListener("show.bs.modal", (event) => {
    dataUploadedFileDiv = document.getElementById(event.relatedTarget.getAttribute('data-output'));
    dataFileManager = event.relatedTarget.getAttribute('data-file-manager');
    dataMultiple = event.relatedTarget.getAttribute('data-multiple');

    getAjax(baseUrlDataset + 'file-manager/' + dataFileManager,
        function (output) {
            var dataFileManagerJson = JSON.parse(output);
            var dataFileManagerJsonFiles = dataFileManagerJson.files;
            var dataFileManagerJsonBreadCrumb = dataFileManagerJson.breadcrumb;


            createBreadCrumb(dataFileManagerJsonBreadCrumb);

            Object.values(dataFileManagerJsonFiles).forEach((object) => {
                var createPlacesIcon = '';
                if (object.name == 'Home') createPlacesIcon = 'bx-home';
                if (object.name == 'Documents') createPlacesIcon = 'bx-file';
                if (object.name == 'Videos') createPlacesIcon = 'bxs-videos';
                if (object.name == 'Pictures') createPlacesIcon = 'bx-images';
                if (object.name == 'Shop') createPlacesIcon = 'bx-store';
                createPlaces(object, createPlacesIcon);
            });
        }
    );

});

filesModal.addEventListener("hidden.bs.modal", (event) => {
    filesModalBreadCrumbOl.innerHTML = "";
    filesModalPlacesDiv.innerHTML = "";
    filesModalBodyDiv.innerHTML = '';
});

addFilesModalButton.onclick = (event) => {
    var children = filesModalBodyDiv.children;
    for (let j = 0; j < children.length; j++) {
        if (children[j].classList.contains(...styles)) {
            var id = children[j].dataset.fileId;
            var name = children[j].dataset.name;

            let map = new Map();
            map.set('fileId', id);

            let myObj = Object.fromEntries(map);
            let json = JSON.stringify(myObj);

            if (eval(dataMultiple) === false) dataUploadedFileDiv.innerHTML = '';
            createUploadedFile(dataUploadedFileDiv, name, dataMultiple, json);
        }
    }

    var modalInstance = bootstrap.Modal.getInstance(filesModal)
    modalInstance.hide();
}

clickFolder(filesModalPlacesFavourite, 'Favourite');

function createUploadedFile(dataUploadedFileDiv, name, multiple, json) {
    const parent = document.createElement('div');
    parent.classList.add('mt-2', 'py-1', 'd-flex', 'justify-content-between', 'align-items-center');
    dataUploadedFileDiv.appendChild(parent);

    const span = document.createElement('span');
    span.textContent = name;
    parent.appendChild(span);

    const button = document.createElement('button');
    button.classList.add('btn', 'px-0');
    button.addEventListener("click", (event) => {
        event.stopPropagation();
        event.preventDefault();

        dataUploadedFileDiv.removeChild(parent);
    });
    parent.appendChild(button);
    const i = document.createElement('i');
    i.classList.add('bx', 'bx-x', 'bx-sm');
    button.appendChild(i);

    var inputId = document.createElement("input");
    inputId.setAttribute("type", "hidden");
    inputId.setAttribute("value", json);
    if (eval(multiple) === true) inputId.setAttribute("name", 'files[]');
    else inputId.setAttribute("name", 'file');
    parent.appendChild(inputId);
}

function createFileDiv(file, multiple) {
    if (file.isDirectory) {
        var parent = createParentDiv(filesModalBodyDiv, file, multiple);

        createFolder(parent, file)
    } else {
        if (eval(multiple) === false) {
            if (file.mimetype.startsWith('image')) {
                var parent = createParentDiv(filesModalBodyDiv, file, multiple);

                createImage(parent, file)
            };
        } else {
            if (file.mimetype.startsWith('image')) {
                var parent = createParentDiv(filesModalBodyDiv, file, multiple);
                createImage(parent, file);
            }
            else if (file.mimetype.startsWith('video')) {
                var parent = createParentDiv(filesModalBodyDiv, file, multiple);
                createVideo(parent, file);
            }
        }
    }



}

function createParentDiv(filesModalBodyDiv, file, multiple) {
    const parent = document.createElement('div');
    parent.classList.add('card', 'shadow-none', 'h-100');
    parent.setAttribute("data-file-id", file.id);
    parent.setAttribute("data-name", file.name);
    filesModalBodyDiv.appendChild(parent);

    parent.addEventListener('click', function () {
        if (file.isDirectory) {
            clickFolder(parent, file.privateId);
        } else {
            if (eval(multiple) === true) {
                if (parent.classList.contains(...styles)) parent.classList.remove(...styles);
                else parent.classList.add(...styles);
            } else {
                if (parent.classList.contains(...styles)) parent.classList.remove(...styles);
                else {
                    for (let j = 0; j < filesModalBodyDiv.children.length; j++) {
                        filesModalBodyDiv.children[j].classList.remove(...styles);
                    }
                    parent.classList.add(...styles);
                }
            }
        }
    });

    return parent;
}

function createFolder(parent, file) {
    var div = document.createElement('div');
    div.classList.add('d-flex', 'justify-content-center', 'w-100', 'h-100');
    div.innerHTML = '<i class="bx bx-folder" style="font-size: 8rem;"></i>';
    parent.appendChild(div);

    cardBody(parent, file.name);
}

function createImage(parent, file) {
    var img = new Image();
    img.classList.add('rounded-0', 'object-fit-cover', 'w-100', 'h-100');
    img.src = file.urlPath;
    parent.appendChild(img);

    cardBody(parent, file.name);
}

function createVideo(parent, file) {
    var video = document.createElement('video');
    video.classList.add('rounded-0', 'object-fit-cover', 'w-100', 'h-100');
    video.src = file.urlPath;
    video.controls = false;
    parent.appendChild(video);

    cardBody(parent, file.name);
}

function cardBody(parent, fileName) {
    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body', 'px-0', 'mx-auto', 'text-center');
    parent.appendChild(cardBody);
    const small = document.createElement('small');
    small.classList.add('card-text');
    small.innerText = fileName;
    cardBody.appendChild(small);
}

function createPlaces(object, createPlacesIcon) {
    var link = document.createElement('a');
    link.innerHTML = '<i class="bx ' + createPlacesIcon + '" style="font-size: 1.25rem;"></i> ' + object.name;
    link.classList.add('d-flex', 'align-items-center', 'column-gap-2', 'fs-6', 'gray-link-color');
    filesModalPlacesDiv.appendChild(link);

    clickFolder(link, object.privateId);
}

function createBreadCrumb(json) {
    const jsonMap = new Map();
    Object.entries(json).forEach(([key, value]) => {
        jsonMap.set(key, value);
    });

    var jsonMapArray = Array.from(jsonMap);
    var jsonMapArrayLast = jsonMapArray.shift();


    filesModalBreadCrumbOl.innerHTML = "";
    jsonMapArray.forEach(element => {
        var li = document.createElement('li');
        li.classList.add('breadcrumb-item');
        filesModalBreadCrumbOl.appendChild(li);

        var link = document.createElement('a');
        link.innerText = element[1];
        link.classList.add('py-1', 'px-2');
        link.setAttribute('style', 'background-color: rgba(185, 187, 189, 0.2)');
        li.appendChild(link);

        clickFolder(li, element[0]);
    });

    var li = document.createElement('li');
    li.classList.add('breadcrumb-item');
    li.innerText = jsonMapArrayLast[1];
    filesModalBreadCrumbOl.appendChild(li);

}


function clickFolder(link, privateId) {
    link.onclick = (event) => {
        filesModalBodyDiv.innerHTML = "";
        getAjax(baseUrlDataset + 'file-manager/' + privateId,
            function (output) {
                var clickJson = JSON.parse(output);
                var clickJsonFiles = clickJson.files;
                var clickJsonBreadCrumb = clickJson.breadcrumb;

                createBreadCrumb(clickJsonBreadCrumb);

                if (dataFileManager != privateId) {
                    Object.values(clickJsonFiles).forEach((object) => {
                        createFileDiv(object, dataMultiple)
                    });
                }

            }
        );
    }
}




