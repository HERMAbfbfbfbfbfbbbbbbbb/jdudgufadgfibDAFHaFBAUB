<?php
session_start();
$Titel = "login";
if(isset($_SESSION['USERNAME'])){
    include("init.php");
    include("include/templets/footer.php");
    echo "hello mester ". $_SESSION['USERNAME'];

}else{
    header('location:index.php');
}