let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;

let createButton = document.querySelector('[data-type="create"]');
createButton.onclick = function () {
    window.open('http://library/addBook', 'create', params);
}

let editButtons = document.querySelectorAll('[data-type="edit"]');
editButtons.forEach(function (elem) {
    elem.onclick = function () {
        let id = elem.getAttribute('data-id');
        window.open('http://library/editBook/' + id, 'edit', params);
    }
});

let deleteButtons = document.querySelectorAll('[data-type="delete"]');
deleteButtons.forEach(function (elem) {
    elem.onclick = function () {
        let id = elem.getAttribute('data-id');
        window.open('http://library/deleteBook/' + id, 'delete', params);
    }
});

let showButtons = document.querySelectorAll('[data-type="show"]');
showButtons.forEach(function (elem) {
    elem.onclick = function () {
        let id = elem.getAttribute('data-id');
        window.open('http://library/showBook/' + id, 'show', params);
    }
});
