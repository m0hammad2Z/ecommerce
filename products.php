<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="assest/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="index.html"><h1>EuiqPro</h1></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="index1.php">Home</a></li>
                    <li><a href="products.html">Products</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="account.php">Account</a></li>
                </ul>
            </nav>
            <a href="cart.html"><img src="assest/images/cart.png" width="30px" height="30px"></a>
            <img src="assest/images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>

    <div class="small-container">
        <div class="row" id="product-container">
            <?php
            // Include the Product class file
            require_once('admin/products.php');

            // Create an instance of the Product class
            $product = new Product();

            // Fetch all products
            $products = $product->getAll();

            // Loop through products and display them
            foreach ($products as $product) {
                echo '<div class="col-4">';
                echo '<img src="/path-to-your-images-folder/' . $product->image . '" width="200px" height="200px">';
                echo '<h4>' . $product->name . '</h4>';
                echo '<p>' . $product->description . '</p>';
                echo '<p>' . $product->price . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Download Our App</h3>
                    <p>Download App for Android and ios mobile phone.</p>
                    <div class="app-logo">
                        <img src="/assest/images/app-store.png">
                        <img src="/assest/images/play-store.png">
                    </div>
                </div>
                <div class="footer-col-2">
                    <h3>EquiPro</h3>
                    <p>Our Purpose Is To Sustainably Make the Pleasure and Benefits of Sports Accessible to the Many.
                    </p>
                </div>
                <div class="footer-col-3">
                    <h3>Useful Links</h3>
                    <ul>
                        <li>Coupons</li>
                        <li>Blog Post</li>
                        <li>Return Policy</li>
                        <li>Join Affiliate</li>
                    </ul>
                </div>
                <div class="footer-col-4">
                    <h3>Follow Us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instagram</li>
                        <li>Youtube</li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright 2020 - Samwit Adhikary</p>
        </div>
    </div>

    <!-- javascript -->

    <script>
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
    </script>
</body>

</html>
