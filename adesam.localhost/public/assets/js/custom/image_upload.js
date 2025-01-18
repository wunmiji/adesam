const imagePreviewImg = document.getElementById("image-preview");
const userImageInput = document.getElementById('user-image-input');


userImageInput.addEventListener("change", function () {
    let file = this.files[0];
    if (file != undefined) {
        imagePreviewImg.src = URL.createObjectURL(file);
    }
});







