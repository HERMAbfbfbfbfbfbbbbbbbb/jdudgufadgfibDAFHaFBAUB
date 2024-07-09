<?php
session_start();
$Titel = "artical";
if(isset($_SESSION['USERNAME'])){
        include("init.php");

$action="";
if(isset($_GET['action'])){
    $action=  $_GET['action'];
}else{
$action= "mange";
}
if($action=="mange"){
  $stmt=$con->prepare("SELECT * FROM department");
  $stmt->execute();
  $rows=$stmt->fetchAll();
  ?>
<div class="container">
  <div class="row">
<div class="card" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title text-center">all department</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="department.php?action=add" class="btn btn-primary">add new department</a>
  </div>
</div>
</div>
<div class="row">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#id</th>
      <th scope="col">name</th>
      <th scope="col">discerption </th>
      <th scope="col">all_comment</th>
      <th scope="col">control</th>
    </tr>
  </thead>
  <tbody><?php
      foreach($rows as $row){

    echo'<tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["name"].'</td>
      <td>'.$row["discerption"].'</td>
      <td>'.$row["all_comment"].'</td>
      <td >
      <a href="department.php?action=delete&d_id='.$row['id'].'"class="btn btn-danger">Delet</a>
      <a href="department.php?action=edit&d_id='.$row['id'].'"class="btn btn-success">Edit</a>

      </td></tr>';}
    ?>
  </tbody>
</table>
</div>
</div>
<?php
}elseif($action=="add"){
    ?>
    <div class="container">
        <h1 class="text-center">Add new Department</h1>
        <form action="?action=insert" method="POST" enctype="multipart/form-data" >
  <div class="form-group">
    <label for="exampleFormControlInput1">Titel</label>
    <input type="email" class="form-control" name='titel' placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlFile1">photo</label>
    <input type="file" class="form-control-file" name="photo">
  </div>

  <div class="form-group">
    <label for="exampleFormControlTextarea1">content</label>
    <textarea class="form-control" name="content" rows="3"></textarea>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">auther</label>
    <select class="form-control" name="auther">
      <option>1</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">departmwnts</label>
    <select multiple class="form-control" name="departmwnts">
      <option>1</option>
    </select>
  </div>
  
</form>
    
    
  <button type="submit" class="btn btn-primary">Submit</button>
  </form></div><?php
  }elseif($action=="insert"){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $name=$_POST['name'];
      $disc=$_POST['discerption'];
      $comnt=$_POST['c'];
      $stmt=$con->prepare("INSERT INTO department(name,discerption	,all_comment) VALUES(:zname,:zdisc,:zcomnt)");
      $stmt->execute(array(
        'zname'=>$name,
        'zdisc'=>$disc,
        'zcomnt'=>$comnt
    ));
    $count=$stmt->rowCount();

    if ($count>0) {
        
      $message='<div class="alert alert-success">Your department added'.$comnt.'</div>';
      r($message,6,"back");
    }else{
        echo'
    <div class="alert alert-denger">
        <p class="text-center">NO user added</p>
    </div>';
    } 
    }
    else{
      $message='<div class="alert alert-danger">you cant brosethis page direct</div>';
      r($message,6,"back");
}
    
    }elseif($action=="edit"){
      $d_id="";
    if(isset($_GET['d_id'])&&is_numeric($_GET['d_id'])){
        $d_id= intval($_GET['d_id']);
    }else{
        echo 'error';
    } 
      $stmt=$con->prepare("SELECT * FROM department WHERE id=? ");
      $stmt->execute(array($d_id));
      $row=$stmt->fetch();
      $count=$stmt->rowCount();
      if ($count>0) {
      
      ?>
      <div class="container">
          <h1 class="text-center">edit  Department</h1>
      <form action="?action=update" method="POST">
      <div class="form-group">
      <input type="hidden" class="form-control" name="id" value="<?php echo $d_id; ?>" placeholder="name of department">

        <label for="exampleFormControlInput1">name</label>
        <input type="text" class="form-control" name="name" value="<?php echo $row["name"]; ?>" placeholder="name of department">
      </div>
      
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Discerption of Department</label>
        <textarea class="form-control" name="discerption"  rows="3"><?php echo $row["discerption"]; ?></textarea>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect1">All comment</label>
        <select class="form-control" name="c">
        <option selected value="<?php echo $row['all_comment']  ?>"><?php if($row['all_comment']==0){
echo "not allow";}else{
echo "allow";
}?> </option>
          <option value='1'>allow</option>
          <option value="0">not allow</option>
        </select>
      </div>
      
      
    <button type="submit" class="btn btn-primary">Submit</button>
    </form></div><?php
    }else{
      $message='<div class="alert alert-danger">this department not founded</div>';
      r($message,6);
    }
    }elseif($action=="update"){
      echo "<h1 class='text-center'>update department</h1>
      <div class='container'>
      ";

      if($_SERVER['REQUEST_METHOD']=='POST'){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $disc=$_POST['discerption'];
        $comnt=$_POST['c'];
        $stmt=$con->prepare("UPDATE department SET name=? , discerption=?,all_comment=? WHERE id=?");
        $stmt->execute(array($name,$disc,$comnt,$id));
        $count=$stmt->rowCount();
        if($count>0){
          $message='<div class="alert alert-success">Your department updated successfly</div>';
      r($message,15);
        }else{
          $message='<div class="alert alert-danger"> department not updated</div>';
      r($message,6);
        }
      }
      echo"</div>";
    }elseif($action=="approve"){
      
    }elseif($action=="delete"){
      echo '<h1 class="text-center">delet minber</h1>
      <div class="container">';
      $d_id="";
      if(isset($_GET['d_id'])&&is_numeric($_GET['d_id'])){
        $d_id= intval($_GET['d_id']);
    }else{
      $message='<div class="alert alert-danger">error</div>';
      r($message,6);
    }
    $stmt=$con->prepare("SELECT * FROM department WHERE id=?");
    $stmt->execute(array($d_id));
    $count=$stmt->rowCount();
    if($count>0){
        $stmt= $con->prepare("DELETE FROM department WHERE id =:ZUSER");
        $stmt->bindParam(':ZUSER',$d_id);
        $stmt->execute();
        $message='<div class="alert alert-success">Your department are deleted</div>';
        r($message,15);
          }else{
      $message='<div class="alert alert-danger">there is department not founded</div>';
      r($message,6);
    }
      echo'</div>';
    }else{
    echo"error";
}

include("include/templets/footer.php");
}else{
    header('location:index.php');
}