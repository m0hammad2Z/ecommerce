<?php
    include_once (__DIR__ . '/../dbFiles/connection.php');
    include_once (__DIR__ . '/../dbFiles/constraints.php');
    include_once 'orderItem.php';
    include_once 'role.php';


    include_once (__DIR__ . '/../models/dbparent.php');
    include_once (__DIR__ . '/../models/user.php');
    include_once (__DIR__ . '/../models/product.php');
    include_once (__DIR__ . '/../models/category.php');
    include_once (__DIR__ . '/../models/image.php');
    include_once (__DIR__ . '/../models/trasnaction.php');

    session_start();

    function allowed($roles, $path){
        foreach ($roles as $role) {
            if($role == $_SESSION['user']['role']){
                return;
            }
        }

        header('Location:' . $path);
    }

?>