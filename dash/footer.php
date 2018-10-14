    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright &copy; <?php echo date("Y"); ?></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="../controllers/logoutcontroller.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
    <?php 
    if(isset($_GLOBALS['ISTABLEPAGE']) && trim($_GLOBALS['ISTABLEPAGE']=='true')){
    ?>
        <!-- Page level plugin JavaScript-->
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for this page-->
    <script src="../js/sb-admin-datatables.min.js"></script>
    
    <?php 
    unset($_GLOBALS['ISTABLEPAGE']);
    
    }
    
    if(isset($_GLOBALS['CALENDARPAGE']) && trim($_GLOBALS['CALENDARPAGE']=='true')){
        ?>
    <script src="../js/tcal.js"></script>
    
    <?php 
    unset($_GLOBALS['CALENDARPAGE']);
    
    }
    
    if(isset($_GLOBALS['FORMSTOVALIDATE'])){
    ?>
    <script src="../js/form-validator.min.js"></script>
	<script type="text/javascript">
 		$.validate({
	 		form: '<?php echo $_GLOBALS['FORMSTOVALIDATE'];?>',
 		});
	</script>
	<?php
	unset($_GLOBALS['FORMSTOVALIDATE']);
	
        }
        
        if(isset($_GLOBALS['PRINTPAGE'])){
            ?>
        
        <script type="text/javascript">
    			$('#printbutton').click(function(){
    				  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    			      disp_setting+="scrollbars=yes,width=800, height=400, left=100, top=25"; 
    			  var content_vlue = document.getElementById("printcontent").innerHTML; 
    			  
    			  var docprint=window.open("","",disp_setting); 
    			   docprint.document.open(); 
    			   docprint.document.write('</head><body onLoad="self.print()" style="width: 800px; font-size: 13px; font-family: arial;">');          
    			   docprint.document.write(content_vlue); 
    			   docprint.document.close(); 
    			   docprint.focus(); 
                    });
		</script>

        <?php 
        unset($_GLOBALS['PRINTPAGE']);
        
    }
    
    if(isset($_GLOBALS['CUSTSEARCH'])){
        ?>
        
        <script src="../vendor/chosen/chosen.jquery.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $(".chosen-select").chosen();
            });
        </script>
        
        <script type="text/javascript">
    			$('#product').change(function(){
    				var selectedCountry = $("#product option:selected"). val();
    				//var info = 'prodid=' + selectedCountry;
    				
    				$.post("getproductinfo.php",
    					    {
    					        prodid: selectedCountry,
    					        contentType: 'application/json',
    					        dataType: 'json', // <--- UPDATE ME
        					 },
    					    function(data, status){
    					        //alert("Data: " + data.price + "\nStatus: " + status);
    					        $("#price").attr({
        					        "value": data.price
        					        });
    					    });
                    });
		</script>

        <?php 
        unset($_GLOBALS['CUSTSEARCH']);
        
    }
    
    if(isset($_GLOBALS['SUGGESTS'])){
    ?>
        <script src="../vendor/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
    
    <script>
    var options = {

    		  url: function(phrase) {
    		    return "autosuggestname.php";
    		  },

    		  getValue: function(element) {
    		    return element.name;
    		  },

    		  ajaxSettings: {
    		    dataType: "json",
    		    method: "GET",
    		    data: {
    		      format: "json"
    		    }
    		  },

    		  preparePostData: function(data) {
    		    data.phrase = $("#example-ajax-post").val();
    		    return data;
    		  },

    		  requestDelay: 400
    		};

    		$("#example-ajax-post").easyAutocomplete(options);
</script>

<?php 
unset($_GLOBALS['SUGGESTS']);

    }?>
    <script>

    $("#updatecred").click(function(){
        var result=true;
        if($("#ecredDesc").val()==""){
            alert("Please enter Credential description");
            result=false;
        }else if($("#ecredLogin").val()==""){
            alert("Please enter Login details");
            result=false;
        }else if($("#ecredPass").val()==""){
            alert("Please enter Password details");
            result=false;
        }else if($("#ecredMFA").val()==""){
            alert("Please enter MFA details");
            result=false;
        }

        return result;
        
    });
    
    </script>
</body>

</html>