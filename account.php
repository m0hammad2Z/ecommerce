
<?php
session_start();
require_once './backend/other/initial.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the login form is submitted
    if (isset($_POST['login'])) {
        // Process login logic
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);

        $user = new User();
        $loggedInUser = $user->getByEmail($email);

        if ($loggedInUser && md5($password) === $loggedInUser->password) {
            // Login successful
            $_SESSION['user'] = [
                'id' => $loggedInUser->id,
                'name' => $loggedInUser->name,
                'email' => $loggedInUser->email,
                'role' => $loggedInUser->role,
            ];

            // Redirect based on user role
            if ($loggedInUser->role == 'customer') {
                header('Location: index1.php');
            } else {
                header('Location: admin/index.php');
            }

            exit();
        }
    }

    // Check if the register form is submitted
    if (isset($_POST['register'])) {
        // Process register logic
        $name = filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
        $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING);

        

        // Create a new user
        $user = new User();
        $user->add($name, $email, $password, $role, $address, $mobile, 0);

        // Store user information in session (optional)
        $_SESSION['user'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];

        // Redirect based on user role
        if ($role == 'customer') {
            header('Location: index1.php');
        } else {
            header('Location:/admin/index.php');
        }

        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="assest/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="index.html"><h1>EquiPro</h1></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="index.html">Home</a></li>
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

    <!-- Account Page -->
    <div class="account-page">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <img src="/assest/images/image1.jpg" width="100%" alt="image">
                </div>
                <div class="col-2">
                    <div class="form-container">
                        <div class="form-btn">
                            <span onclick="login()">Login</span>
                            <span onclick="register() ">Register</span>
                            <hr id="Indicator">
                        </div>
                        <form id="LoginForm" method="POST" action="account.php">
                            <input type="email" placeholder="Username" name="email" id="email">
                            <input type="password" placeholder="Password" name="Password" id="UserName">
                            <button type="submit" class="btn" name="login" >Login</button>
                            <a href="">Forget Password</a>
                        </form>

                        <form id="RegForm" method="POST" action="account.php">
                            <input type="text" placeholder="Username" name="UserName" id="">
                            <input type="email" placeholder="Email" id="email" name="email">
                            <input type="password" placeholder="Password" name="password" id="password">
                            <input type="text" placeholder="Role" name="role" id="role">
                            <input type="text" placeholder="Addreess" name="address" id="address">
                            <input type="tel" placeholder="Phone Number" name="mobile" id="mobile">

                            <button type="submit" class="btn" name="register" id="register">Register</button>
                        </form>
                    </div>
                </div>
            </div>
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
                        <img src="./assest/images/app-store.png">
                        <img src="./assest/images/play-store.png">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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

    <!-- Toggle Form -->
    <script>
       var LoginForm = document.getElementById("LoginForm");
var RegForm = document.getElementById("RegForm");
        var Indicator = document.getElementById("Indicator");
var FormContainer = document.querySelector(".form-container");
FormContainer.style.height ="550px";

function register() {
    RegForm.style.transform = "translateX(0px)";
    LoginForm.style.transform = "translateX(0px)";
    Indicator.style.transform = "translateX(100px)";
    FormContainer.style.height ="550px";

}

function login() {
    RegForm.style.transform = "translateX(300px)";
    LoginForm.style.transform = "translateX(300px)";
    Indicator.style.transform = "translateX(0px)";
    FormContainer.style.height ="400px";

}
    </script>

  

</body>

</html>