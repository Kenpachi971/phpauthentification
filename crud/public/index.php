<center>
<?php session_start(); 
include "templates/header.php"; 
$user_id = $_SESSION['user_session']; 
?>

<ul>
	<li><a href="event.php"><strong>Create</strong></a> - Add an book</li>
</ul>

<?php
	require "functions.php";
	require "../connection.php";

	if(isset($_POST['delete'])){
		if(delete_event(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))){
			header('Location: index.php');
			exit;
		}
	}
?>

<ul>
<?php
foreach(get_event_list() as $event){
	echo "<div id='Mycontainer'>
	<a href='event.php?id=".$event['BookNum']."'>". $event["BookName"] . 
	"</a>";
	echo "<p>" . 'Prix : ' . $event["BookPrice"] . ' €' . "</p>";
	echo "<p>" . 'Description : ' . $event["BookDescription"] . "</p>";
	echo "<a href='event.php?id=".$event['BookNum']."'><img src=".$event["BookImage"]."/></a>";
	echo "<form method='post' action='index.php' />\n";
	echo "<input type='hidden' value='".$event['BookNum']."' name='delete' />\n";
	echo "<input type='submit' value='Delete' />\n";
	echo "</form>";
	echo "</div>";

}
?>
</ul>

<a href="../Redicretion.php">Retour à la page d'acceuil</a>
<?php include "templates/footer.php"; ?>
</center>