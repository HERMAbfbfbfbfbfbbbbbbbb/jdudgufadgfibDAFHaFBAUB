<?php
session_start();
$nonavbar="";
$Titel = "login";

if(isset($_SESSION['USERNAME'])){
    header('location:home.php');
    exit();
}
include("init.php");

?>
<div class="login-form">
<div class="container">
<form class="login" action="dd.php" method="POST" >
    <h2 class="text-center">LOGIN</h2>
<input type="text" class="form-control" name="uesr" autocomplete="off" placeholder="uesrname"/>
<input type="password" class="form-control" name="pass" autocomplete="off" placeholder="uesrname"/>
<input value="login" class="btn btn-primary mt-4" type="submit"/>
</form>
</div>
</div>
<?php



include("include/templets/footer.php");
?>