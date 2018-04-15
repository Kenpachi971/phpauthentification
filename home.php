<?php
session_start();
include_once 'dbconfig.php';
if(!$user->is_loggedin())
{
 $user->redirect('opening.php');
}
$user_id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT UserName FROM users WHERE UserNum=:UserNum");
$stmt->execute(array(":UserNum"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="rcus.ico" type="image/x-icon">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>Welcome - <?php print($userRow['UserName']); ?></title>
</head>

<body>

<div class="header">
 <div class="left">
    </div>
    <div class="left">
     <label><a href="logout.php?logout=true"><i class="glyphicon glyphicon-log-out"></i>Se Déconnecter</a></label>
    </div>
</div>
<div class="content">
Bienvenue à toi <?php print($userRow['UserName']);?>
, tu peux désormais accéder à ton espace <a href="./crud/public/index.php">2.0.</a>
</div>
</body>
<footer class="page-footer">
         <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
        </footer>
</html>