
<?php
session_start();
require_once 'other/initial.php';

// Read JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validate and sanitize form data
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$password = filter_var($data['password'], FILTER_SANITIZE_STRING);

// Retrieve user from the database by email
$user = new User();
$loggedInUser = $user->getByEmail($email);

if ($loggedInUser && md5($password) === $loggedInUser->password) {
    // Login successful
    $_SESSION['user'] = [
        'id' => $loggedInUser->id,
        'name' => $loggedInUser->name,
        'email' => $loggedInUser->email,
        'role' => $loggedInUser->role,
    ];}

  // Redirect based on user role
  if ($user->getByrole == 'customer') {
    header('Location: index.html');
  } else {
    header('Location: dashboard.html');
  }
 
   exit();
?>
