<?php
//Page settings
include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
include_once 'utilities.php';
$errorflag=false;
$error_msg='';

if(isset($_POST['saveHome'])){
    $homeid=clean($_POST['homeid']);
    $hname=clean($_POST['hname']);
    $hlname=clean($_POST['hlname']);
    $gstin=clean($_POST['gstin']);
    $prpty=clean($_POST['prpty']);
    $mobile=clean($_POST['mobile']);
    $landline=clean($_POST['landline']);
    $taxflag=clean($_POST['taxflag']);
    $webaddress=clean($_POST['address']);
    $hstate=clean($_POST['state']);
    $hpin=clean($_POST['pincode']);
    $hemail=clean($_POST['shopemail']);
    $haddr1=clean($_POST['location1']);
    $haddr2=clean($_POST['location2']);
    
    
    $inshomeqry="update home set home_name='$hname', home_legal_name='$hlname', home_gstin='$gstin', home_propertier='$prpty', home_mobile='$mobile', home_landline='$landline', is_tax=$taxflag, home_address='$webaddress',home_state='$hstate', home_email='$hemail', home_pincode='$hpin', address_1='$haddr1', address_2='$haddr2', modified_on=now(), modified_by='SYSTEM' where home_id=$homeid";
    if($link->query($inshomeqry)===FALSE){
        $errorflag=true;
        $error_msg='Error while updating Home details '.$link->error;
    }else{
        $error_msg='Updated successfully';
        
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
          Shop Settings
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
          <i class="fa fa-cog"></i> Shop Settings
          </div>

          <?php  
          $servicelistqry="SELECT * from home where is_deleted=0";
          
          $result=mysqli_query($link,$servicelistqry);
          
          if($result) {
           ?>

        <div class="card-body">
          <div class="table-responsive panel">
          <form id="modprodForm" name="modprodForm" method="post">
              <table class="table">
              <tbody>
                
                <?php 
                if(mysqli_num_rows($result) > 0) { 
            while($row = $result->fetch_assoc()){
                
                ?>
    			<tr>
                	<td class="text-success"><i class="fa fa-info"></i> Home ID</td>
                	<td><input type="text" class="form-control" name="dhomeid" id="dhomeid"  value="<?php echo $row['home_id'];?>" disabled/></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Home Name</td>
                    <td><input type="text" class="form-control" name="hname" id="hname" size="20" Placeholder="Home name" value="<?php echo $row['home_name'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i>Legal Name</td>
                    <td><input type="text" class="form-control" name="hlname" id="hlname" size="20" Placeholder="Legal name" value="<?php echo $row['home_legal_name'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-flag"></i> GSTIN</td>
                    <td><input type="text" class="form-control" name="gstin" id="gstin" size="20" Placeholder="GSTIN" value="<?php echo $row['home_gstin'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-male"></i> Propertier</td>
                    <td><input type="text" class="form-control" name="prpty" id="prpty" size="20" Placeholder="Properties" value="<?php echo $row['home_propertier'];?>" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-phone"></i> Mobile</td>
                    <td><input type="text" class="form-control" name="mobile" id="mobile" size="20" Placeholder="Mobile"  value="<?php echo $row['home_mobile'];?>"/></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-phone"></i> Landline</td>
                    <td><input type="text" class="form-control" name="landline" id="landline" size="20" Placeholder="Landline"  value="<?php echo $row['home_landline'];?>"/></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Address line 1</td>
                    <td><input type="text" class="form-control" name="location1" id="location1" size="20" Placeholder="Address line 1"  value="<?php echo $row['address_1'];?>"/></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Address line 2</td>
                    <td><input type="text" class="form-control" name="location2" id="location2" size="20" Placeholder="Address line 2"  value="<?php echo $row['address_2'];?>"/></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> State</td>
                    <td><input type="text" class="form-control" name="state" id="state" size="20" Placeholder="State"  value="<?php echo $row['home_state'];?>"/></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Pincode</td>
                    <td><input type="text" class="form-control" name="pincode" id="pincode" size="20" Placeholder="Pincode"  value="<?php echo $row['home_pincode'];?>"/></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-globe"></i> Website</td>
                    <td><input type="text" class="form-control" name="address" id="address" size="20" Placeholder="Website address"  value="<?php echo $row['home_address'];?>"/></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Address</td>
                    <td><input type="text" class="form-control" name="shopemail" id="shopemail" size="20" Placeholder="Email id"  value="<?php echo $row['home_email'];?>"/></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Enable Tax</td>
                    <td>
                    <select name="taxflag" class="custom-select">
                            <option value="1"   <?php if($row['is_tax']==1){echo "selected";}?> >Enabled</option>
                            <option value="0"   <?php if($row['is_tax']==0){echo "selected";}?> >Disabled</option>
                	</select>
               
                </td>
                </tr>
                <tr>
                
                <td></td>
                
                <td>
                
        			<input type="hidden" name="homeid" id="homeid" value="<?php echo $row['home_id']; ?>"/>
                    <button type="submit" name="saveHome" id="saveHome" class="btn btn-success btn-sm btn-default"><i class="fa fa-floppy-o fa-1x"></i> Save</button>
                    <button type="reset" class="btn btn-danger btn-sm btn-default"><i class="fa fa-window-close-o	 fa-1x"></i> Cancel</button>
               	 <a href="index.php" class="btn btn-warning btn-sm btn-default"><i class="fa fa-arrow-circle-o-left fa-1x"></i> Back</a>
                </td>
                
                </tr>
                
                <?php

                }
                
                }else{
                    ?>
                    
                    
                    <tr><td><div class="card-footer small text-muted">No details found. Please go back to products page or contact System Administrator.</div></td></tr>
                    
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