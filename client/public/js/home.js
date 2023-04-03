var products = 
    [{
        pID: 100, 
        name: "Acne Serum", 
        linkImage: ["https://socbabystore.com/wp-content/uploads/2021/12/237274106_3128790764032923_2509167307942027814_n.jpg"]},
    {
        pID: 100, 
        name: "Acne Serum", 
        linkImage: ["https://socbabystore.com/wp-content/uploads/2021/12/237274106_3128790764032923_2509167307942027814_n.jpg"]},
    {
        pID: 100, 
        name: "Balance Serum", 
        linkImage: ["https://balanceactiveformula.vn/wp-content/uploads/2020/10/VITC.png"]},
    {
        pID: 100, 
        name: "Balance Serum", 
        linkImage: ["https://balanceactiveformula.vn/wp-content/uploads/2020/10/VITC.png"]},
];

if (products.length < 4) console.error("It san pham qua!!!")

var divBsp = document.getElementById("bsp");
var numPage = 0;
var w = window.innerWidth;

//---------------------------------------------------------------------------
var rightBtn = document.createElement('button');
rightBtn.onclick = function() {
  rightButton();
};
rightBtn.className = "btn btn-outline-primary rounded-circle"
rightBtn.innerHTML = '<i class="fas fa-solid fa-arrow-right"></i>';
var leftBtn = document.createElement('button');
leftBtn.onclick = function() {
  leftButton();
};
leftBtn.className = "btn btn-outline-primary rounded-circle"
leftBtn.innerHTML = '<i class="fas fa-solid fa-arrow-left"></i>';

function renderBsp(){
    let divReturn = document.createElement('div');
    var numOfP = Math.min(Math.floor(Number((w - 80)/250)), 4);
    divReturn.append(leftBtn);
    for(var i = numPage; i < numOfP + numPage; i++){
        var title = products[i % products.length].name;
        var imageSrc = products[i % products.length].linkImage[0];

        var div = document.createElement("div");
        div.className = "d-inline-block bs-item";

        // Tạo thẻ card
        var card = document.createElement("div");
        card.className = "card p-2";

        // Tạo thẻ chứa ảnh
        var imageContainer = document.createElement("div");
        imageContainer.style.height = "200px";
        var image = document.createElement("img");
        image.className = "card-img-top";
        image.alt = "...";
        image.src = imageSrc;
        imageContainer.appendChild(image);

        // Tạo thẻ chứa tiêu đề và nút button
        var textContainer = document.createElement("div");
        textContainer.className = "text-center";
        var titleElement = document.createElement("h5");
        titleElement.className = "card-title";
        titleElement.textContent = title;
        var button = document.createElement("a");
        button.className = "btn btn-primary";
        button.href = "#";
        button.textContent = "Show now";
        textContainer.appendChild(titleElement);
        textContainer.appendChild(button);

        // Đưa các thẻ con vào trong thẻ card
        card.appendChild(imageContainer);
        card.appendChild(textContainer);

        // Đưa thẻ card vào trong thẻ div chứa toàn bộ nội dung
        div.appendChild(card);

        divReturn.appendChild(div);
    }
    divReturn.append(rightBtn);
    return divReturn;
}

var oldChild = renderBsp();
divBsp.appendChild(oldChild);

function leftButton()
{
    numPage = (numPage - 1 + products.length) % products.length; 
    newChild = renderBsp();
    divBsp.replaceChild(newChild, oldChild);
    oldChild = newChild;
}

function rightButton()
{
    numPage = (numPage + 1) % products.length; 
    newChild = renderBsp();
    divBsp.replaceChild(newChild, oldChild);
    oldChild = newChild;
}
