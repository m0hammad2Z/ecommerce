<?php 

include_once(__DIR__ . '/../backend/other/initial.php');

allowed([Role::ADMIN], '../index.php');

$transaction = new Transaction();
$transactions = $transaction->getAll();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset(($_POST['_method']))){
		switch($_POST['_method']){
			case 'POST':
				$userId = $_POST['user_id'];
				
				$orders = array();
				if(isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['notes']) && isset($_POST['price'])){
					for($i = 0; $i < count($_POST['product_id']); $i++){
						$orders[] = new OrderItem(
							$userId,
							$_POST['product_id'][$i],
							$_POST['quantity'][$i],
							$_POST['price'][$i],
							$_POST['notes'][$i]
						);
					}
					$transaction->add($userId,$_POST['total_price'], $orders, $_POST['status']);
				}

				break;
			case 'UPDATE':
				$transaction->update($_POST['id'], $_POST['user_id'], $_POST['product_id'], $_POST['quantity']);
				break;
			case 'DELETE':
				$transaction->delete($_POST['id']);
				break;
		}
		// header('Location: transactions.p	hp');
	}
}


$user = new User();
$users = $user->getAll();

$product = new Product();
$products = $product->getAll();

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>Sport Shop</title>
	    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
	    <!----css3---->
        <link rel="stylesheet" href="css/custom.css">
		
		
		<!--google fonts -->
	    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	
	
	   <!--google material icon-->
      <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">

  </head>
  <body>
  


<div class="wrapper">
     
	  <div class="body-overlay"></div>
	 
	 <!-------sidebar--design------------>
	 
	 <div id="sidebar">
	    <div class="sidebar-header">
		   <h3><img src="img/logo.png" class="img-fluid"/><span>Sport Shop</span></h3>
		</div>
		<ul class="list-unstyled component m-0">
		  <li >
		  	<a href="index.php" class="dashboard"><i class="material-icons">dashboard</i>Dashboard </a>
		  </li>
		  <li >
		  	<a href="users.php" class="users"><i class="material-icons">person</i>Users</a>
		  </li>
		  <li>
		  	<a href="products.php" class="products"><i class="material-icons">shopping_cart</i>Products</a>
		  </li>
		  <li class="active">
		  	<a href="transactions.php" class="transactions"><i class="material-icons">attach_money</i>Transactions</a>
		  </li>
		  <li>
		  	<a href="categories.php" class="categories"><i class="material-icons">category</i>Categories</a>
		  </li>
		
		</ul>
	 </div>
	 
   <!-------sidebar--design- close----------->
   
   
      <!-------page-content start----------->
   
<div id="content">
	<!------top-navbar-start----------->
	<div class="top-navbar">
		<div class="xd-topbar">
			<div class="row">
				<div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
					<div class="xp-menubar">
						<span class="material-icons text-white">signal_cellular_alt</span>
					</div>
				</div>

				<div class="col-md-5 col-lg-3 order-3 order-md-2">
					<div class="xp-searchbar">
						<form>
							<div class="input-group">
								<input type="search" class="form-control" placeholder="Search">
								<div class="input-group-append">
									<button class="btn" type="submit" id="button-addon2">Go</button>
								</div>
							</div>
						</form>
					</div>
				</div>


				<div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
					<div class="xp-profilebar text-right">
						<nav class="navbar p-0">
							<ul class="nav navbar-nav flex-row ml-auto">

								<li class="dropdown nav-item">
									<a class="nav-link" href="#" data-toggle="dropdown">
										<img src="img/user.jpg" style="width:40px; border-radius:50%;" />
										<span class="xp-user-live"></span>
									</a>
									<ul class="dropdown-menu small-menu">
										<li><a href="#">
												<span class="material-icons">person_outline</span>
												Profile
											</a></li>
										<li><a href="#">
												<span class="material-icons">logout</span>
												Logout
											</a></li>

									</ul>
								</li>


							</ul>
						</nav>
					</div>
				</div>

			</div>

			<div class="xp-breadcrumbbar text-center">
				<h4 class="page-title">Transactions</h4>
			</div>


		</div>
	</div>
	<!------top-navbar-end----------->


	<!------main-content-start----------->
	<div class="main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-wrapper">

					<div class="table-title">
						<div class="row">
							<div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
								<h2 class="ml-lg-2">Manage Transactions</h2>
							</div>
							<div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
								<a href="#addTransactionModal" class="btn btn-success" data-toggle="modal">
									<i class="material-icons">&#xE147;</i>
									<span>Add New Transaction</span>
								</a>
							</div>
						</div>
					</div>

					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>User</th>
								<th>Total Price</th>
								<th>Status</th>
								<th>Orders</th>
								<th>Actions</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($transactions as $transaction) {
								
								?>
								<tr>
									<td><?php echo $transaction->userId; ?></td>
									<td><?php echo $transaction->totalPrice; ?></td>
									<td><?php echo $transaction->status; ?></td>

									<td>
										<a href="#editViewOrdersModal" class="edit" data-toggle="modal" onclick='loadOrdersModal(<?php echo json_encode($transaction->orders); ?>)'>
											<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
										</a>
									</td>

									
									<td>
										<!-- <a href="#editTransactionModal" class="edit" data-toggle="modal" onclick='loadUpdateModal(<?php echo json_encode($transaction); ?>)'>
											<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
										</a> -->
										<a href="#deleteTransactionModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete" onclick='loadDeleteIdToModal(<?php echo $transaction->id; ?>)'>&#xE872;</i></a>
									</td>
								</tr>
							<?php } ?>


						</tbody>


					</table>

				</div>
			</div>

			<!----add-modal start--------->
			<div class="modal fade" tabindex="-1" id="addTransactionModal" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Transaction</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="transactions.php">
							<div class="modal-body">
								<div class="form-group">
									<label>User</label>
									<select class="form-control" name="user_id" required>
										<?php foreach ($users as $user) { ?>
											<option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Orders</label>
									<div class="orders-container" name="orders">

									</div>
									<button type="button" class="btn btn-success" id="addOrderBtn" onclick="addOrder()">Add Order</button>
										
								</div>

								<div class="form-group">
									<label>Status</label>
									<select class="form-control" name="status" required>
										<option value="pending">Pending</option>
										<option value="accepter">Accepted</option>
										<option value="rejected">Rejected</option>
									</select>
								</div>
								<div class="form-group">
									<label>Total Price</label>
									<input type="number" class="form-control" name="total_price" required>
								</div>

								<input type="hidden" name="_method" value="POST">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-success">Add</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!----add-modal end--------->

			<!----delete-modal start--------->
			<div class="modal fade" tabindex="-1" id="deleteTransactionModal" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Delete Transaction</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="transactions.php">
							<div class="modal-body">
								<p>Are you sure you want to delete this Records</p>
								<p class="text-warning"><small>This action cannot be undone.</small></p>
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="id" value="" id="deleteModalId">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-success">Delete</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!----delete-modal end--------->



			<!----edit-modal start--------->
			<div class="modal fade" tabindex="-1" id="editTransactionModal" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Transaction</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="transactions.php">
							<div class="modal-body">
								<div class="form-group">
									<label>User</label>
									<select class="form-control" name="user_id" required>
										<?php foreach ($users as $user) { ?>
											<option value="<?php echo $user->id; ?>" selected ><?php echo $user->name; ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class="form-group">
									<label>Orders</label>
									<div class="orders-container" name="orders">
										<?php foreach ($transaction->orders as $order) { ?>
											<div class="form-group">
												<label>Product</label>
												<select class="form-control" name="product_id[]" required>
													<?php foreach ($products as $product) { ?>
														<option <?php if($product->id == $order->productId) echo "selected"; ?> value="<?php echo $product->id; ?>"><?php echo $product->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label>Quantity</label>
												<input type="number" class="form-control" name="quantity[]" value="<?php echo $order->quantity; ?>" required>
											</div>
											<div class="form-group">
												<label>Notes</label>
												<input type="text" class="form-control" name="notes[]" value="<?php echo $order->notes; ?>" required>
											</div>
											<div class="form-group">
												<label>Price</label>
												<input type="number" class="form-control" name="price[]" value="<?php echo $order->price; ?>" required>
											</div>
											<button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.removeChild(this.parentElement)">Remove</button>
										<?php } ?>
									</div>

									</div>
									<button type="button" class="btn btn-success" id="addOrderBtn" onclick="addOrder()">Add Order</button>
										
								</div>
								
								
								<div class="form-group">
									<label>Status</label>
									<select class="form-control" name="status" required>
										<option value="pending">Pending</option>
										<option value="accepter">Accepted</option>
										<option value="rejected">Rejected</option>
									</select>
								</div>
								<div class="form-group">
									<label>Total Price</label>
									<input type="number" class="form-control" name="total_price" required>
								</div>
								<input type="hidden" name="id" value="" id="updateModalId">
								<input type="hidden" name="_method" value="UPDATE">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-success">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!----edit-modal end--------->


			<!----edit-view-orders-modal start--------->
			<div class="modal fade" tabindex="-1" id="editViewOrdersModal" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class='modal-title'>Orders</h5>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
							</button>
						</div>
						<div class='modal-body'>
							<table class='table table-striped table-hover'>
								<thead>
									<tr>
										<th>Product</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Notes</th>
									</tr>
								</thead>

								<tbody id='ordersTableBody'>
									

								</tbody>
							</table>
						</div>
						<div class='modal-footer'>
							<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						</div>
					</div>
				</div>
			</div>
				<!----edit-view-orders-modal end--------->
				

		</div>
	</div>

	<!------main-content-end----------->



	<!----footer-design------------->
	<footer class="footer">
		<div class="container-fluid">
			<div class="footer-in">
				<p class="mb-0">&copy 2021 Vishweb Design . All Rights Reserved.</p>
			</div>
		</div>
	</footer>





</div>



<!-------complete html----------->





<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
		$(".xp-menubar").on('click', function() {
			$("#sidebar").toggleClass('active');
			$("#content").toggleClass('active');
		});

		$('.xp-menubar,.body-overlay').on('click', function() {
			$("#sidebar,.body-overlay").toggleClass('show-nav');
		});

	});


	function loadUpdateModal(data) {
		document.getElementsByName('user_id')[1].value = data.user_id;
		document.getElementsByName('product_id')[1].value = data.product_id;
		document.getElementsByName('quantity')[1].value = data.quantity;
		document.getElementById('updateModalId').value = data.id;
	}

	function loadDeleteIdToModal(id) {
		document.getElementById('deleteModalId').value = id;
	}

	function addOrder(){
		var orderContainer = document.querySelector('.orders-container');
		var products = <?php echo json_encode($products); ?>;

		var orders = document.createElement('div');
		orders.className = "form-group";
		orders.name = "orders[]";

		var select = document.createElement('select');
		select.className = "form-control";
		select.name = "product_id[]";
		select.required = true;
		for (var i = 0; i < products.length; i++) {
			var option = document.createElement('option');
			option.value = products[i].id;
			option.innerHTML = products[i].name;
			select.appendChild(option);
		}

		// Create and append the quantity input
		var quantity = document.createElement('input');
		quantity.type = "number";
		quantity.className = "form-control";
		quantity.name = "quantity[]";
		quantity.min = 1;
		quantity.value = 1;
		quantity.required = true;
		quantity.placeholder = "Quantity";


		// Create and append the notes input
		var notes = document.createElement('input');
		notes.type = "text";
		notes.className = "form-control";
		notes.name = "notes[]";
		notes.placeholder = "Notes";
		notes.required = true;
		

		var price= document.createElement('input');
		price.type = "number";
		price.className = "form-control";
		price.name = "price[]";
		price.placeholder = "Price";
		price.required = true;


		// Create and append the remove button
		var removeBtn = document.createElement('button');
		removeBtn.className = "btn btn-danger";
		removeBtn.type = "button";
		removeBtn.innerHTML = "Remove";
		removeBtn.onclick = function (e) {
			orderContainer.removeChild(this.parentElement);
		};

		// Append the elements to the form
		orders.appendChild(select);
		orders.appendChild(quantity);
		orders.appendChild(notes);
		orders.appendChild(price);
		orders.appendChild(removeBtn);

		// Append the form to the order container
		orderContainer.appendChild(orders);
	}

	function loadOrdersModal(data){
		var orders = data;
		var tableBody = document.getElementById('ordersTableBody');
		tableBody.innerHTML = "";
		for(var i = 0; i < orders.length; i++){
			var row = tableBody.insertRow();
			var cell1 = row.insertCell();
			var cell2 = row.insertCell();
			var cell3 = row.insertCell();
			var cell4 = row.insertCell();
			cell1.innerHTML = orders[i].productId;
			cell2.innerHTML = orders[i].quantity;
			cell3.innerHTML = orders[i].price;
			cell4.innerHTML = orders[i].notes;
		}
	}
</script>




</body>

</html>
