function insertDataIntoElement(text, element) {
    let resultElement = document.querySelector(element);
    resultElement.innerHTML = text;
};

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

function addAmount(id) {
    let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&status=add`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        insertDataIntoElement(data, `#item-${id}`);
    });
    // let amount = addItemToCart(id);
}

function removeAmount(id) {

}