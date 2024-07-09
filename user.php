<?php
session_start();
$Titel = "user";
if(isset($_SESSION['USERNAME'])){
        include("init.php");

$action="";
if(isset($_GET['action'])){
    $action=  $_GET['action'];
}else{
$action= "mange";
}
if($action=="mange"){
    $stmt=$con->prepare("SELECT * FROM users WHERE Admin_id=0 ORDER BY id DESC");
    $stmt->execute();
    $rows=$stmt->fetchAll();
    ?>
    <div class="container">
    <div class="card mt-5">
    <div class="card-header">
      Featured
    </div>
    <div class="card-body">
      <h5 class="card-title">Special title treatment</h5>
      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      <a href="user.php?action=add" class="btn btn-primary">add user</a>
    </div>
  </div>
  <table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">username</th>
      <th scope="col">email</th>
      <th scope="col">date</th>
      <th scope="col">control</th>
    </tr>
  </thead>
  <tbody><tr>
    <?php
    foreach($rows as $user){
        echo '<td >'. $user['id'].'</td>';
        echo '<td >'. $user['username'].'</td>';
        echo '<td >'. $user['email'].'</td>';
        echo '<td >'. $user['date'].'</td>';



        echo '<th >
        <a href="user.php?action=delete&userid='.$user['id'].'"class="btn btn-danger">Delet</a>
        <a href="user.php?action=edit&userid='.$user['id'].'"class="btn btn-primary">Edit</a>

        </th></tr>
        ';
        
    }
      ?>
  </tbody>
</table></div>
<?php
}elseif($action=="add"){?>
<div class="container">
    <h1 class="text-center">add uesr</h1>
    <form action="?action=insert" class="add-form mt-3" method="POST">
    <input type="text" class="form-control mt-3" name="name" require="require"  placeholder="uesrname"/>
    <input type="email" class="form-control mt-3" name="email" require="require"  placeholder="email"/>
    <input type="password" class="form-control mt-3 " name="pass" require="require" placeholder="password"/>
    <select name="Ad-id" class="form-control mt-3">
        <option selected > choose uesr jop</option>
        <option value="0">uesr</option>
        <option value="1">admin</option>
    </select>
    <input type="submit" class="btn btn-primary">
    </form>
</div>
<?php
}elseif($action=="insert"){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $select=$_POST['Ad-id'];
        $hashpass=sha1($pass);
    $chek=chekitem("email","users",$email);
    if($chek > 0){
        echo'
        <div class="alert alert-denger">
            <p class="text-center">this email exist</p>
        </div>';
    }else{
        $stmt=$con->prepare(" INSERT INTO 
        users(username,email,password,Admin_id,date)
        VALUES(:zname,:zemail,:zpass,:zid,now())
        ");
        $stmt->execute(array(
            'zname'=>$name,
            'zemail'=>$email,
            'zpass'=>$hashpass,
            'zid'=>$select
        ));
        $count=$stmt->rowCount();
    
        if ($count>0) {
            echo'
            <div class="alert alert-denger">
                <p class="text-success">Your user added</p>
            </div>';
        }else{
            echo'
        <div class="alert alert-denger">
            <p class="text-center">NO user added</p>
        </div>';
        }
    }
    }else{
        echo"you cant brosethis page direct";
    }
}elseif($action=="edit"){
    $user_id='';
    if(isset($_GET['userid'])&&is_numeric($_GET['userid'])){
        $user_id= intval($_GET['userid']);
    }else{
        echo 'error';
    }
    //$user_id='4';  هذي تاع مبلغ مالي تاع التوتال و
    
    $stmt=$con->prepare("SELECT * FROM users WHERE id=? LIMIT 1 ");
    $stmt->execute(array($user_id));
    $fetch=$stmt->fetch();
    $count=$stmt->rowCount();
    if($count>0){
        ?>
    <div class="container">
    <h1 class="text-center">edit uesr</h1>
    <form action="?action=update" class="add-form mt-3" method="POST">
    <input type="hidden" class="form-control mt-3" name="id" require="require" value="<?php echo $user_id?> "  placeholder="user id"/>
    <input type="text" class="form-control mt-3" name="name" require="require" value="<?php echo $fetch['username']?> "  placeholder="uesrname"/>
    <input type="email" class="form-control mt-3" name="email" require="require" value="<?php echo $fetch['email']?>"   placeholder="email"/>
    <input type="hidden" class="form-control mt-3 " name="old_pass"  value="<?php echo $fetch['password']?>"  placeholder="password"/>
    <input type="password" class="form-control mt-3 " name="new_pass"  placeholder="password"/>
    <select name="Ad-id" class="form-control mt-3">
        <option selected value="<?php echo $fetch['Admin_id']  ?>"><?php if($fetch['Admin_id']==0){
echo "uesr";}else{
echo "admin";
}?> </option>
        <option value="">uesr</option>
        <option value="">admin</option>
    </select>
    <input type="submit" class="btn btn-primary">
    </form>
</div>
<?php

    }else{
        echo 'this uesr not founded';
    }
    ?>
<?php
}elseif($action=="update"){
    echo"<h1 class='text-center'>update page</h1>";
    echo"<div class='container'>";
    if($_SERVER['REQUEST_METHOD']=='POST'){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $select=$_POST['Ad-id'];

    $pass='';
    if(empty($_POST['new_pass'])){
        $pass=$_POST['old_pass'];
    }else{
        $pass=sha1($_POST['new_pass']);

    }
    $stmt=$con->prepare("UPDATE users SET username=? , email=?,password=?,Admin_id=? WHERE id=?");
    $stmt->execute(array($name,$email,$pass,$select,$id));
    $count=$stmt->rowCount();
    echo $count;
    if($count>0){
        echo " update success";
    }else{
        echo "error";
    }
    }
    echo"</div>";
}elseif($action=="delete"){

    echo '<h1 class="text-center">delet minber</h1>
    <div class="container">';

    $userid="";
    if(isset($_GET['userid'])&&is_numeric($_GET['userid'])){
        $userid= intval($_GET['userid']);
    }else{
        echo 'error';
    }
    $stmt=$con->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute(array($userid));
    $count=$stmt->rowCount();
    if($count>0){
        $stmt= $con->prepare("DELETE FROM users WHERE id =:ZUSER");
        $stmt->bindParam(':ZUSER',$userid);
        $stmt->execute();
        echo "user delete".$count;
    }else{
        echo "there is user not founded";
    }
    echo'</div>';
}elseif($action=="approve"){
    echo"welcom approve page";
}
include("include/templets/footer.php");

}else{
    header('location:index.php');
} 