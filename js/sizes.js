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

window.addEventListener('load', () => {
    let XHR = getData('/App/Controllers/Catalog/Catalog.php');
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        console.log(data);
        // generateSizes(data.itemSizes);
    });
});


