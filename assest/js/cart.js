
var MenuItems = document.getElementById("MenuItems");
MenuItems.style.maxHeight = "0px";
function menutoggle() {
    if (MenuItems.style.maxHeight == "0px") {
        MenuItems.style.maxHeight = "200px"
    }
    else {
        MenuItems.style.maxHeight = "0px"
    }
}
    // Check if there are items in the local storage
    var cartItems = localStorage.getItem("cartItems");

    // If there are items, parse them from JSON format
    if (cartItems) {
        cartItems = JSON.parse(cartItems);
    } else {
        // If no items are found, initialize an empty array
        cartItems = [];
    }

    // Function to render cart items
    function renderCartItems() {
        var cartTable = document.querySelector(".cart-page table");

        // Clear existing rows in the table
        cartTable.innerHTML = "<tr><th>Product</th><th>Quantity</th><th>Subtotal</th></tr>";

        // Loop through each item in the cartItems array
        cartItems.forEach(function (item) {
            var row = document.createElement("tr");
            row.innerHTML = `
                <td>
                    <div class="cart-info">
                        <img src="${item.image}">
                        <div>
                            <p>${item.name}</p>
                            <small>Price: $${item.price.toFixed(2)}</small>
                            <br>
                            <a href="#" onclick="removeItem(${item.id})">Remove</a>
                        </div>
                    </div>
                </td>
                <td><input type="number" value="${item.quantity}" onchange="updateQuantity(${item.id}, this.value)"></td>
                <td>$${(item.price * item.quantity).toFixed(2)}</td>
            `;
            cartTable.appendChild(row);
        });

        // Update total prices
        updateTotalPrices();
    }

    // Function to update total prices
    function updateTotalPrices() {
        var subtotal = cartItems.reduce(function (total, item) {
            return total + item.price * item.quantity;
        }, 0);

        var tax = 0.15 * subtotal; // Assuming 15% tax
        var total = subtotal + tax;

        var totalPriceTable = document.querySelector(".total-price table");
        totalPriceTable.innerHTML = `
            <tr>
                <td>Subtotal</td>
                <td>$${subtotal.toFixed(2)}</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>$${tax.toFixed(2)}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>$${total.toFixed(2)}</td>
            </tr>
        `;
    }

    // Function to remove an item from the cart
    function removeItem(itemId) {
        cartItems = cartItems.filter(function (item) {
            return item.id !== itemId;
        });

        // Save the updated cartItems to local storage
        localStorage.setItem("cartItems", JSON.stringify(cartItems));

        // Render the updated cart items
        renderCartItems();
    }

    // Function to update quantity of an item in the cart
    function updateQuantity(itemId, newQuantity) {
        // Find the item in the cartItems array
        var itemToUpdate = cartItems.find(function (item) {
            return item.id === itemId;
        });

        // Update the quantity of the item
        if (itemToUpdate) {
            itemToUpdate.quantity = parseInt(newQuantity);

            // Save the updated cartItems to local storage
            localStorage.setItem("cartItems", JSON.stringify(cartItems));

            // Render the updated cart items
            renderCartItems();
        }
    }

    // Initial rendering of cart items
    renderCartItems();

