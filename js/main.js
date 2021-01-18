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
        <div class="main-grid-item" style="background-image: url(${data.img_url})">
            <p class="p-text">${data.img_sub}</p>
            <p class="p-italic">${data.img_description}</p>
        </div>
        `;

    return item;
}

window.addEventListener('load', () => {
    let XHR = getData('/App/Controllers/Sessions/Main.php');
    XHR.addEventListener('load', function () {
        let data = JSON.parse(XHR.responseText);
        // console.log(data);
        let item = '';
        data.forEach((value, index) => {
            item += generateCard(value);
        });
        insertDataIntoElement(item, '.main-grid');
    });
});