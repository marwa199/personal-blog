<?php
session_start();
 include('include/connection.php');

?>

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Personal Blog</title>
    <meta name="keywords" content="personal blog,responsive layout" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="fontawesome/css/all.min.css">

</head>

<body>
    <div class="container">
        <h3 class="text-center mt-5 mb-3">Sign In</h3>
       <form class="w-50 bg-light p-5 m-auto rounded-2 align-self-center" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
           <?php

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
              $adminMail=$_POST['email'];
              $adminPass=$_POST['pass'];
              if(empty($adminMail)||empty($adminPass)){
                echo "<div class='alert alert-danger'>" . "email and password are required" . "</div>";
              }
              else{
                $stmt=$db->prepare('SELECT * FROM admin WHERE email="$adminMail" AND pass="$adminPass"');
                $stmt->execute();
                $cols=$stmt->fetchAll();

                if(in_array($adminMail,$cols)&&in_array($adminPass,$cols) ){
                  echo "<div class='alert alert-danger'>" . "email or password are not correct" . "</div>";
                }
                else{
                  $_SESSION['id']=$cols['id'];
                  echo "<div class='alert alert-success'>" . "main page will be open soon" . "</div>";
                  header('REFRESH:2;URL=dashboard/categories.php');               
              
                }
              }
            }

          ?>
          <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="formGroupExampleInput">
          </div>
          <div class="mb-5">
            <label for="formGroupExampleInput" class="form-label">Password</label>
            <input name="pass" type="password" class="form-control" id="formGroupExampleInput">
          </div>
          <div class="mb-3 text-center">
            <button type="submit" class="btn px-4 p-3">Sign In</button>
          </div>
          <!-- <div class="mt-5">
            <label for="formGroupExampleInput" class="form-label">have not an account ? <a href="register.html" class="btn link-danger px-5">Register</a> </label>
          </div> -->
       </form> 
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>