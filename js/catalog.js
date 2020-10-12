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
            <div class="catalog-item-pic"></div>
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
    console.log(form);
    for (let i = 0; i < form.length; i++) {
        let convertedValue = form[i].value;
        if (convertedValues.includes(form[i].value)) convertedValue = '';
        stringParameters += `&${form[i].name}=${convertedValue}`;
    }
    stringParameters = stringParameters.slice(1);
    console.log(stringParameters);
    return stringParameters
}

function regenerateSubCategories(subCategories) {
    let optionAdd = '';
    subCategories.forEach((value, index) => {
        optionAdd += `<option value="${value['parent_id']}">${value['category_name']}</option>`;
    })
    insertDataIntoElement(optionAdd, '[name=subcategory]')
}

// button.onclick = () => {}
// window.onload = () => {}
window.addEventListener('load', () => {
    let XHR = getData('/App/Controllers/Catalog/Catalog.php');
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        // console.log(data);
        let item = '';
        data.forEach((value, index) => {
            item += generateCard(value);
        });
        insertDataIntoElement(item, '.catalog');
    });
});

catalog.price.addEventListener('change', () => {
    let allParameters = getFormData('catalog');
    let XHR = getData(`/App/Controllers/Catalog/Catalog.php?${allParameters}`);
    // 1. Получить значение поля
    // let price = catalog.price.value;
    // console.log(price);
    // 2. Распарсить данные поля (разделить на два значения (integer))
    // join()
    // split()
    // price = price.split('-');
    // console.log(price);
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
    // 1. Получить значение поля
    // let price = catalog.price.value;
    // console.log(price);
    // 2. Распарсить данные поля (разделить на два значения (integer))
    // join()
    // split()
    // price = price.split('-');
    // console.log(price);
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
        regenerateSubCategories(data.category);
    });

    // 4. Получить ответ от сервера и вывести товары на экран
});

catalog.productName.addEventListener('keyup', () => {
    // 1. Получить значение поля
    let allParameters = getFormData('catalog');
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
