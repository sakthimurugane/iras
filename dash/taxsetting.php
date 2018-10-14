<?php
//Page settings
include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
include_once 'utilities.php';
$errorflag=false;
$error_msg='';

/**
 * Insert handle
 * 
 */
$created_by='SYSTEM';
if(isset($_SESSION['SESS_MEMBER_ID'])){
    $created_by=$_SESSION['SESS_MEMBER_ID'];
}

if(isset($_POST['addtaxdetails'])){
    $taxname=clean($_POST['taxname']);
    $taxdesc=clean($_POST['taxdesc']);
    $taxtype=clean($_POST['taxtype']);
    $taxvalue=clean($_POST['taxvalue']);
    $status=clean($_POST['taxstatus']);
    
    $inshomeqry="INSERT into TAX_SLAB (slab_name,slab_desc,tax_type,tax_value,status,created_on, created_by) values".
                "('$taxname','$taxdesc','$taxtype',$taxvalue,'$status',now(),'$created_by')";
    //echo $inshomeqry;
    
    if($link->query($inshomeqry)===FALSE){
        $errorflag=true;
        $error_msg='Error while adding tax'.$link->error;
    }else{
        $error_msg='Added successfully';
        
    }
}elseif(isset($_POST['updatetaxdetails'])){
    
    $taxid=clean($_POST['etaxid']);
    $taxname=clean($_POST['etaxname']);
    $taxdesc=clean($_POST['etaxdesc']);
    $taxtype=clean($_POST['etaxtype']);
    $taxvalue=clean($_POST['etaxvalue']);
    $status=clean($_POST['etaxstatus']);
    
    
    $inshomeqry="update TAX_SLAB set slab_name='$taxname', slab_desc='$taxdesc', tax_type='$taxtype', tax_value='$taxvalue', status='$status', modified_on=now(), modified_by='$created_by' where slab_id=$taxid and is_deleted=0";
    //echo $inshomeqry;
    if($link->query($inshomeqry)===FALSE){
        $errorflag=true;
        $error_msg='Error while updating Tax details '.$link->error;
    }else{
        $error_msg='Updated successfully';
        
    }
    
}elseif(isset($_POST['deltaxdetails'])){
    $taxid=clean($_POST['dtaxid']);
    
    $inshomeqry="update TAX_SLAB set is_deleted=1, modified_on=now(), modified_by='$created_by' where slab_id=$taxid";
    //echo $inshomeqry;
    
    if($link->query($inshomeqry)===FALSE){
        $errorflag=true;
        $error_msg='Error while deleting Tax details '.$link->error;
    }else{
        $error_msg='Deleted successfully';
        
    }
}

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
          Tax Settings
        </li>
      </ol>
       <?php
       if($errorflag) {
           echo '<div class="alert alert-danger alert-dismissible">',$error_msg,'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
       }else{
           if(!trim($error_msg)==''){
               echo '<div class="alert alert-success alert-dismissible">',$error_msg,'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
               
           }
       }
          ?>
       <!-- products DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-cog"></i> Tax slab
          
           <a data-toggle="modal" data-target="#addoption" class=" text-center btn btn-success btn-sm btn-default">
           <i class="fa fa-plus"></i>Add Tax
			</a>
			
          </div>

			 <!-- Modal to add suppliers-->
                        <div class="modal fade" id="addoption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                	<form id="addcustForm" name="addcustForm" method="post">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="myModalLabel"><i class="fa fa-cogs"></i> <span class="text-right"> New Tax slab</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                    
                                    <div class="table-responsive panel">
                                                <table class="table">
                                                    <tbody>
    
                                                            <tr>
                                                                <td class="text-success"><input type="text"  class="form-control" name="taxname" id="taxname" size="20"  Placeholder="Name" data-validation="required alphanumeric" data-validation-allowing=".-_"  /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><input type="text" class="form-control" name="taxdesc" id="taxdesc" size="20"  Placeholder="Description" data-validation="required alphanumeric" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">
                                                                <select class="custom-select" name="taxtype" id="taxtype">
                                                                <option value="Percentage">Percentage (%)</option>
                                                                <option value="Fixed">Fixed amount</option>
                                                                </select>
																</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><input type="text" class="form-control" name="taxvalue" id="taxvalue" size="20"  Placeholder="0.00"  /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">
                                                                
                                                                <select class="custom-select" name="taxstatus" id="taxstatus">
                                                                <option value="ACTIVE">Enabled</option>
                                                                <option value="INACTIVE">Disabled</option>
                                                                </select>

                                                                </td>
                                                                
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="addtaxdetails"><i class="fa fa-plus"></i> Add</button>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                 </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
          <?php 
          $servicelistqry="SELECT * from tax_slab where is_deleted=0 order by created_on desc";
          
          $result=mysqli_query($link,$servicelistqry);
          
          if($result) {
           ?>


        <div class="card-body">
          <div class="table-responsive panel">
          
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Type</th>
                  <th>Value</th>
                  <th>Status</th>
                  <th>Option</th>
                </tr>
              </thead>

              <tbody>
                
                <?php 
                if(mysqli_num_rows($result) > 0) { 
            while($row = $result->fetch_assoc()){
                
                
           ?>
                <tr>
                  <td><?php echo $row['slab_name'];?></td>
                  <td><?php echo $row['slab_desc'];?></td>
                  <td><?php echo $row['tax_type'];?></td>
                  <td><?php echo $row['tax_value'];?></td>
                  <td><?php echo $row['status'];?></td>
                   <td class="text-center">
                   <div class=" text-center">
                            <a data-toggle="modal" data-target="#editoption<?php echo $row['slab_id'];?>"> <button class="btn btn-warning btn-sm btn-default btn-mini" title="Edit"><i class="fa fa-edit fa-1x"></i></button></a>
                            <a data-toggle="modal" data-target="#deleteoption<?php echo $row['slab_id'];?>"> <button class="btn btn-danger btn-sm btn-default btn-mini" title="Delete"><i class="fa fa-trash fa-1x"></i></button></a>
                    </div>
                        <!-- Modal to delete supplier-->
                        <div class="modal fade" id="deleteoption<?php echo $row['slab_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row['slab_id'];?>" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="myModalLabel<?php echo $row['slab_id'];?>"><i class="fa fa-trash"></i> <span class="text-right"> Delete Tax</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                    	Are you sure want to delete this Tax ? <br/>
                                    	Name: <?php echo $row['slab_name']; ?> <br/>
                                    	Desc: <?php echo $row['slab_desc']; ?>
                                    </div>
                                    <div class="modal-footer">
                                    <form method="post">
                                        <button name="deltaxdetails" type="submit" class="btn btn-success"><i class="fa fa-trash"></i> Delete</button>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                    <input type="hidden" name="dtaxid" value="<?php echo $row['slab_id']; ?>"/>
                                     </form>   
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal --> 
                        
                     <!-- Modal to edit customer-->
                        <div class="modal fade" id="editoption<?php echo $row['slab_id'];?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['slab_id'];?>" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                	<form id="editcustForm" name="editcustForm" method="post">
                                
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="editModalLabel<?php echo $row['slab_id'];?>"><i class="fa fa-edit"></i> <span class="text-right"> Edit Customer</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
									
									       <div class="table-responsive panel">
                                                <table class="table">
                                                   <tbody>
                                                            <tr>
                                                                <td class="text-success">Name</td>
                                                                <td><input type="text" name="etaxname" id="etaxname" class="form-control" value="<?php echo $row['slab_name'];?>" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">Desc</td>
                                                                <td><input type="text" name="etaxdesc" id="etaxdesc" class="form-control" value="<?php echo $row['slab_desc'];?>" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">Type</td>
                                                                <td>
                                                                <select class="custom-select" name="etaxtype" id="etaxtype">
                                                                    <option value="Percentage" <?php if($row['tax_type']=='Percentage'){echo "selected";}?>>Percentage (%)</option>
                                                                    <option value="Fixed" <?php if($row['tax_type']=='Fixed'){echo "selected";}?> >Fixed amount</option>
                                                                    </select> 
                                                                
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">Value</td>
                                                                <td><input type="text" name="etaxvalue" id="etaxvalue" class="form-control" value="<?php echo $row['tax_value'];?>" /></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td class="text-success">Status</td>
                                                                <td>
    																<select class="custom-select" name="etaxstatus" id="etaxstatus">
                                                                    <option value="ACTIVE" <?php if($row['status']=='ACTIVE'){echo "selected";}?>>Enabled</option>
                                                                    <option value="INACTIVE" <?php if($row['status']=='INACTIVE'){echo "selected";}?> >Disabled</option>
                                                                    </select>                                                      
																</td>
                                                            </tr>
                                                            
                                                            
                                                    </tbody>
                                                </table>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="updatetaxdetails" id="updatetaxdetails"><i class="fa fa-save"></i> Save</button>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                       	<input type="hidden" name="etaxid" value="<?php echo $row['slab_id']; ?>"/>
                                        
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
                
                <?php 
            }
            else{
                
                ?>
                              <div class="jumbotron">
                                  <h1>Oops!</h1> 
                                  <p>No Tax details found. Click on <label class="btn btn-success"><i class="fa fa-plus">Add Tax slab</i></label> button to create add new tax</p> 
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