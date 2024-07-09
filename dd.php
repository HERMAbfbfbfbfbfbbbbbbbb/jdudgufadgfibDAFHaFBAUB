<?php
session_start();
$nonavbar="";
$Titel = "login";

if(isset($_SESSION['USERNAME'])){
    header('location:home.php');
    exit();
}else{
    header('location:register.php');

}
include("init.php");
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $name=$_POST['uesr'];
    $pass=$_POST['pass'];
    $hashpass=sha1($pass);

    $stmt=$con->prepare("SELECT username,password 
    FROM users WHERE  username=? 
    AND password=? 
    AND Admin_id=1 LIMIT 1 ");

    $stmt->execute(array($name,$hashpass));
    $count=$stmt->rowCount();
    //echo $count;
    if($count>0){
        $_SESSION['USERNAME']=$name;
        header('loction:home.php');
        exit();
    }
    header('loction:index.php');

}
?>