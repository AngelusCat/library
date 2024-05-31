let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;

let showAuthorsButtons = document.querySelectorAll('[data-type="showAuthor"]');
showAuthorsButtons.forEach(function (elem) {
    elem.onclick = function () {
        let id = elem.getAttribute('data-id');
        window.open('http://library/showAuthor/' + id, 'showAuthor', params);
    }
});
