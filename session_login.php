<?php
   include("database.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
    
    $myusername = mysqli_real_escape_string($conn,$_POST['username']);
    $mypassword = mysqli_real_escape_string($conn,$_POST['password']); 
    
    $sql = "SELECT id FROM account WHERE Username = '$myusername' and Password = '$mypassword'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  //   $active = $row['active'];
    
    $count = mysqli_num_rows($result);
    
    // If result matched $myusername and $mypassword, table row must be 1 row
  
    if($count == 1) {
      //  session_register("myusername");
       $_SESSION['login_user'] = $myusername;
       
       header("location: index.php");
    }else {
       $error = "Your Login Name or Password is invalid";
    }
 }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp"
      rel="stylesheet">
   <link rel="stylesheet" href="login-style.css">
</head>

<body id="particles-js">

</body>

   <div class="animated bounceInDown">
     <div class="container">
       <span class="error animated tada" id="msg"></span>
       <!-- <form name="form1" class="box" onsubmit="return checkStuff()"> -->
       <form action = "" method = "post" class="box">
         <h4>ECMS<span>Dashboard</span></h4>
         <h5>Sign in to your account.</h5>

           <input type="text" name="username" placeholder="Email" autocomplete="off" id="user">
           <i class="typcn typcn-eye" id="eye"></i>

           <input type="password" name="password" placeholder="Passsword" id="pwd" autocomplete="off">
           <a href="#" class="forgetpass">Forget Password?</a>
           
           <input type="submit" value="Sign in" class="btn1">
         </form>
           <a href="#" class="dnthave">Don’t have an account? Sign up</a>
     </div> 
   </div>




   <!-- <script>

// Form Validation


function checkStuff() {
  var email = document.getElementById("user").value;
  var password = document.getElementById("pwd").value;
  const msg = document.getElementById("msg");
  var user = "admin";
  var pass = "admin";

if (email == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your username";
    return false;
  } 
   else if (password == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your password";
    return false;
  } 
else if (email == user && password == pass){
    location.href = "index.html";
    return false;

  } else {
    msg.style.display = 'block';
    msg.innerHTML = "Incorrect username or password";
    return false;
  }
}

    </script> -->
</html>