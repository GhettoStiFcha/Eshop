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

function generateCard(data) {
    let item = `
        <div class="catalog-item">
            <div class="catalog-item-pic" style="background-image: url(${data.image_url})"></div>
            <div class="catalog-item-name">${data.name}</div>
            <div class="catalog-item-price">${data.price} руб.</div>
            <a href="/pages/catalog/item/?id=${data.id}" class="more-btn">ПОДРОБНЕЕ</a>
        </div>
        `;

    return item;
}

function getFormData(formName) {
    let form = document.forms[formName];
    let stringParameters = '';
    let convertedValues = ['Выберите стоимость', 'Выберите категорию', 'Выберите подкатегорию'];
    // console.log(form);
    for (let i = 0; i < form.length; i++) {
        let convertedValue = form[i].value;
        if (convertedValues.includes(form[i].value)) convertedValue = '';
        stringParameters += `&${form[i].name}=${convertedValue}`;
    }
    stringParameters = stringParameters.slice(1);
    // console.log(stringParameters);
    return stringParameters
}

function regenerateSubCategories(subCategories) {
    let optionAdd = `<option hidden>Выберите подкатегорию</option>`;
    subCategories.forEach((value, index) => {
        optionAdd += `<option value="${value['id']}">${value['category_name']}</option>`;
    })
    insertDataIntoElement(optionAdd, '[name=subcategory]')
}

let strGET = window.location.search.replace('?', '');
// button.onclick = () => {}
// window.onload = () => {}
window.addEventListener('load', () => {
    if (strGET != '') {
        // console.log(strGET);
        let XHR = getData(`/App/Controllers/Catalog/Catalog.php?${strGET}`);
        XHR.addEventListener('load', function () {
            let data = JSON.parse(XHR.responseText);
            let item = '';
            data.items.forEach((value, index) => {
                item += generateCard(value);
            });
            insertDataIntoElement(item, '.catalog');
        });
    } else {
        let XHR = getData('/App/Controllers/Catalog/Catalog.php');
        XHR.addEventListener('load', function () {
            let data = JSON.parse(XHR.responseText);
            let item = '';
            data.forEach((value, index) => {
                item += generateCard(value);
            });
            insertDataIntoElement(item, '.catalog');
        });
    }
});

catalog.price.addEventListener('change', () => {
    let allParameters = getFormData('catalog');
    let price = catalog.price.value;
    // console.log(price);
    price = price.split('-');
    let XHR = getData(`/App/Controllers/Catalog/Catalog.php?${allParameters}&min=${price[0]}&max=${price[1]}`);
    // 3. Сделать запрос на сервер
    // let XHR = getData(`/App/Controllers/Catalog/Catalog.php?min=${price[0]}&max=${price[1]}`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        console.log(data);
        let item = '';
        data.items.forEach((value, index) => {
            item += generateCard(value);
        });
        insertDataIntoElement(item, '.catalog');
    });
    // 4. Получить ответ от сервера и вывести товары на экран
});

catalog.category.addEventListener('change', () => {
    let allParameters = getFormData('catalog');
    let XHR = getData(`/App/Controllers/Catalog/Catalog.php?${allParameters}`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        // console.log(data);
        let item = '';
        data.items.forEach((value, index) => {
            item += generateCard(value);
        });
        insertDataIntoElement(item, '.catalog');
        regenerateSubCategories(data.category);
    });
});

catalog.subcategory.addEventListener('change', () => {
    let allParameters = getFormData('catalog');
    let XHR = getData(`/App/Controllers/Catalog/Catalog.php?${allParameters}`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        // console.log(data);
        let item = '';
        data.items.forEach((value, index) => {
            item += generateCard(value);
        });
        insertDataIntoElement(item, '.catalog');
    });
});

catalog.productName.addEventListener('keyup', () => {
    // 1. Получить значение поля
    let allParameters = getFormData('catalog');
    // console.log(allParameters);
    // console.log(productName);
    let XHR = getData(`/App/Controllers/Catalog/Catalog.php?${allParameters}`);
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        console.log(data);
        let item = '';
        data.items.forEach((value, index) => {
            item += generateCard(value);
        });
        insertDataIntoElement(item, '.catalog');
    });
});
