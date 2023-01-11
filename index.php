
<?php

$servername = "localhost";
$username = "root";



try {

  $conn = new PDO("mysql:host=localhost;dbname=guest", $username,"");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $th) {
  echo "Failed".$th->getMessage();
}

 

  $formError=[
    'nameError'=>'',
    'mailError'=>'',
    'passwordError'=>'',
    'confirmError'=>'',
  ];


if($_SERVER['REQUEST_METHOD']=='POST'){

    $name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);

    
    $mail=filter_var($_POST['mail'],FILTER_SANITIZE_STRING);

    $password=filter_var($_POST['password'],FILTER_SANITIZE_STRING);

    $confirm=filter_var($_POST['confirm'],FILTER_SANITIZE_STRING);

    $query=$conn->prepare("SELECT name FROM guest WHERE name LIKE '$name'");

    $qry=$conn->prepare("SELECT mail FROM guest WHERE mail LIKE '$mail'");


 

    $query->execute();

    $qry->execute();

    $row=$query->rowCount();

    $row2=$qry->rowCount();
    
   
    if($row==1){
            $formError['nameError']="This name has already used.";
    }
    if($row2==1){
            $formError['mailError']="This email has already used.";
    }


    if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
        $formError['mailError'] ="Please enter a valid email address";
    }

    if(empty($mail)){
        $formError['mailError'] ="This form is required";
    }


   if(empty($password)){
    $formError['passwordError']="This form is required";
   }

   if(empty($name)){
    $formError['nameError']="This form is required";
   }

   if(empty($confirm)){
    $formError['confirmError']="This form is required";
   }


   if($confirm!=$password){
    $formError['confirmError']="confirm password doesn't match the password";
   }

   
   if(!array_filter($formError)){

    $name=filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    $mail=filter_var($_POST['mail'], FILTER_SANITIZE_STRING);

    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

    $confirm=password_hash($_POST['confirm'], PASSWORD_DEFAULT);
  
    $sql=$conn->prepare("INSERT INTO guest VALUES (0,:nom,:mail,:password)");
    $sql->bindParam(':nom',$name);
    $sql->bindParam(':mail',$mail); 
    $sql->bindParam(':password',$password);
    
    $sql->execute();

    $name="";

    $mail="";

    $password="";

    $confirm="";

    header('Location: home.php');

    exit();

   }
   
}


//close the connection

?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Register Page</title>
</head>
<body style="background-color:#F1F1F1">
<?php include 'nav.php' ?>

<div style="max-width:50vw;" class="container">
<div class="main-title text-center text-danger fs-1 mt-5 mb-2">Register</div>
<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">




  <div class="Register-form text-center m-3 p-5 bg-white shadow">
        
        <label for="Email">Name:</label>
        <input class="form-control  m-3 " type="text" name="name"  value=<?php 
        if(isset($name)){
            echo "$name";
        }
        ?> >
        <div class="input-text error text-danger mb-4"><?php  echo htmlspecialchars($formError['nameError'])   ?></div>
      

        <label for="Email">E-Mail Address:</label>
        <input class="form-control  m-3 " type="text" name="mail"  value=<?php 
        if(isset($mail)){
            echo "$mail";
        }
        ?> >
        <div class="input-text error text-danger pb-4"><?php  echo htmlspecialchars( $formError['mailError']) ?></div>

        <label for="Email">Password:</label>
        <input  class="form-control  m-3 " type="password" name="password" value=<?php 
        if(isset($password)){
            echo "$password";
        }
        ?> >
        <div class="input-text error text-danger mb-4"><?php echo htmlspecialchars( $formError['passwordError'])  ?></div>

        <label for="Email">Confirm Password:</label>
        <input class="form-control  m-3 " type="password" name="confirm"  value=<?php 
        if(isset($confirm)){
            echo "$confirm";
        }
        ?> >
        <div class="input-text error text-danger"><?php echo htmlspecialchars($formError['confirmError'] )  ?></div>

      <div class="d-inline-block m-4">
     
      <input class="form-check-input  " type="checkbox" value="" aria-label="Checkbox for following text input">
      <label for="remeber me"class="">Remember me</label>
      </div>
      



        <div class="d-grid gap-2 col-11 mx-auto ">
  <button class="btn btn-primary p-3 " name="register" type="submit">Register</button>
 
</div>
  </div>
</div>

</form>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>