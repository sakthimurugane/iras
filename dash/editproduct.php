<?php
//Page settings
$_GLOBALS['CALENDARPAGE']='true';
//Function to sanitize values received from the form. Prevents SQL injection
require_once 'utilities.php';
$prid=-1;
if(!isset($_REQUEST['prid']) && trim($_REQUEST['prid'])==''){
if(isset($_SERVER['HTTP_REFERER'])){
    header("location:" . $_SERVER['HTTP_REFERER']);
}else{
    header("location: ../dash/products.php");
}
}else{
    $prid=clean($_REQUEST['prid']);
}
$_GLOBALS['CALENDARPAGE']='true';
include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';

$servicelistqry="SELECT * from products where is_deleted=0 and product_id=$prid";

$result=mysqli_query($link,$servicelistqry);

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="products.php">Products</a>
        </li>
        <li class="breadcrumb-item active">Edit Product</li>
      </ol>
       <?php

          if( isset($_SESSION['ERRMSG_MODPRODUCT'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['ERRMSG_MODPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['ERRMSG_MODPRODUCT']);
          }elseif(isset($_SESSION['SCSMSG_MODPRODUCT'])){
              echo '<div class="alert alert-success alert-dismissible">',$_SESSION['SCSMSG_MODPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SCSMSG_MODPRODUCT']);
          }
          ?>
       <!-- products DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-list-alt"></i> Edit Products Inventory
          </div>

          <?php    
          if($result) {
           ?>

        <div class="card-body">
          <div class="table-responsive panel">
          <form id="modprodForm" name="modprodForm" action="../controllers/editproduct.php" method="post">
              <table class="table">


              <tbody>
                
                <?php 
                if(mysqli_num_rows($result) > 0) { 
            while($row = $result->fetch_assoc()){
                
                ?>
    			<tr>
                	<td class="text-success"><i class="fa fa-info"></i> Product code</td>
                	<td><input type="text" class="form-control" name="epcode" id="epcode" size="20" Placeholder="Product code" value="<?php echo $row['product_code'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Product name</td>
                    <td><input type="text" class="form-control" name="epname" id="epname" size="20" Placeholder="Product name" value="<?php echo $row['product_name'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-flag"></i> HSN/SAC</td>
                    <td><input type="text" class="form-control" name="ephsn" id="ephsn" size="20" Placeholder="01234" value="<?php echo $row['hsnsac'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-indent"></i> Quantity</td>
                    <td><input type="text" class="form-control" name="epqty" id="epqty" size="20" Placeholder="1 or 100" value="<?php echo $row['quantity'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-indent"></i> Alert me when Quantity is </td>
                    <td><input type="text" class="form-control" name="epaqty" id="epaqty" size="20" Placeholder="1 or 100" value="<?php echo $row['alert_qty'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-dollar"></i> Original Price</td>
                    <td><input type="text" class="form-control" name="epoprice" id="epoprice" size="20" Placeholder="5.00"  value="<?php echo $row['o_price'];?>"/></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-dollar"></i> Selling Price</td>
                    <td><input type="text" class="form-control" name="epsprice" id="epsprice" size="20" Placeholder="7.00"  value="<?php echo $row['s_price'];?>"/></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-calendar"></i> Arrival date</td>
                    <td><input type="text" class="form-control tcal" name="epardate" id="epardate" size="20" value="<?php echo $row['arrival_date'];?>"/></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-calendar"></i> Expiry date</td>
                    <td><input type="text" class="form-control tcal" name="epexdate" id="epexdate" size="20" value="<?php echo $row['expiry_date'];?>"/></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-male"></i> Supplier</td>
                    <td>
                    <select name="epsupid" class="custom-select">
                     <?php 
                    $subserquery="SELECT supplier_id, supplier_name from suppliers where is_deleted=0 order by created_on desc";
                    $subresult = mysqli_query($link,$subserquery);
                    
                    ?>
                    <option>None</option>
                    <?php 
                        if($subresult) {
                            if(mysqli_num_rows($subresult) > 0) {
                                while($subrow = $subresult->fetch_assoc()){
                        ?>
                            <option value="<?php echo $subrow['supplier_id'];?>"   <?php if($subrow['supplier_id']==$row['supplier_id']){echo "selected";}?> ><?php echo $subrow['supplier_name'];?></option>
                            
                            <?php 
                                }}}
                            ?>
                	</select>
               
                </td></tr>
                <tr>
                
                <td></td>
                
                <td>
                
        			<input type="hidden" name="spid" id="spid" value="<?php echo $row['product_id']; ?>"/>
                    <button type="submit" name="modproductsubmit" id="modproductsubmit" class="btn btn-success btn-sm btn-default"><i class="fa fa-floppy-o fa-1x"></i> Save</button>
                    <button type="reset" class="btn btn-danger btn-sm btn-default"><i class="fa fa-window-close-o	 fa-1x"></i> Cancel</button>
               	 <a href="<?php 
                    if(isset($_SERVER['HTTP_REFERER'])){
                        echo $_SERVER['HTTP_REFERER'];
                    }else{
                        echo 'products.php';
                    }
                    
                    
                    ?>" class="btn btn-warning btn-sm btn-default"><i class="fa fa-arrow-circle-o-left fa-1x"></i> Back</a>
                </td>
                
                </tr>
                
                <?php

                }
                
                }else{
                    ?>
                    
                    
                    <tr><td><div class="card-footer small text-muted">No such product found. Please go back to products page or contact System Administrator.</div></td></tr>
                    
                    <?php
                    
                }
                ?>
                
                </tbody>
                </table>
                
                </form>
                </div>
                </div>
                
                <?php 
            }
            else{
                }
                ?>	

      </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->


<?php 
include_once 'footer.php';

?>