<?php 
include_once 'backend/other/initial.php';

allowed([Role::ADMIN, Role::GUEST, Role::USER], 'login.php');

$user = new User();        
$category = new Category();
$product = new Product();
$image = new Image();
$trasnaction = new Transaction();

// ----------- User -------------
// $user->add('Hamzeh','hamzed@gmsail.com','12345678', Role::ADMIN, 'Amman', '0799999999');
// $user->update(2, 'Hamzeh','hamzed@gmail.com','12345678', Role::USER, 'Amman', '0799999999');
// $users = $user->getAll();
// $u = $user->getById(2);
// print_r($u->password);
// $user->delete(3);


// ----------- Category -------------
// $category->add('Category' . rand(0, 1000));
// $categoryByID = $category->getById(1);
// $category->update($categoryByID->id, 'Category' . $categoryByID->id.  ' Updated');
// $categories = $category->getAll();
// print_r($categories);
// $category->delete(2);
// print_r($category->getByName($categoryByID->name)->name);

// ----------- Product -------------
// $product->add('Product 1', 10.5, 'Description 1', 1, 10);
// $product->add('Product 2', 34.5, 'Description 2', 1, 23);
// $product->update(1, 'Product 1 Updated', 10.5, 'Description 1', 1, 10);
// $products = $product->getAll();
// print_r($products);
// $product->delete(1);
// $productsByCategory = $product->getByCategoryId(1);
// print_r($productsByCategory);


// ----------- Image -------------
// $image->add(1, 'Path 1');
// $image->update(4, 1, 'Image 1 Updated');
// $images = $image->getAll();
// print_r($images);
// $image->delete(4);
// $imagesByProductId = $image->getByProductId(2);
// print_r($imagesByProductId);


// ----------- Transaction -------------
// $trasnaction->add(1, 10.5, array(new OrderItem(1, 2, 2, 3.2, "This is notes!"), new OrderItem(2, 1, 2, 3.2, "This is notes!")), rand(0, 2) == 0 ? 'Pending' : (rand(0, 2) == 1 ? 'Accepted' : 'Rejected'));
// $trasnaction->update(1, 1, 10, array(new OrderItem(1, 2, 2, 3.2, "This is notes! changed"), new OrderItem(1, 2, 2, 3.2, "This is notes!")), 'Pending');
// $trasnactions = $trasnaction->getByUserId(1);
// print_r($trasnactions);
// $orderItems = $trasnactions[0]->orders;// This is a OrderItem object
// print_r($orderItems);
// print_r($orderItems[0]->notes); // -------------------- Because This is a OrderItem object ----------------- //
// $trasnaction->delete(1);
// $trasnactionsByProductId = $trasnaction->getAll();
// print_r($trasnactionsByProductId);
?>