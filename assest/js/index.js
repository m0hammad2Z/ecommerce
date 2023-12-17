
var MenuItems = document.getElementById("MenuItems");
MenuItems.style.maxHeight = "0px";

function menutoggle() {
    if (MenuItems.style.maxHeight == "0px") {
        MenuItems.style.maxHeight = "200px";
    } else {
        MenuItems.style.maxHeight = "0px";
    }
}

window.onload = function () {
    // Replace the following lines with dynamic data from your backend
    var featuredProductsRow = document.getElementById("featured-products-row");
    var latestProductsRow = document.getElementById("latest-products-row");

    // Example data (you should get this from your backend)
    var featuredProductsData = [
        { image: "images/product-1.jpg", name: "Red Printed T-Shirt", rating: 4, price: "$50.00" },
        { image: "images/product-2.jpg", name: "Blue Fitness Leggings", rating: 5, price: "$40.00" },
        // Add more products as needed
    ];

    var latestProductsData = [
        { image: "images/product-5.jpg", name: "Running Shoes", rating: 4, price: "$70.00" },
        { image: "images/product-6.jpg", name: "Dumbbell Set", rating: 5, price: "$120.00" },
        // Add more products as needed
    ];

    // Function to create product elements
    function createProductElement(product) {
        var productElement = document.createElement("div");
        productElement.classList.add("col-4");

        // Create product content
        var productContent = `
            <a href="product_details.html"><img src="${product.image}"></a>
            <h4>${product.name}</h4>
            <div class="rating">
                ${Array(product.rating).fill('<i class="fa fa-star"></i>').join('')}
                ${Array(5 - product.rating).fill('<i class="fa fa-star-o"></i>').join('')}
            </div>
            <p>${product.price}</p>
        `;

        productElement.innerHTML = productContent;
        return productElement;
    }

    // Populate featured products
    featuredProductsData.forEach(function (product) {
        var productElement = createProductElement(product);
        featuredProductsRow.appendChild(productElement);
    });

    // Populate latest products
    latestProductsData.forEach(function (product) {
        var productElement = createProductElement(product);
        latestProductsRow.appendChild(productElement);
    });
};
