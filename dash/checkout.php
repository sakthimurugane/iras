<?php
//Page settings
$_GLOBALS['CUSTSEARCH']='true';
$_GLOBALS['SUGGESTS']='true';
include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
include_once '../app_config/pdocon.php';
include_once 'utilities.php';

$errflag = false;
$errmsg="";
$created_by='SYSTEM';
$modified_by='SYSTEM';
$taxflag=false;
if(isset($_SESSION['SESS_MEMBER_ID'])){
    $created_by=$_SESSION['SESS_MEMBER_ID'];
    $modified_by=$_SESSION['SESS_MEMBER_ID'];
    $taxflag=$_SESSION['SESS_HOME_TAX'];
}
$invoiceid='';
if(!isset($_POST['invoiceid'])){
    
    $invoiceid=getInvoiceToken();
}else{
    if(trim($_POST['invoiceid'])==''){
        $invoiceid=getInvoiceToken();
    }else{
        $invoiceid=$_POST['invoiceid'];
        /****
         * Code to handle add product data into SALES_ORDER TABLE
         */
        if(isset($_POST['addProdSubmit'])){
           $productid=clean($_POST['product']);
           $userqty=clean($_POST['qty']);
           $billprice=clean($_POST['price']);
           
           if(trim($productid)!=''){
               $prodquery="select * from products where is_deleted=0 and product_id=".$productid;
               
               $result=mysqli_query($link,$prodquery);
               if($result) {
                   if(mysqli_num_rows($result) == 1) {
                       $row = $result->fetch_assoc();
                       if(trim($userqty)==''){
                           $userqty=1;
                       }
                       if(trim($billprice)==''){
                           $billprice=$row['s_price'];
                       }
                       $productname=$row['product_name'];
                       $productcode=$row['product_code'];
                       $prodhsn=$row['hsnsac'];
                       $prodoprice=(int)$row['o_price'];
                       $billvalue=((int)$userqty)*((int)$billprice);
                       $profitamt=((int)$userqty)*(((int)$billprice)-$prodoprice);
                       $inssalesorder="insert into sales_order (ordernum, product_id, item_name, item_code, item_hsn, bill_price, bill_qty, bill_amount, created_on, created_by, item_profit)".
                           "values('$invoiceid',$productid,'$productname','$productcode','$prodhsn',$billprice,$userqty,$billvalue,now(),'$created_by', $profitamt)";
                       if ($link->query($inssalesorder) === TRUE) {
                           $supplierid = $link->insert_id;
                       } else {
                           $errflag=true;
                           $errmsg="Error while inserting sales order. ".$link->error;
                       } 
                   }
               }

           }
        }
        /**
         * Delete Prod from Sales Order hanlding
         * 
         */
        if(isset($_POST['delProdSubmit']) && isset($_POST['salesid'])){
            $salesid=$_POST['salesid'];
            $delsalesqry="UPDATE SALES_ORDER SET is_deleted=1, modified_by='$modified_by', modified_on=now() where ordernum='$invoiceid' and sale_id=$salesid";
            echo $delsalesqry;
            if ($link->query($delsalesqry) === FALSE) {
                echo "error in ".$delsalesqry.$link->error;
                $errflag=true;
                $errmsg="Error while deleting customer. ".$link->error;
            }
            
        }
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
        <li class="breadcrumb-item active">Sales</li>
      </ol>

       <!-- Suppliers DataTables Card-->
      <div class="card mb-3">
      <form method="post" name="addProdForm" id="addProdForm">
        <div class="card-header">
			<select name="product" id="product" class="chosen-select" data-placeholder="Select the Product....">
            <option></option>
            	<?php
            	$result = $db->prepare("SELECT * FROM products where is_deleted=0");
            		$result->execute();
            		for($i=0; $row = $result->fetch(); $i++){
            	?>
            		<option value="<?php echo $row['product_id'];?>"><?php echo $row['product_code']; ?> - <?php echo $row['hsnsac']; ?>  | <?php echo 'Rs '.formatMoney($row['s_price'],true); ?></option>
            	<?php
            				}
            			?>
            </select>
            <input type="hidden" name="invoiceid" id="invoiceid" value="<?php echo $invoiceid;?>" />
            <input type="number" name="qty" id="qty" value="1" min="1" placeholder="Qty" autocomplete="off" required>
            <input type="number" name="price" id="price" placeholder="0.00" autocomplete="off" required>
            <button type="submit" name="addProdSubmit" id="addProdSubmit" class="btn btn-info" ><i class="fa fa-plus"></i> Add</button>
          </div>
          </form>

          <table class="table table-bordered" id="resultTable" data-responsive="table">
	<thead>
		<tr>
			<th> Product Name </th>
			<th> Generic Name </th>
			<th> Code </th>
			<th> Price </th>
			<th> Qty </th>
			<th> Amount </th>
			<th> Profit </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		<?php
		        $billflag=false;
				$result = $db->prepare("SELECT * FROM sales_order WHERE ordernum= :userid and is_deleted=0");
				$result->bindParam(':userid', $invoiceid);
				$result->execute();
				if($result->rowCount()>0){
				    $billflag=true;
				}
				$totalprofit=0;
				$totalamt=0;
				for($i=1; $row = $result->fetch(); $i++){
			?>
			<tr class="record">
			<td hidden><?php echo $row['product_id']; ?></td>
			<td><?php echo $row['item_name']; ?></td>
			<td><?php echo $row['item_code']; ?></td>
			<td><?php echo $row['item_hsn']; ?></td>
			<td>
			<?php
			$ppp=$row['bill_price'];
			echo formatMoney($ppp, true);
			?>
			</td>
			<td><?php echo $row['bill_qty']; ?></td>
			<td>
			<?php
			$dfdf=$row['bill_amount'];
			$totalamt += $dfdf;
			echo formatMoney($dfdf, true);
			?>
			</td>
			<td>
			<?php
			$profit=$row['item_profit'];
			$totalprofit += $profit;
			echo formatMoney($profit, true);
			?>
			</td>
			<td>
			<form method="post" name="delProdForm" id="delProdForm">
			<input type="hidden" name="invoiceid" id="delinvoiceid" value="<?php echo $invoiceid;?>" />
			<input type="hidden" name="salesid" id="salesid" value="<?php echo $row['sale_id'];?>" />
			<button name="delProdSubmit" class="btn btn-mini btn-warning"><i class="icon icon-remove"></i> Cancel </button>
			</form>
			</td>
			</tr>
			<?php
				}
				if($taxflag){
			?>
			
			<tr>
			<td colspan="3">
			GST
			</td>
			<td colspan="2">
			7%
			</td>
			<td colspan="3">
			<?php echo formatMoney($totalamt*7/100,true);?>
			</td>

			
			</tr>
			<?php 
			$totalamt += ($totalamt*7/100);
			
			
				}
			
			?>
			<tr>
			<th> </th>
			<th>  </th>
			<th>  </th>
			<th>  </th>
			<th>  </th>
			<td> Total Amount: </td>
			<td> Total Profit: </td>
			<th>  </th>
		</tr>
		<tr>
				<th colspan="5"><strong style="font-size: 12px; color: #222222;">Total:</strong></th>
				<td colspan="1"><strong style="font-size: 12px; color: #222222;">
			<?php 
			
			echo 'Rs. '.formatMoney($totalamt, true); 
			
			?></strong></td>
				<td colspan="1"><strong style="font-size: 12px; color: #222222;">
				<?php echo 'Rs. '.formatMoney($totalprofit, true); ?>
								</td>
				<th></th>
			</tr>
			
	</tbody>
</table>
<?php if($billflag){?>
<a data-toggle="modal" data-target="#checkout" ><button class="btn btn-success btn-large btn-block"><i class="fa fa-save"></i> Bill Checkout</button></a>

           <!-- Modal to checkout-->
                        <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                	<form id="checkoutForm" name="checkoutForm" method="post" action="../controllers/checkout.php">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="myModalLabel"><i class="fa fa-users"></i> <span class="text-right"> Checkout</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                    
                                    <div class="table-responsive panel">
                                                <table class="table">
                                                    <tbody>
    
                                                            <tr>
                                                                <td class="text-success">
                                                                <input id="example-ajax-post" style="width: 268px; height:30px;" type="text" size="25" value="" name="cnd"  autocomplete="off" placeholder="Enter Customer ID" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">
                                                                <select name="pt"  id="pt" class="custom-select form-control">
                                                                <option value="cash">Cash</option>
                                                                <option value="credit">Credit</option>
                                                                </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success">
                                                                <input type="text" class="form-control" name="paidamt" id="paidamt" size="20"  Placeholder="0.00" required/>
                                                                </td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                    </div>
                                    <div class="modal-footer">
                                    	<input type="hidden" name="invoiceid" value="<?php echo $invoiceid;?>" />                          	
                                        <button class="btn btn-success form-control" type="submit" name="checkoutSubmit"><i class="fa fa-plus"></i> Submit</button>
                                        <a class="btn btn-danger form-control" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                 </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        
<?php }?>
      </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->


<?php 
include_once 'footer.php';

?>