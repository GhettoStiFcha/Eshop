function getData(file) {
    let XHR = new XMLHttpRequest;
    XHR.open('GET', file);
    XHR.send();
    return XHR;
}

function sessionDestroy() {
    let XHR = getData(`/App/Controllers/Sessions/Account.php?status=destroy`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
    });
};

function openDestroyPopup(popupName) {
    document.getElementById(`${popupName}DestroyPopup`).style.display = 'flex';
}

function closeDestroyPopup(popupName) {
    document.getElementById(`${popupName}DestroyPopup`).style.display = 'none';
}

function emailDestroy(email, popupName) {
    let XHR = getData(`/App/Controllers/Sessions/Account.php?email=${email}`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
    });
    document.getElementById(`${popupName}DestroyPopup`).style.display = 'none';
    window.location.reload();
} 