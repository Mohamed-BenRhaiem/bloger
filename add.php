<?php

session_start();
$servername = "localhost";
$username = "root";


try {
  $conn = new PDO("mysql:host=localhost;dbname=blog", $username,"");
  

} catch (PDOException $th) {
   echo "failed".$th->getMessage();
}





if(isset($_GET['submit'])){
    $file=filter_var($_GET['file'], FILTER_SANITIZE_STRING);
    $title=filter_var($_GET['title'], FILTER_SANITIZE_STRING);
    $topic=filter_var($_GET['topic'],FILTER_SANITIZE_STRING);
    $query=$conn->prepare("INSERT INTO blog VALUES('$_SESSION[username]',:title,:topic,:file)");
    $query->bindParam(':title',$title);
    $query->bindParam(':topic',$topic);
    $query->bindParam(':file',$file);

    $query->execute();
    header('Location: blog.php');
    exit();
}

if(isset($_GET['logOut'])){
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="#">Laravel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0  ">
        
        <li class="nav-item">
          <a class="nav-link  text-light" href="blog.php">Blog</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-light" href="#"><?php
           if(isset($_SESSION['username'])) echo htmlspecialchars($_SESSION['username']);
           else echo "Login";
           ?></a>
        </li>
        <?php
        if (isset($_SESSION['username'])):
          echo "<form action='add.php' method='GET'> 
          <li class='nav-item'>
            <button class='btn btn-danger text-light' type='submit' name='logOut' >Log out</button>
          </li>
          </form>";
        endif;
        ?>
       
       
      </ul>
      
    </div>
  </div>
</nav>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
    <div class="container text-center">
    <label for="title"class="fs-1 text-danger m-5">Title :</label>
    <input type="text" name="title" class="form-control">

    <label for="Topic" class="fs-1 text-danger m-5">Topic :</label>
    <textarea name="topic" class="form-control"></textarea>
    
    <input class="m-5" type="file" name="file" id="">
    </div>
    <button type="submit" name="submit" class="btn btn-success m-5">ADD</button>
    



</form>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
</body>
</html>