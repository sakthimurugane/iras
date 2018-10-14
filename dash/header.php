<?php 
 require_once '../controllers/authcontroller.php';
 require_once '../app_config/dbproperties.php';
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
  <link rel="shortcut icon" src="../img/favicon.ico" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">
  <?php 
      if(isset($_GLOBALS['CALENDARPAGE']) && trim($_GLOBALS['CALENDARPAGE']=='true')){
   ?>
    <link href="../css/tcal.css" rel="stylesheet" media="screen">
    
    <?php     
    }
    if(isset($_GLOBALS['CUSTSEARCH']) && trim($_GLOBALS['CUSTSEARCH']=='true')){
   ?>
    
    <link href="../vendor/chosen/chosen.min.css" rel="stylesheet" media="screen">
    <?php     
    }
    
    if(isset($_GLOBALS['SUGGESTS'])){
    ?>
        <link href="../vendor/easyautocomplete/easy-autocomplete.min.css" rel="stylesheet" media="screen">
    <?php 
    }
    ?>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">