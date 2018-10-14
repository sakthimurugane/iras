<?php

include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
include_once 'utilities.php';

$customercnt=0;
$lowproductcnt=0;
$billcnt=0;
$totalpendingcnt=0;

if(($result = mysqli_query($link,"select count(*) as CNT from CUSTOMER where is_deleted=0"))){
    $row=$result->fetch_assoc();
    $customercnt=$row['CNT'];
}

if(($result = mysqli_query($link,"select count(*) as CNT from Products where is_deleted=0 and quantity <= alert_qty"))){
    $row=$result->fetch_assoc();
    $lowproductcnt=$row['CNT'];
}

if(($result = mysqli_query($link,"select count(*) as CNT from invoice_details where is_deleted=0 and bill_date='".getTodayDate()."'"))){
    $row=$result->fetch_assoc();
    $billcnt=$row['CNT'];
}

if(($result = mysqli_query($link,"select count(*) as CNT from invoice_details where is_deleted=0 and payment_status='S' "))){
    $row=$result->fetch_assoc();
    $totalpendingcnt=$row['CNT'];
}

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <a href="#">Dashboard</a>
        </li>
        <!--  <li class="breadcrumb-item active">Cards</li> -->
      </ol>
      <h1>Daily Notifications</h1>
      <hr>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <div class="mr-5"><?php echo $customercnt ?> Customers Added!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo ($customercnt)>0?"customers.php":"#"; ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5"><?php echo $lowproductcnt;?> Products are in low quantity!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo ($customercnt)>0?"products.php?filter=low":"#"; ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-shopping-cart"></i>
              </div>
              <div class="mr-5"><?php echo $billcnt;?> invoice(s) done!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo ($billcnt)>0?"invoice.php?filter=0":"#"; ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-support"></i>
              </div>
              <div class="mr-5"><?php echo $totalpendingcnt; ?> pending payments</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo ($totalpendingcnt)>0?"invoice.php?filter=pending":"#"; ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    
<?php 
include_once 'footer.php';

?>