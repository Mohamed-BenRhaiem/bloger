<?php
session_start();


$servername = "localhost";
$username = "root";



try {

  $conn = new PDO("mysql:host=localhost;dbname=guest", $username,"");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $th) {
  echo "Failed".$th->getMessage();
}



if(isset($_POST['change'])){
    $mail=$_POST['mail'];
   
    $query=$conn->prepare("SELECT * FROM guest WHERE mail=:email");

    $query->bindParam(':email',$mail);

    $query->execute();

    $row=$query->fetch(PDO::FETCH_ASSOC);
    

    require_once 'mail.php';
    $mail->setFrom('abrcondori@yahoo.fr','mouda');
    $mail->addAddress('mohamedbenrhayemm@gmail.com');
    $mail->Subject='Restoring the password';
    $mail->Body="<h1>Welcome </h1 style='font-weight:bold;'><p>  your name is " .$row['name'].   " </p>
    <button>VERIFY</button>
    ";
    $mail->send();
    header('Location: home.php');
}





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <title>Pass Handle</title>
</head>
<body>
    <form action="change.php" method="POST" class="form-group text-center mt-5 w-25 m-auto">
        <label class="lead" for="mail">email :</label>
        <input type="email" class="form-control m-3" name="mail" required>

        <button class="btn btn-primary" name="change" type="submit">SEND</button>
        <br>
        

    </form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>