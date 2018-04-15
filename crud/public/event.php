<?php
session_start();
$user_id = $_SESSION['user_session']; 
require "functions.php";

if(isset($_GET['id'])){
	list($id, $name, $price, $image, $description, $user_id) = get_event(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
	$id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
	$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
	$price = trim(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT));
	$image = trim(filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL));
	$description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
	$user_id=filter_input(INPUT_POST, 'iduser', FILTER_SANITIZE_NUMBER_INT);


	if(empty($name) || empty($price) || empty($image) || empty($description) || empty($user_id)){
		$error_message= "Please fill in the required fields";
	} else {

		if(add_event($name, $price, $image, $description, $user_id, $id)){
			header('Location: index.php');
			exit;
		} else {
			$error_message = "Could not add event";
		}
	}
}
?>

<?php require "templates/header.php"; ?>

<?php 
if(isset($error_message)){
	echo $error_message;
}
?>

<h2>
<?php
if(!empty($id)){
	echo "Change information";
} else {
	echo "Add an book";
}
?></h2>

<form method="post" action="event.php">
	<label for="name">Book</label>
	<input type="text" name="name" id="name" value="<?php echo $name ?>">

	<label for="price">Price</label>
	<input type="text" name="price" id="price" value="<?php echo $price ?>">

	<label for="image">Image</label>
	<input type="text" name="image" id="image" value="<?php echo $image ?>">

	<label for="description">Description</label>
	<input type="text" name="description" id="description" value="<?php echo $description ?>">

	<input type="hidden" name="iduser" value="<?php echo $user_id ?>">
	<?php
	if(!empty($id)){
		echo '<input type="hidden" name="id" value="'.$id.'">';
	}
?>
	<input type="submit" name="submit" value="Envoyer">
</form>

<center><a href="index.php">Back to home</a></center>

<?php require "templates/footer.php"; ?>