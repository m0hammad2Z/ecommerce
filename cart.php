<?php
require_once './backend/other/initial.php';

if(!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'id' => 0,
        'name' => '',
        'email' => '',
        'role' => Role::GUEST,
    ];
}

allowed([Role::USER, Role::ADMIN], 'index.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $jsonData = json_decode($_POST['jsonData']);

    $totalPrice = 0;

    $orders = array();
    if($jsonData == null){
        echo '<script>alert("Cart is empty");</script>';
        exit();
    }
    foreach($jsonData as $item){
        
        $userId = $_SESSION['user']['id'];
        $productId = $item->id;
        $quantity = $item->quantity;
        $price = $item->price * $item->quantity;
        $notes = $item->note;
        $orderItem = new OrderItem($userId, $productId, $quantity, $price, $notes);

        array_push($orders, $orderItem);
        $totalPrice += $price;
    }

    $transaction = new Transaction();
    $transaction->add($_SESSION['user']['id'], $totalPrice, $orders, 'pending');

    //remove cart from the local storage
    echo '<script>localStorage.removeItem("cart");</script>';

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="assest/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
   <!-- header.html -->
<div class="header">
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="index.php"><img src="assest/images/Equipro.png" alt="logo" width="125px" height="70px"></a>
            </div>
            <nav>
                <ul id="MenuItems">
                <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="account.php">Account</a></li>
                </ul>
            </nav>
            <a href="cart.php"><img src="assest/images/cart.png" width="30px" height="30px"></a>
            <img src="assest/images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
       
    </div>
</div>


    <!-- Cart items details -->
    <div class="small-container cart-page">
      <!-- Cart items details -->
<div class="small-container cart-page">
     <table class = "cart-items">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Note</th>
            <th>Subtotal</th>
        </tr>
        <!-- The following rows will be dynamically generated using JavaScript -->
    </table>
    <div class="total-price">
        <table>
            <tr>
                <td >Subtotal</td>
                <td class="sub-total">$0.00</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td class="tax">$0.00</td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="total">$0.00</td>
            </tr>
        </table>
    </div>
</div>

<form action="cart.php" method="POST">
    <input type="hidden" class="json-data" name="jsonData" value="0">
    <button type="submit" class="btn pay-button" onclick="">Pay</button>
</form>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div class="user-orders">
    <h2>My Orders</h2>
    <table>
        <tr>
            <th>Order Id</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
        <?php
            $transaction = new Transaction();
            $transactions = $transaction->getByUserId($_SESSION['user']['id']);
            if($transactions != null){
                foreach($transactions as $transaction){
                    echo '<tr>';
                    echo '<td>' . $transaction->id . '</td>';
                    echo '<td>' . $transaction->totalPrice . '</td>';
                    echo '<td>' . $transaction->status . '</td>';
                    echo '</tr>';
                }
            }
        ?>
    </table>
</div>

<script>
    loadItemsTable();

    function loadItemsTable(){
        let cartItems = JSON.parse(localStorage.getItem('cart'));
        let jsonData = document.querySelector('.json-data');
        jsonData.value = JSON.stringify(cartItems);

        let iteamTable = document.querySelector('.cart-items');
        let total = 0;
        let totalElement = document.querySelector('.total-price .total');
        let subTotalElement = document.querySelector('.total-price .sub-total');
        let taxElement = document.querySelector('.total-price .tax');

        iteamTable.innerHTML = `
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Note</th>
                <th>Subtotal</th>
            </tr>
        `;

        for (let item of cartItems) {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="cart-info">
                        <img src="${item.image}" alt="">
                        <div>
                            <p>${item.name}</p>
                            <small>Price: $${item.price}</small>
                            <br>
                            <button onclick="removeFromCart(this)" data-id="${item.id}">Remove</button>
                        </div>
                    </div>
                </td>
                <td><input type="number" min=1 value=${item.quantity} class="quantity" onchange="updateQuantity(this)" data-id="${item.id}"></td>
                <td><input type="text" class="note" value="${item.note}" onchange="updateNote(this)" data-id="${item.id}"></td>
                <td>$${Math.floor(item.price * item.quantity)}</td>
            `;

            iteamTable.append(row);
            total += item.price * item.quantity;
        }

        total = Math.floor(total);

        subTotalElement.innerText = '$' + total;
        taxElement.innerText = '$' + Math.floor(total * 0.1);
        totalElement.innerText = '$' + (Math.floor(total * 1.1));

    }

    function removeFromCart(button){
        let id = button.getAttribute('data-id');
        let cart = JSON.parse(localStorage.getItem('cart'));
        let newCart = cart.filter(item => item.id != id);
        localStorage.setItem('cart', JSON.stringify(newCart));
        loadItemsTable();
    }

    function updateQuantity(input){
        let id = input.getAttribute('data-id');
        let cart = JSON.parse(localStorage.getItem('cart'));
        let newCart = cart.map(item => {
            if(item.id == id)
                item.quantity = input.value;
            
            return item;
        });
        localStorage.setItem('cart', JSON.stringify(newCart));
        loadItemsTable();
    }


    function updateNote(input){
        let id = input.getAttribute('data-id');
        let cart = JSON.parse(localStorage.getItem('cart'));
        let newCart = cart.map(item => {
            if(item.id == id)
                item.note = input.value;
            
            return item;
        });
        localStorage.setItem('cart', JSON.stringify(newCart));
        loadItemsTable();
    }

</script>
</body>

</html>