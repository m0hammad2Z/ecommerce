<?php 

include_once(__DIR__ . '/../backend/other/initial.php');

allowed([Role::ADMIN], '../login.php');

$product = new Product();
$products = $product->getAll();

$category = new Category();

$image = new Image();
$imageDir = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['_method'])) {
        switch ($_POST['_method']) {
            case 'POST':
                $product->add(
                    $_POST['name'],
                    $_POST['price'],
                    $_POST['description'],
                    $_POST['categoryId'],
                    $_POST['stock']
                );
				if(isset($_FILES['images'])){	
					$productId = $product->getLastInsertedId();
					$images = $_FILES['images'];
					uploadImages($images, $productId, $imageDir, $image);
				}
                break;

            case 'UPDATE':
                $productId = $_POST['id'];
                $product->update(
                    $productId,
                    $_POST['name'],
                    $_POST['price'],
                    $_POST['description'],
                    $_POST['categoryId'],
                    $_POST['stock']
                );

                $images = $_FILES['images'];
                uploadImages($images, $productId, $imageDir, $image);

                if (isset($_POST['deleteImages'])) {
                    foreach ($_POST['deleteImages'] as $imageId) {
                        $image->delete($imageId);
                    }
                }
                break;

            case 'DELETE':
                $productId = $_POST['id'];
                $images = $image->getByProductId($productId);

                foreach ($images as $img) {
                    $img->delete($img->id);
                }

                $product->delete($productId);
                break;
        }
		header('Location: products.php');
    }
}

function uploadImages($images, $productId, $imageDir, $image)
{
    for ($i = 0; $i < count($images['name']); $i++) {
        $imageName = $images['name'][$i];
        $imageTmpName = $images['tmp_name'][$i];
        $uploadPath = $imageDir . $productId . '_' . $imageName;

        if (move_uploaded_file($imageTmpName, '../' . $uploadPath)) {
            $image->add($productId, $uploadPath);
        } else {
            echo 'Failed to upload file: ' . $imageName;
        }
    }
}

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
		  <li class="active">
		  	<a href="products.php" class="products"><i class="material-icons">shopping_cart</i>Products</a>
		  </li>
		  <li>
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
				<h4 class="page-title">Products</h4>
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
								<h2 class="ml-lg-2">Manage Products</h2>
							</div>
							<div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
								<a href="#addProductModal" class="btn btn-success" data-toggle="modal">
									<i class="material-icons">&#xE147;</i>
									<span>Add New Product</span>
								</a>
							</div>
						</div>
					</div>

					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Price</th>
								<th>description</th>
								<th>Category</th>
								<th>Stock</th>
								<th>Actions</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($products as $product) { ?>
								<tr>
									<td><?php echo $product->id; ?></td>
									<td><?php echo $product->name; ?></td>
									<td><?php echo $product->price; ?></td>
									<td><?php echo $product->description; ?></td>
									<td><?php echo $category->getById($product->categoryId)->name; ?></td>
									<td><?php echo $product->stock; ?></td>
									<td>
										<a href="#editProductModal" class="edit" data-toggle="modal" onclick='loadUpdateModal(
										<?php
										$images = $image->getByProductId($product->id); 
										$product->images = $images;	
										echo json_encode($product); ?>)'>
											<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
										</a>
										<a href="#deleteProductModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete" onclick='loadDeleteIdToModal(<?php echo $product->id; ?>)'>&#xE872;</i></a>
									</td>
								</tr>
							<?php } ?>


						</tbody>


					</table>

				</div>
			</div>

			<!----add-modal start--------->
			<div class="modal fade" tabindex="-1" id="addProductModal" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Product</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="products.php" enctype="multipart/form-data" >
							<div class="modal-body">
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="name" required>
								</div>
								<div class="form-group">
									<label>Price</label>
									<input type="text" class="form-control" name="price" required>
								</div>
								<div class="form-group">
									<label>Description</label>
									<input type="text" class="form-control" name="description" required>
								</div>
								<div class="form-group">
									<label>Category</label>
									<select class="form-control" name="categoryId" required>
										<?php foreach ($category->getAll() as $category) { ?>
											<option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Stock</label>
									<input type="text" class="form-control" name="stock" required>
								</div>
								<div class="form-group">
									<label>Images</label>
									<input type="file" class="form-control" name="images[]" multiple required>
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
			<div class="modal fade" tabindex="-1" id="deleteProductModal" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Delete Product</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="products.php">
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
			<div class="modal fade" tabindex="-1" id="editProductModal" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Product</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="products.php" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="name">
								</div>
								<div class="form-group">
									<label>Price</label>
									<input type="text" class="form-control" name="price">
								</div>
								<div class="form-group">
									<label>Description</label>
									<input type="text" class="form-control" name="description">
								</div>
								<div class="form-group">
									<label>Category</label>
									<select class="form-control" name="categoryId">
										<?php foreach ($category->getAll() as $category) { ?>
											<option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Stock</label>
									<input type="text" class="form-control" name="stock">
								</div>
								<div class="form-group">
									<label>Images</label>
									<input type="file" class="form-control" name="images[]" multiple>
								</div>
								<div class="form-group">
									<label>Existing Images</label>
									<div class="row existing-images-row">
										
									</div>
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

		</div>
	</div>

	<!------main-content-end----------->



	<!----footer-design------------->
	<footer class="footer">
		<div class="container-fluid">
			<div class="footer-in">
				<p class="mb-0">&copy 2023 Vishweb Design . All Rights Reserved.</p>
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
		console.log(data);
		document.getElementsByName('name')[1].value = data.name;
		document.getElementsByName('price')[1].value = data.price;
		document.getElementsByName('description')[1].value = data.description;
		document.getElementsByName('categoryId')[1].value = data.categoryId;
		document.getElementsByName('stock')[1].value = data.stock;
		document.getElementById('updateModalId').value = data.id;
		
		let imagesSection = document.querySelector('.existing-images-row');	
			imagesSection.innerHTML = '';

		if(data.images.length > 0){

			data.images.forEach(image => {
				let imageDiv = document.createElement('div');
				imageDiv.classList.add('col-md-3');
				imageDiv.classList.add('col-sm-6');
				imageDiv.classList.add('col-xs-12');
				imageDiv.classList.add('mb-2');
				imageDiv.innerHTML = `
					<div class="form-group">
						<input type="checkbox" name="deleteImages[]" value="${image.id}">
						<img src="../${image.path}" class="img-fluid">
					</div>`;
				imagesSection.appendChild(imageDiv);
			});
		}
	}

	function loadDeleteIdToModal(id) {
		document.getElementById('deleteModalId').value = id;
	}
</script>




</body>

</html>
