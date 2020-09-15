  <?php
  require_once 'dbcon.php';
  session_start();
  if(isset($_SESSION['user_login'])){
      header('location: dashboard.php');
  }
      if(isset($_POST['login'])){
          $username   = $_POST['username'];
          $password   = $_POST['password'];
          
          $result = mysqli_query($link, "SELECT * FROM `admin_user` WHERE `username`='$username';");
          if(mysqli_num_rows($result)>0){
              $row = mysqli_fetch_assoc($result);
              if($row['password']==$password){
                  
                  $_SESSION['user_login'] = $password;
                  header('location: dashboard.php');
                  
              }else{
                  $pass = "Password Not Match";
              }
          }else{
              $usererr= "Username Not Found";
          }
      }

  ?>

  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>POS - Login</title>
      <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
      <link href="css/styles.css" rel="stylesheet">
    </head>
    <body class="bg-dark">
      <div class="container mt-5">
          <h1 class="text-center text-white">Welcome our POS management system</h1>
        <div class="card card-login mx-auto mt-5">
          <div class="card-header bg-primary text-white">Login to your account</div>
          <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="username">Username</label>
                    <input type="text"  class="form-control" id="username" required="required" autofocus="autofocus" name="username">
              </div>
              <div class="form-group">
                <label for="Password">Password</label>
                    <input type="password"  class="form-control" id="Password" required="required" name="password">
                </div>
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="remember-me">
                    Remember Password
                  </label>
                </div>
              </div>
                <input type="submit"  class="btn btn-primary btn-block"  name="login" value="login">
            </form>
            <div class="text-center">
              <br>
              <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
            </div>
              <div>
              <p>If you not have account than <a href="registration.php">Registration</a> </p>
          </div>
          </div>
          
         <div class="text-center">
              <?php
                  if(isset($usererr)){
              echo $usererr;
          }
           if(isset($pass)){
              echo $pass;
          }
          ?>
          </div>
        </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery.easing.min.js"></script>
    </body>
  </html>
