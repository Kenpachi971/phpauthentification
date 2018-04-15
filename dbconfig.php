<?php

session_start();

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "Treachery971";
$DB_name = "dblogin";

try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}


include_once 'class.user.php';
$user = new USER($DB_con);
$password = "123456";
$hash = password_hash($passwod, PASSWORD_DEFAULT);
$hashed_password = "$2y$10$BBCpJxgPa8K.iw9ZporxzuW2Lt478RPUV/JFvKRHKzJhIwGhd1tpa";
$password = "123456";
$hashed_password = "$2y$10$BBCpJxgPa8K.iw9ZporxzuW2Lt478RPUV/JFvKRHKzJhIwGhd1tpa";
password_verify($password, $hashed_password);
?>




<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function register($fname,$lname,$uname,$umail,$upass)
    {
       try
       {
           $new_password = password_hash($upass, PASSWORD_DEFAULT);
   // $stmt = just declarate a variable
           $stmt = $this->db->prepare("INSERT INTO users(UserName,UserEmail,UserPass)VALUES(:uname, :umail, :upass)");
           $stmt->bindparam(":uname", $uname);
           $stmt->bindparam(":umail", $umail);
           $stmt->bindparam(":upass", $new_password);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($uname,$umail,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE UserName=:uname OR UserEmail=:umail LIMIT 1");
          $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
// Recup valeur sql avec fetch
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
// rowCount() = retourne la derniere ligne affecté par un DELETE UPDATE OU INSERT
          if($stmt->rowCount() > 0)
          {
             if(password_verify($upass, $userRow['UserPass']))
             {
                $_SESSION['user_session'] = $userRow['UserNum'];
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
}
?>