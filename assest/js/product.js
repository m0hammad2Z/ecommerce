document.addEventListener('DOMContentLoaded', function () {
    // Fetch product data from your PHP script
    fetch('get_products.php')
        .then(response => response.json())
        .then(productsList => {
            // Get a reference to the product container
            var productsContainer = document.getElementById('product-container');

            // Clear any existing content in the product container
            productsContainer.innerHTML = '';

            // Loop through the products and dynamically add them to the container
            productsList.forEach(function (product) {
                var productHTML = `
                    <div class="col-4">
                        <a href="product_details.php?id=${product.id}"><img src="images/${product.image}" alt="${product.name}"></a>
                        <h4>${product.name}</h4>
                        <div class="rating">
                            <!-- Add your star rating logic here if needed -->
                        </div>
                        <p>$${product.price.toFixed(2)}</p>
                        <button onclick="addToCart('${product.name}', ${JSON.stringify(product)})">Add to Cart</button>
                    </div>`;
                productsContainer.innerHTML += productHTML;
            });
        })
        .catch(error => console.error('Error fetching product data:', error));

    // Function to add a product to the cart
    window.addToCart = function (productName, productData) {
        // Retrieve existing cart data from localStorage or initialize an empty array
        var cartItems = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if the product is already in the cart
        var existingProduct = cartItems.find(item => item.name === productName);

        if (existingProduct) {
            // If the product is already in the cart, you may want to update the quantity or handle it as needed
            console.log('Product already in the cart:', existingProduct);
        } else {
            // If the product is not in the cart, add it
            cartItems.push({ name: productName, data: productData });

            // Save the updated cart data back to localStorage
            localStorage.setItem('cart', JSON.stringify(cartItems));

            console.log('Product added to the cart:', { name: productName, data: productData });
        }
    };
});