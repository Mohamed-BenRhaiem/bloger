<?php
    session_start();

    $servername = "localhost";

    $username = "root";

    
   
    try {
      $conn = new PDO("mysql:host=localhost;dbname=guest", $username,"");
      
    
    } catch (PDOException $th) {

       echo "failed".$th->getMessage();
    }

   
    

 if ($_SERVER['REQUEST_METHOD']=='POST') {

        $query=$conn->prepare("UPDATE guest SET name=:nom,password=:pass,mail=:email WHERE id=:id ");
        $id=$_SESSION['id'];
       
        
        $query->bindParam(':nom',$_POST['name']);

        $hashed=password_hash($_POST['password'],PASSWORD_DEFAULT);

        $query->bindParam(':pass',$hashed);

        $query->bindParam(':email',$_POST['mail']);

        $query->bindParam(':id',$id);

        $query->execute();

        if ($query->execute()==true) {

            $_SESSION['username']=$_POST['name'];

            $_SESSION['pass']=$_POST['password'];

            $_SESSION['usermail']=$_POST['mail'];

            header( "refresh:2;url=blog.php" );

        }
    }
   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo $_SESSION['username']. " Profile" ?></title>
</head>
<body>

    <form action="profile.php" method="POST" class="form-group text-center container mt-5 p-5">

    <label for="name">Name :</label>
    <input type="text" class="form-control m-3" name="name" value="<?php
    if (isset($query)&&$query->execute()==true) {
        echo "";
    }
     else echo $_SESSION['username'];
      ?>">
    
    <label for="password">Password :</label>
    <input type="password" class="form-control m-3" name="password" value="<?php
    if (isset($query)&&$query->execute()==true) {
        echo "";
    }
     else echo $_SESSION['pass']; ?>">
    
    <label for="password">Email :</label>
    <input type="email" class="form-control m-3" name="mail" value="<?php 
    if (isset($query)&&$query->execute()==true) {
        echo "";
    }
    else echo $_SESSION['usermail']; ?>">

    <button class="btn btn-success mt-5">UPDATE</button>

    </form>
    <?php
    if (isset($query)&&$query->execute()==true) {
        
       echo "<center><div class='alert alert-success text-dark col-6 mt-5 lead'> your profile has updated successfully </div></center>";
    }
    ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>