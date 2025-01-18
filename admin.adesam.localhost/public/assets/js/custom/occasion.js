const statusDiv = document.getElementById('statusDiv');
const publishedDateDiv = document.getElementById('publishedDateDiv');



statusDiv.addEventListener('change', function(e) {
	var selectedValue = e.target.value;

	if (selectedValue == 'SCHEDULED') {
        publishedDateDiv.classList.remove('d-none');
    } else {
        publishedDateDiv.classList.add('d-none');
    }
});