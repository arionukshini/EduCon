var dropdownContent = document.getElementById('dropdown');
var isClicked = false;

function showDropdown() {
    if (!isClicked) {
        dropdownContent.style.display = 'block';
    }
}

function hideDropdown() {
    if (!isClicked) {
        dropdownContent.style.display = 'none';
    }
}

function toggleDropdown() {
    isClicked = !isClicked;
    dropdownContent.style.display = isClicked ? 'block' : 'none';
}
