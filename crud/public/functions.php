<?php
session_start();
$user_id = $_SESSION['user_session'];


function get_event_list(){
    include "../connection.php";
    $table = array();
    try{
        $sql = "SELECT * FROM book WHERE UserNum ='".$_SESSION['user_session']."'";
        $reponse = $connection->prepare($sql);
        $reponse->bindValue(1, $_SESSION['user_session'], PDO::PARAM_INT);
        $reponse->execute();
        while($affiche=$reponse->fetch(PDO::FETCH_ASSOC)){
        $table[]=$affiche;
    }
    } catch(Exception $e){
       echo "Erreur : ". $e->getMessage();
       return false; 
    }
 
    return $table;
}

function get_event($id){
    include "../connection.php";

    try{

        $sql= "SELECT * FROM book WHERE BookNum= ?";
        $result=$connection->prepare($sql);
        $result->bindValue(1, $id, PDO::PARAM_INT);
        $result->execute();
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return $result->fetch();
}

function add_event($name, $price, $image, $description, $user_id, $id=null){
    include "../connection.php";

    if($id){
        $sql = "UPDATE book SET BookName = ?, BookPrice = ?, BookImage = ?, BookDescription = ?, UserNum = ? WHERE BookNum = ?";
    } else {
        $sql = "INSERT INTO book (BookName, BookPrice, BookImage, BookDescription, UserNum) VALUE(?, ?, ?, ?, ?)";
    }

    try{
        $result= $connection->prepare($sql);
        $result->bindValue(1, $name, PDO::PARAM_STR);
        $result->bindValue(2, $price, PDO::PARAM_INT);
        $result->bindValue(3, $image, PDO::PARAM_STR);
        $result->bindValue(4, $description, PDO::PARAM_STR);
        $result->bindValue(5, $user_id, PDO::PARAM_INT);

        if($id){
            $result->bindValue(6, $id,PDO::PARAM_INT);
        }
        $result->execute();
    } catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}

function delete_event($id){
    include "../connection.php";

    $sql="DELETE FROM book WHERE BookNum= ?";

    try{
        $result=$connection->prepare($sql);
        $result->bindValue(1, $id, PDO::PARAM_INT);
        $result->execute();
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}
?>