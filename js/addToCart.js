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

function getFormData(formName) {
    let form = document.forms[formName];
    let stringParameters = '';
    let convertedValues = ['Выберите размер'];
    for (let i = 0; i < form.length; i++) {
        let convertedValue = form[i].value;
        if (convertedValues.includes(form[i].value)) convertedValue = '';
        stringParameters += `&${form[i].name}=${convertedValue}`;
    }
    stringParameters = stringParameters.slice(1);
    return stringParameters
}

function addItemToCart(id) {
    let allParameters = getFormData('itemSizes');
    if (allParameters !== 'size=') {
        let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&${allParameters}&status=add`);
        XHR.addEventListener('load', function () {
            let data = JSON.parse(XHR.responseText);
        });
    } else {
        alert('Выберите размер!');
    }
};

function removeItemFromCart(id) {
    let allParameters = getFormData('itemSizes');
    if (allParameters !== 'size=') {
        let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&${allParameters}&status=remove`);
        XHR.addEventListener('load', function () {
            let data = JSON.parse(XHR.responseText);
        });
    } else {
        alert('Выберите размер!');
    }
};

function deleteItemFromCart(id, size) {
    let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&size=${size}&status=delete`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
    });
};

function addAmount(id, size) {
    let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&size=${size}&status=add`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        insertDataIntoElement(data, `#item-${id}`);
    });
    // let amount = addItemToCart(id);
}

function removeAmount(id, size) {
    let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&size=${size}&status=remove`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        insertDataIntoElement(data, `#item-${id}`);
    });
}

// function deleteAmount(id) {
//     let XHR = getData(`/App/Controllers/Sessions/Cart.php?id=${id}&status=delete`);
//     XHR.addEventListener('load', function () {
//         let data = JSON.parse(XHR.responseText);
//         this.document.getElementById(`#item-${id}`).style.display = 'none';
//     });
// }

