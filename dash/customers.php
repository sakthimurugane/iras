<?php
//Page settings
$_GLOBALS['ISTABLEPAGE']='true';

include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';

//Function to sanitize values received from the form. Prevents SQL injection
require_once 'utilities.php';

$servicelistqry="SELECT * from customer where is_deleted=0 order by created_on desc";

$result=mysqli_query($link,$servicelistqry);

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Customers</li>
      </ol>
       <?php
            if( isset($_SESSION['ERRMSG_ADDCUSTOMER'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['ERRMSG_ADDCUSTOMER'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['ERRMSG_ADDCUSTOMER']);
          }elseif(isset($_SESSION['SCSMSG_ADDCUSTOMER'])){
              echo '<div class="alert alert-success alert-dismissible">',$_SESSION['SCSMSG_ADDCUSTOMER'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SCSMSG_ADDCUSTOMER']);
          }
          
          
          if( isset($_SESSION['ERRMSG_MODCUSTOMER'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['ERRMSG_MODCUSTOMER'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['ERRMSG_MODCUSTOMER']);
          }elseif(isset($_SESSION['SCSMSG_MODCUSTOMER'])){
              echo '<div class="alert alert-success alert-dismissible">',$_SESSION['SCSMSG_MODCUSTOMER'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SCSMSG_MODCUSTOMER']);
          }
          
          
          if( isset($_SESSION['ERRMSG_DELCUSTOMER'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['ERRMSG_DELCUSTOMER'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['ERRMSG_DELCUSTOMER']);
          }elseif(isset($_SESSION['SCSMSG_DELCUSTOMER'])){
              echo '<div class="alert alert-success alert-dismissible">',$_SESSION['SCSMSG_DELCUSTOMER'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SCSMSG_DELCUSTOMER']);
          }
          
          
          ?>
       <!-- customer DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-users"></i> Manage Customers
          <a data-toggle="modal" data-target="#addoption" class=" text-center btn btn-success btn-sm btn-default">
           <i class="fa fa-plus"></i>Add Customer
			</a>
          </div>
          
           <!-- Modal to add suppliers-->
                        <div class="modal fade" id="addoption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                	<form id="addcustForm" name="addcustForm" method="post" action="../controllers/addcustomer.php">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="myModalLabel"><i class="fa fa-users"></i> <span class="text-right"> New Customer</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                    
                                    <div class="table-responsive panel">
                                                <table class="table">
                                                    <tbody>
    
                                                            <tr>
                                                                <td class="text-success"><input type="text"  name="spname" id="spname" size="20"  Placeholder="Customer Name" data-validation="required alphanumeric" data-validation-allowing=".-_"  /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><input type="text" class="form-control" name="spmobile" id="spmobile" size="20"  Placeholder="Mobile" data-validation="required alphanumeric" data-validation-allowing="+"  /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><input type="text" class="form-control" name="spemail" id="spemail" size="20"  Placeholder="example@smartpos.in" data-validation="required email"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><input type="text" class="form-control" name="spaddress" id="spaddress" size="20"  Placeholder="Address"  /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><textarea class="form-control" name="note" Placeholder="Notes" /></textarea></td>
                                                                
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="addcustsubmit"><i class="fa fa-plus"></i> Add</button>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                 </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                       
          <?php    
          if($result) {
           ?>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Notes</th>
                  <th>Option</th>
                </tr>
              </thead>

              <tbody>
                
                <?php 
                if(mysqli_num_rows($result) > 0) { 
            while($row = $result->fetch_assoc()){
                
                
           ?>
                <tr>
                  <td><?php echo $row['customer_id'];?></td>
                  <td><?php echo $row['customer_name'];?></td>
                  <td><?php echo $row['customer_phone'];?></td>
                  <td><?php echo $row['customer_mail'];?></td>
                  <td><?php echo $row['customer_address'];?></td>
                  <td><?php echo $row['remarks'];?></td>
                   <td class="text-center">
                   <div class=" text-center">
                            <a data-toggle="modal" data-target="#editoption<?php echo $row['customer_id'];?>"> <button class="btn btn-warning btn-sm btn-default btn-mini" title="Edit"><i class="fa fa-edit fa-1x"></i></button></a>
                            <a data-toggle="modal" data-target="#deleteoption<?php echo $row['customer_id'];?>"> <button class="btn btn-danger btn-sm btn-default btn-mini" title="Delete"><i class="fa fa-trash fa-1x"></i></button></a>
                    </div>
                        <!-- Modal to delete supplier-->
                        <div class="modal fade" id="deleteoption<?php echo $row['customer_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row['customer_id'];?>" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="myModalLabel<?php echo $row['customer_id'];?>"><i class="fa fa-trash"></i> <span class="text-right"> Delete Customer</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                    	Are you sure want to delete this customer ? <br/>
                                    	Customer ID: <?php echo $row['customer_id']; ?> &nbsp;
                                    	Customer Name: <?php echo $row['customer_name']; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="../controllers/deletecustomer.php?pfid=<?php echo $row['customer_id']; ?>" class="btn btn-success"><i class="fa fa-trash"></i> Delete</a>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal --> 
                        
                     <!-- Modal to edit customer-->
                        <div class="modal fade" id="editoption<?php echo $row['customer_id'];?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['customer_id'];?>" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                	<form id="editcustForm" name="editcustForm" method="post" action="../controllers/editcustomer.php">
                                
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="editModalLabel<?php echo $row['customer_id'];?>"><i class="fa fa-edit"></i> <span class="text-right"> Edit Customer</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
									
									       <div class="table-responsive panel">
                                                <table class="table">
                                                   <tbody>
    
                                                           <tr>
                                                            <td class="text-success">ID</td>
                                                                <td><label name="esid" id="esid"><?php echo $row['customer_id'];?> </label> </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">Name</td>
                                                                <td><input type="text" name="esname" id="esname" class="form-control" value="<?php echo $row['customer_name'];?>" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">Mobile</td>
                                                                <td><input type="text" name="esmobile" id="esmobile" class="form-control" value="<?php echo $row['customer_phone'];?>" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">Email</td>
                                                                <td><input type="text" name="esmail" id="esmail" class="form-control" value="<?php echo $row['customer_mail'];?>" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">Address</td>
                                                                <td><input type="text" name="esaddr" id="esaddr" class="form-control" value="<?php echo $row['customer_address'];?>" /></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td class="text-success">Notes</td>
                                                                <td>
																<textarea name="esitems" id="esitems" class="form-control"><?php echo $row['remarks'];?></textarea>                                                               </td>
                                                            </tr>
                                                            
                                                            
                                                    </tbody>
                                                </table>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="modcustomer" id="modcustomer"><i class="fa fa-save"></i> Save</button>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                       	<input type="hidden" name="spid" value="<?php echo $row['customer_id']; ?>"/>
                                        
                                    </div>
                                  </form>
                                    
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
                                  <p>No Profiles found. Click on <label class="btn btn-success"><i class="fa fa-plus">Add Customers</i></label> button to create add new profile</p> 
                                </div>
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