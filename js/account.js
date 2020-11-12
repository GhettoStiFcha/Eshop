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