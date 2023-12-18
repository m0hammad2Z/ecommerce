<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="assest/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="header">
    <div class="container">
        <div class="navbar">
            <div class="logo">
            <a href="index.php"><h1>EuiqPro</h1></a>
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

    <br>
    <br>

    <!-- Home page content -->
    <div class="container">
        <div class="row">
            <div class="col-2">
                <h1>Give Your Workout<br> A New Style!</h1>
                <p>Success isn't always about greatness. It's about consistency. Consistent<br> hard work gains success. Greatness will come.</p>
                <a href="#products" class="btn">Explore Now &#8594;</a>
            </div>
            <div class="col-2" style="text-align: center;">
                <img src="https://images.pexels.com/photos/4562470/pexels-photo-4562470.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" ">
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>
    <hr>
    <br>
    <br>
    <br>

    <!-- Featured categories -->

    <?php
        require_once 'backend/dbFiles/connection.php';
        require_once 'backend/dbFiles/constraints.php';
        require_once 'backend/models/dbparent.php';
        require_once 'backend/models/image.php';
        require_once 'backend/models/product.php';
        
        require_once './backend/other/initial.php';

        require_once './backend/other/initial.php';
        
    
        $product = new Product();
        $image = new Image();

        $products = $product->getAllWithLimit(8);

        $categories = $product->getAllWithLimit(6);
        ?>

        <div class="title">
            <h2>Featured Categories</h2>
        </div>
        <div class="small-container">
            <div class="row">
                <?php

                foreach ($categories as $category) {
                    echo '<div class="col-3 ">';
                    echo '<h4 text-align: center;>' . $category->name . '</h4>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <br>
    <br>
    <br>
    <hr>
    <br>
    <br>
    <br>

        <h2 class="title" id="products">Featured Products</h2>
        <div class="small-container">
            <div class="row">
                <?php
                foreach ($products as $product) {
                    $img = $image->getOneByProductId($product->id);

                    if($img != null)
                        $product->image = $img->path;
                    else
                        $product->image = "https://images.pexels.com/photos/4562470/pexels-photo-4562470.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1";

                    echo '<div class="col-4">';
                    echo '<img src=" ' . $product->image . '" width="200px" height="200px">';
                    echo '<h4>' . $product->name . '</h4>';
                    echo '<p>' . $product->description . '</p>';
                    echo '<p>' . $product->price . '</p>';
                    $productData = htmlspecialchars(json_encode($product));
                    echo '<button class="btn" data="' . $productData . ' " onclick="addToCart(this)">Add to Cart</button>';
                    echo '</div>';
                }
                ?>
                <a href="products.html" class="btn ">View More &#8594;</a>
            </div>
        </div>

        <br>
    <br>
    <br>
    <hr>
    <br>
    <br>
    <br>

        <!-- Offer -->
        <div class="offer">
            <div class="small-container">
                <div class="row">
                    <div class="col-2">
                        <img src="https://images.pexels.com/photos/4562470/pexels-photo-4562470.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="offer-img">
                    </div>
                    <div class="col-2">
                        <p>Exclusively Available on Equipro</p>
                        <h1>Smart Band 4</h1>
                        <small>The Mi Smart Band 4 features a 39.9% larger (than Mi Band 3) AMOLED color full-touch display with adjustable brightness, so everything is clear as can be.</small>
                        <a href="" class="btn">Buy Now &#8594;</a>
                    </div>
                </div>
            </div>
        </div>

        <br>
    <br>
    <hr>
    <br>
    <br>
    <br>
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

</body>
</html>
