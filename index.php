<?php
require_once 'app_config/config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $GLOBALS['APP_NAME'].' - ' .$GLOBALS['APP_VERSION'] ; ?></title>
  <!-- Bootstrap core CSS-->
    <link rel="shortcut icon" src="../img/favicon.ico" type="image/x-icon">
  
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">

  <div class="container">
                  <?php
                    if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
                        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
                            echo '<div class="alert alert-danger alert-dismissible  mx-auto mt-5">',$msg,'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
                        }
                        unset($_SESSION['ERRMSG_ARR']);
                    }
               ?>
    <div class="card card-login mx-auto mt-5">

      <div class="card-header">Login</div>
      <div class="card-body">
        <form name="loginForm" id="loginForm" method="post" action="controllers/logincontroller.php">
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input class="form-control" id="exampleInputEmail1" name="inusn" type="text" maxlength="20" aria-describedby="emailHelp" placeholder="Enter Username" data-validation="required" >
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="inpass" name="inpass" type="password" maxlength="20" placeholder="Password" data-validation="required">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="loginSubmit">Login</button>
        </form>
        <div class="text-center">
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a><br/>
          <small><?php echo $GLOBALS['APP_NAME'].' - ' .$GLOBALS['APP_VERSION'] ; ?></small>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/form-validator.min.js"></script>
  <script>
      $.validate({
      form : '#loginForm'
    	});
  </script>

</body>

</html>
