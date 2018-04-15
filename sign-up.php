<?php
require_once 'dbconfig.php';

if($user->is_loggedin()!="")
{
    $user->redirect('home.php');
}

if(isset($_POST['action']))
{
   $uname = trim($_POST['txt_uname']);
   $umail = trim($_POST['txt_umail']);
   $upass = trim($_POST['txt_upass']); 
 
   if($uname=="") {
      $error[] = "Veuillez fournir le username"; 
   }
   else if($umail=="") {
      $error[] = "Veuillez fournir l'email"; 
   }
   else if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Veuillez entrer une adresse mail valide';
   }
   else if($upass=="") {
      $error[] = "Veuillez fournir le mot de passe";
   }
   else if(strlen($upass) < 6){
      $error[] = "Votre mot de passe doit contenir 6 caractères et plus"; 
   }
   else
   {
      try
      {
         $stmt = $DB_con->prepare("SELECT UserName,UserEmail FROM users WHERE UserName=:uname OR UserEmail=:umail");
         $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if($row['UserName']==$uname) {
            $error[] = "Désoler, ce username est déjà utilisé";
         }
         else if($row['UserEmail']==$umail) {
            $error[] = "Désoler, cet email est déjà utilisé";
         }
         else
         {
            if($user->register($fname,$lname,$uname,$umail,$upass)) 
            {
                $user->redirect('sign-up.php?joined');
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign up : cleartuts</title>
<link rel="shortcut icon" href="rcus.ico" type="image/x-icon">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>
<div class="container">
     <div class="form-container">
        <form method="post">
            <h2>Inscription</h2><hr />
            <?php
            if(isset($error))
            {
               foreach($error as $error)
               {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                  </div>
                  <?php
               }
            }
            else if(isset($_GET['joined']))
            {
                 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Veuillez cliquer sur <a href='opening.php'>Rejoindre</a> pour vous connectez
                 </div>
                 <?php
            }
            ?>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_uname" placeholder="Username" value="<?php if(isset($error)){echo $uname;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_umail" placeholder="E-mail" value="<?php if(isset($error)){echo $umail;}?>" />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="txt_upass" placeholder="Password" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
              <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
            </div>
            <br />
            <label>J'ai un compte <a href="index.php">Se connecter</a></label>
          </form>
      </div>
     </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
</body>
</html>