<?php
    session_start();
    require_once('backend/other/initial.php');

    //validate form data 

    $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
    $username=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
    $username=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

    
    // Validate user role using regex
if (!preg_match('/^(admin|customer)$/i', $role)) {
    echo json_encode(['success' => false, 'message' => 'Invalid user role']);
    exit();
}

// Create a new user
  $user = new User();
  $user->add($name, $email, $password, $role, $address, $mobile,0);

// Store user information in session (optional)
   $_SESSION['user'] = [
    'id' => $user->id,
    'name' => $user->name,
    'email' => $user->email,
    'role' => $user->role,
];
// Redirect based on user role
if ($role == 'customer') {
    header('Location: index.html');
} else {
    header('Location: dashboard.html');
}

exit();
?>


?>