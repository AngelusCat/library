let numberOfBooks = document.getElementById('numberOfBooks');
let updateNumberOfBooksButton = document.getElementById('updateNumberOfBooks');
let id = updateNumberOfBooksButton.getAttribute('data-id');
updateNumberOfBooksButton.addEventListener('click', function () {
    let promise = fetch('/test/' + id).then(function (response) {
        response.text().then(function (text) {
            numberOfBooks.textContent = text;
        });
    });
});
