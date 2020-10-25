function getData(file) {
    let XHR = new XMLHttpRequest;
    XHR.open('GET', file);
    XHR.send();
    return XHR;
}

function addItemToCart(id) {
    let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&status=add`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        console.log(data);
    });
};

function removeItemFromCart(id) {
    let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&status=remove`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        console.log(data);
    });
};

function deleteItemFromCart(id) {
    let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&status=delete`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        console.log(data);
    });
};