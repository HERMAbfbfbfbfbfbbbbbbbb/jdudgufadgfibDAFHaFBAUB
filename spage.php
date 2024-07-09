<?php
session_start();
$Titel = "login";
if(isset($_SESSION['USERNAME'])){
        include("init.php");

$action="";
if(isset($_GET['action'])){
    $action=  $_GET['action'];
}else{
$action= "mange";
}
if($action=="mange"){
echo"welcom mange page";
}elseif($action=="add"){
    echo"welcom add page";
}elseif($action=="insert"){
    echo"welcom insert page";
}elseif($action=="edit"){
    echo"welcom edit page";
}elseif($action=="update"){
    echo"welcom update page";
}elseif($action=="delete"){
    echo"welcom delete page";
}

include("include/templets/footer.php");
}else{
   header('location:index.php');
}