<?php
//Page settings
$_GLOBALS['CALENDARPAGE']='true';
include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
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
        
        <li class="breadcrumb-item active">Add Products</li>
      </ol>
       <?php
            if( isset($_SESSION['ERRMSG_ADDPRODUCT'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['ERRMSG_ADDPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['ERRMSG_ADDPRODUCT']);
          }elseif(isset($_SESSION['SCSMSG_ADDPRODUCT'])){
              echo '<div class="alert alert-success alert-dismissible">',$_SESSION['SCSMSG_ADDPRODUCT'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SCSMSG_ADDPRODUCT']);
          }

          ?>
       <!-- products DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-list-alt"></i> Products Inventory
          </div>

        <div class="card-body">
          <div class="table-responsive panel">
          <form id="addprodForm" name="addprodForm" action="../controllers/addproduct.php" method="post">
          
            <table class="table">

              <tbody>

               <tr>
                	<td class="text-success"><i class="fa fa-info"></i> Product code</td>
                	<td><input type="text" class="form-control" name="apcode" id="apcode" size="20" Placeholder="Product code" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-info"></i> Product name</td>
                    <td><input type="text" class="form-control" name="apname" id="apname" size="20" Placeholder="Product name"  /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-flag"></i> HSN/SAC</td>
                    <td><input type="text" class="form-control" name="aphsn" id="aphsn" size="20" Placeholder="01234" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-indent"></i> Quantity</td>
                    <td><input type="text" class="form-control" name="apqty" id="aepqty" size="20" Placeholder="1 or 100"  /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-dollar"></i> Original Price</td>
                    <td><input type="text" class="form-control" name="apoprice" id="apoprice" size="20" Placeholder="5.00" /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-dollar"></i> Selling Price</td>
                    <td><input type="text" class="form-control" name="apsprice" id="apsprice" size="20" Placeholder="7.00" /></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-calendar"></i> Arrival date</td>
                    <td><input type="text" class="form-control tcal" name="apardate" id="apardate" size="20"   /></td>
                </tr>
                
                <tr>
                    <td class="text-success"><i class="fa fa-calendar"></i> Expiry date</td>
                    <td><input type="text" class="form-control tcal" name="apexdate" id="apexdate" size="20"  /></td>
                </tr>
                <tr>
                    <td class="text-success"><i class="fa fa-male"></i> Supplier</td>
                    <td>
                    <select name="apsupid" class="custom-select">
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
                            <option value="<?php echo $subrow['supplier_id'];?>"><?php echo $subrow['supplier_name'];?></option>
                            
                            <?php 
                                }}}
                            ?>
                	</select>
               
                </td></tr>
                 <tr>
                
                <td></td>
                
                <td>
                
                    <button type="submit" name="addprodsubmit" id="addprodsubmit" class="btn btn-success btn-sm btn-default"><i class="fa fa-floppy-o fa-1x"></i> Save</button>
                    <button type="reset" class="btn btn-danger btn-sm btn-default"><i class="fa fa-window-close-o fa-1x"></i> Cancel</button>
                    <a href="<?php 
                    if(isset($_SERVER['HTTP_REFERER'])){
                        echo $_SERVER['HTTP_REFERER'];
                    }else{
                        echo 'products.php';
                    }
                    
                    
                    ?>" class="btn btn-warning btn-sm btn-default"><i class="fa fa-arrow-circle-o-left fa-1x"></i> Back</a>
                    
                
                </td>
                
                </tr>
                
                </tbody>
                </table>
                </form>
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