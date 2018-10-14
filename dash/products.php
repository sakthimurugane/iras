<?php
//Page settings
$_GLOBALS['ISTABLEPAGE']='true';
$_GLOBALS['CALENDARPAGE']='true';
include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
include_once 'utilities.php';


$servicelistqry="SELECT * from products where is_deleted=0 order by created_on desc";

if(isset($_REQUEST['filter']) && !trim($_REQUEST['filter']=='')){
    if($_REQUEST['filter']=='low'){
        $servicelistqry="SELECT * from products where is_deleted=0 and quantity <= alert_qty order by created_on desc";
    }
}
$result=mysqli_query($link,$servicelistqry);

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Products</li>
      </ol>
       <?php
            if( isset($_SESSION['ERRMSG_ADDPRODUCT'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['ERRMSG_ADDPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['ERRMSG_ADDPRODUCT']);
          }elseif(isset($_SESSION['SCSMSG_ADDPRODUCT'])){
              echo '<div class="alert alert-success alert-dismissible">',$_SESSION['SCSMSG_ADDPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SCSMSG_ADDPRODUCT']);
          }
          
          if( isset($_SESSION['ERRMSG_DELPRODUCT'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['ERRMSG_DELPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['ERRMSG_DELPRODUCT']);
          }elseif(isset($_SESSION['SCSMSG_DELPRODUCT'])){
              echo '<div class="alert alert-success alert-dismissible">',$_SESSION['SCSMSG_DELPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SCSMSG_DELPRODUCT']);
          }
          
          
          ?>
       <!-- products DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-list-alt"></i> Products Inventory
          <a href="addproduct.php" class=" text-center btn btn-success btn-sm btn-default">
           <i class="fa fa-plus"></i>Add Product
			</a>
          </div>
          
          <?php    
          if($result) {
           ?>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>HSN/SAC</th>
                  <th>Quantity</th>
                  <th>Expiry Date</th>
                  <th>Supplier</th>
                  <th>Option</th>
                </tr>
              </thead>

              <tbody>
                
                <?php 
                if(mysqli_num_rows($result) > 0) { 
            while($row = $result->fetch_assoc()){
                $viewsupname='None';
                
           ?>
                <tr>
                  <td><?php echo $row['product_code'];?></td>
                  <td><?php echo $row['product_name'];?></td>
                  <td><?php echo $row['hsnsac'];?></td>
                  <td><?php 
                  
                  
                  
                  if($row['quantity'] <= $row['alert_qty']){
                  ?>
                  
                 <div class="text-warning" title="low quantity"> <?php echo $row['quantity'];?> <i class="fa fa-exclamation-circle"></i> </div>
                                    
                                    <?php 
                  }else{
                      echo $row['quantity'];
                  }
                                    ?>
                  
                  </td>
                  <td><?php echo getCustomDate($row['expiry_date']);?></td>
                  <td><?php 
                  $subserquery="SELECT supplier_name from suppliers where is_deleted=0 and supplier_id=".$row['supplier_id'];
                  $subresult = mysqli_query($link,$subserquery);
                  if($subresult) {
                      if(mysqli_num_rows($subresult) == 1) {
                          while($subrow = $subresult->fetch_assoc()){
                              $viewsupname=$subrow['supplier_name'];
                              echo $viewsupname;
                          }
                      }else{
                          echo $viewsupname;
                      }
                  }else{
                      echo $viewsupname;
                      
                  }
                  
                  
                  
                  
                  ?></td>
                   <td class="text-center">
                   <div class="btn-group text-center">
                            <a data-toggle="modal" data-target="#viewoption<?php echo $row['product_id'];?>"><button class="btn btn-success btn-sm btn-default btn-mini" title="View"><i class="fa fa-eye fa-1x"></i></button></a>
                            <a href="editproduct.php?prid=<?php echo $row['product_id'];?>"> <button class="btn btn-warning btn-sm btn-default btn-mini" title="Edit"><i class="fa fa-edit fa-1x"></i></button></a>
                            <a data-toggle="modal" data-target="#deleteoption<?php echo $row['product_id'];?>"> <button class="btn btn-danger btn-sm btn-default btn-mini" title="Delete"><i class="fa fa-trash fa-1x"></i></button></a>
                    </div>
                        <!-- Modal to delete Product-->
                        <div class="modal fade" id="deleteoption<?php echo $row['product_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row['product_id'];?>" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="myModalLabel<?php echo $row['product_id'];?>"><i class="fa fa-trash"></i> <span class="text-right"> Delete Product</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                    	Are you sure want to delete this product ? <br/>
                                    	Product code: <?php echo $row['product_code']; ?> &nbsp;
                                    	HSN/SAC: <?php echo $row['hsnsac']; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="../controllers/deleteproduct.php?prid=<?php echo $row['product_id']; ?>" class="btn btn-success"><i class="fa fa-trash"></i> Delete</a>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        
                        <!-- Modal to view Product-->
                        <div class="modal fade" id="viewoption<?php echo $row['product_id'];?>" tabindex="-1" role="dialog" aria-labelledby="vwModalLabel<?php echo $row['product_id'];?>" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="vwModalLabel<?php echo $row['product_id'];?>"><i class="fa fa-trash"></i> <span class="text-right"> View Product Details</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">

			<div class="table-responsive panel">
                            <table class="table">
                               <tbody>
				<tr>
                	<td class="text-success"><i class="fa fa-info"></i> Product code</td>
                	<td><?php echo $row['product_code'];?></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Product name</td>
                    <td><?php echo $row['product_name'];?></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-flag"></i> HSN/SAC</td>
                    <td><?php echo $row['hsnsac']; ?></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-indent"></i> Quantity</td>
                    <td><?php echo $row['quantity'];?></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-dollar"></i> Original Price</td>
                    <td><?php echo $row['o_price'];?></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-dollar"></i> Selling Price</td>
                    <td><?php echo $row['s_price'];?></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-calendar"></i> Arrival date</td>
                    <td><?php echo getCustomDate($row['arrival_date']);?></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-calendar"></i> Expiry date</td>
                    <td><?php echo getCustomDate($row['expiry_date']);?></td>
                </tr>
                <tr>
                <td class="text-success"><i class="fa fa-male"></i> Supplier
                </td>
                <td>
                	<?php echo $viewsupname; ?>
                </td>
                </tr>
                </tbody>
                </table>
                </div>
                

                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        
                        
                  </td>
                </tr>
               <?php 
                
                }
                }
                ?>
                
                </tbody>
                </table>
                </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                
                <?php 
            }
            else{
                
                ?>
                              <div class="jumbotron">
                                  <h1>Oops!</h1> 
                                  <p>No Profiles found. Click on <label class="btn btn-success"><i class="fa fa-plus">Add Product</i></label> button to create add new product</p> </div>
                              <?php
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