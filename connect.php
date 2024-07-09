<?php
$dsn='mysql:host=localhost;dbname=connect';
$uesr='root';
$password='';
$option=array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
);
try{
    $con=new PDO($dsn,$uesr,$password,$option);
    $con->SetAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo'yuo are connected';
}
catch(ODOException $e){
    //echo'failed to connect';
}