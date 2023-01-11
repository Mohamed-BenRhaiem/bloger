

<?php


session_start();
error_reporting(0);
$servername = "localhost";
$username = "root";
$loginError=[
  'emailError' =>'',
  'passError' =>'',
];

// Create connection
$conn = new mysqli($servername, $username,"","guest");
// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




if($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  $user=MYSQLI_REAL_ESCAPE_STRING($conn,$_POST['email']) ;
  
  $qr="SELECT name FROM guest WHERE mail='$user'";
  
  $rs=mysqli_query($conn, $qr);
  
  $_SESSION['usermail'] = $user;
  
  $_SESSION['username']= mysqli_fetch_array($rs)[0];

  $userPass=filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

  $_SESSION['pass']=$userPass;

  $query="SELECT id,mail,password FROM guest WHERE mail='$user'";
  
  $res=mysqli_query($conn, $query);

  $qry="SELECT * FROM guest WHERE mail LIKE '$user'";
  
  $result=mysqli_query($conn,$qry);
  
  if(mysqli_num_rows($res)==0){
    
    $loginError['emailError']="This mail did not registered";
  }
  if (empty($userPass)){ {
    $loginError['passError']="Please enter a password";
  }}
  
  if(!filter_var($user,FILTER_VALIDATE_EMAIL)){
    
    $loginError['emailError']="Please enter a valid email address";
  }
  if (empty($user)){ 
    
    $loginError['emailError']="Please enter an email";
  }
  if(!array_filter($loginError)){
    
    while ($row = mysqli_fetch_array($res)){ 
      $dbMail= $row['mail'];
      
      $dbPassword=$row['password'];
      $_SESSION['id']=$row['id'];
  }
  if(password_verify($userPass,$dbPassword) ){
    
   
    header('Location:blog.php');
    
    
    
     exit();
     
    
     
  }else{
    $loginError['passError']="password is incorrect";
  }
  
}

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <title>Login Page PAGE</title>
</head>
<body style=" background-color:#F1F1F1">
<?php require_once 'nav.php' ?>
<div style="max-width:50vw;" class="container">
<div class="main-title text-center text-danger fs-1 mt-5">Login</div>
<form action="<?php $_SERVER['PHP_SELF']?>"method="POST">




  <div class="login-form text-center m-5 p-5 bg-white shadow">
    <label for="name">Name :</label>
        <input type="text" class="form-control m-3 "required>
        <label for="Email">E-Mail Address:</label>
        <input type="text" name="email" class="form-control  m-3 " value="<?php if (isset($user)) {
          echo $user;
        }?>">
        <div class="input-text error text-danger mb-4"><?php  echo htmlspecialchars($loginError['emailError'])  ?></div>
        <label for="password">Password:</label>
        <input type="password" name="pass" class="form-control  m-3 " value="<?php if (isset($userPass)) {
          echo $userPass;
        }  ?>">
        <div class="input-text error text-danger mb-3"><?php  echo htmlspecialchars( $loginError['passError'])  ?></div>

      <div class="d-inline-block m-4">
     
      <input class="form-check-input  " type="checkbox" value="" aria-label="Checkbox for following text input">
      <label for="remeber me"class="">Remember me</label>
      </div>
      

        <a  href="change.php">Forgot Name</a>

        <div class="d-grid gap-2 col-11 mx-auto">
  <button class="btn btn-primary p-3" name="enter" type="submit">Login</button>
 
</div>
  </div>
</div>

</form>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
