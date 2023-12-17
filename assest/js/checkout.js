     // Retrieve data from local storage
     var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
     var orderSummaryTable = document.getElementById("orderSummaryTable");
     var subtotalElement = document.getElementById("subtotal");
     var taxElement = document.getElementById("tax");
     var totalElement = document.getElementById("total");

     // Function to calculate the total price
     function calculateTotal() {
         var subtotal = 0;
         // Dynamically populate the order summary table
         orderSummaryTable.innerHTML = "<tr><th>Product</th><th>Quantity</th><th>Subtotal</th></tr>";
         cartItems.forEach(function (item) {
             var row = `<tr>
                         <td>${item.name}</td>
                         <td>${item.quantity}</td>
                         <td>$${(item.price * item.quantity).toFixed(2)}</td>
                     </tr>`;
             orderSummaryTable.innerHTML += row;
             subtotal += item.price * item.quantity;
         });

         var tax = 0.1 * subtotal; // Assuming tax is 10% of subtotal
         var total = subtotal + tax;

         // Update the total price in the HTML
         subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
         taxElement.textContent = `$${tax.toFixed(2)}`;
         totalElement.textContent = `$${total.toFixed(2)}`;
     }

     // Call the function to initially populate the order summary
     calculateTotal();

     // Add event listener to the checkout form
     document.getElementById("checkoutForm").addEventListener("submit", function (event) {
         // Implement your checkout form submission logic here
         // Prevent the default form submission for this example
         event.preventDefault();
     });

     function placeOrder(event) {
 // Prevent the default form submission
 event.preventDefault();

 // Gather the data from the form
 var formData = new FormData(document.getElementById('checkoutForm'));

 // Make an AJAX request to the server
 var xhr = new XMLHttpRequest();
 xhr.open('POST', 'process_checkout.php', true);

 // Set up the callback function to handle the response
 xhr.onreadystatechange = function () {
     if (xhr.readyState === 4 && xhr.status === 200) {
         // Handle the response from the server (if needed)
         var response = xhr.responseText;
         console.log(response); // You can do something with the response, like redirecting the user
     }
 };

 // Send the form data
 xhr.send(formData);
}
