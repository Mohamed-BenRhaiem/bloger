<?php
session_start();



$servername = "localhost";
$username = "root";






try {
  
$conn = new PDO("mysql:host=localhost;dbname=blog", $username,"");

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



} catch (PDOException $e) {
  echo "Failed".$e->getMessage();
}


$res=$conn->prepare("SELECT creator,title,content,image FROM blog");
$res->execute();



/*$q = "INSERT INTO blog (creator) VALUES ('edam')";

$conn->exec($q);*/

$t=[];

$c=[];

$C=[];

$img=[];




while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    $dbTitle=$row['title'];

    $dbContent=$row['content'];

    $dbCreator=$row['creator'];

    $dbImg=$row['image'];

    array_push($t,$dbTitle);

    array_push($c,$dbContent);

    array_push($C,$dbCreator);

    array_push($img,$dbImg);

    

}


if(isset($_GET['delete'])){
    $getnom=filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
    $query=$conn->prepare("DELETE FROM blog WHERE title = :nom");
    $query->bindParam('nom',$getnom);
    $query->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
    exit();
    
}



if (isset($_GET['logOut'])) {
  session_unset();
  session_destroy();
  header('Location: home.php');
  exit();
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >

    <title>Blog Page</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="#">Laravel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto  mb-2 mb-lg-0  ">
        
        <li class="nav-item">
          <a class="nav-link  text-light" href="blog.php">Blog</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-light" href="profile.php"><?php
           if(isset($_SESSION['username'])) echo htmlspecialchars($_SESSION['username']);
           else echo "Login"; ?></a>
        </li>
        <li class="nav-item">
          <a class="btn btn-danger  text-light" href="home.php" type="button"><?php
          if (isset($_SESSION['username'])):
            echo "<form action='add.php' method='GET'> 
            
              <button class='btn btn-danger text-light' name='logOut' >Log out</button>
            
            </form>";
          endif;
        ?>
        </a>
        </li>
        
       
      </ul>
      
    </div>
  </div>
</nav>


<a href="add.php" class="btn btn-danger m-5">Add a Blog</a>
<div class="main-title fs-1 text-primary text-center  p-2">All Topics</div>




   <?php
   for($i=0;$i<sizeof($t);$i++) {?>

   
    <form action="blog.php"method="GET">
    <div class="content row-12 m-5 d-flex">
    <div class="col-6">
        <img style="max-width:70%; border-radius:10px;" src="<?php echo $img[$i] ?>" alt="">
      
    </div>
    <div class="col-6">
    <div class="fs-1 text-primary "> <?php echo $t[$i] ?>  </div>
    <small class=" text-warning mb-5"><?php echo "Added by ".$C[$i] ?></small>
    <div class="lead text-muted m-5">  <?php 
   
    echo $c[$i]
     ?>  </div>
    </div>
    
    </div>
    <button class="btn btn-danger m-5" value="<?php  echo $t[$i] ?>" name="delete">DELETE</button>
    
    </form>
    

 <?php  }?>
   
 <?php if($res->rowCount()==0){
  echo " <div class='lead text-muted m-5 p-5 text-center'>there is no data to display</div> ";
 
    
}?>
   
 








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>

</body>
</html>