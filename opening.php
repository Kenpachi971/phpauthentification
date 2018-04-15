<?php
require_once 'dbconfig.php';

if($user->is_loggedin()!="")
{
 $user->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
 $uname = $_POST['uname_email'];
 $umail = $_POST['uname_email'];
 $upass = $_POST['Password'];
  
 if($user->login($uname,$umail,$upass))
 {
  $user->redirect('home.php');
 }
 else
 {
  $error = "Veuillez réessayer";
 } 
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="rcus.ico" type="image/x-icon">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>Nous rejoindre</title>
</head>
<body>
<div class="container">
  <h1>Venez rejoindre notre groupe</h1>
     <div class="form-container">
        <form method="post">
            <h2>Se connecter</h2><hr />
            <?php
            if(isset($error))
            {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                  </div>
                  <?php
            }
            ?>
            <div class="form-group">
             <input type="text" class="form-control" name="uname_email" placeholder="Username or E mail ID" required />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="Password" placeholder="Your Password" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
               
             <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                 <i class="glyphicon glyphicon-log-in"></i>&nbsp;Se connecter
                </button>
            </div>
            <br />
            <label>Pas encore de compte ? <a href="sign-up.php"> S'inscrire</a></label>
        </form>
       </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
</body>
</html>