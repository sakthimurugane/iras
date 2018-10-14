                  				<?php
								$Today = date('Y-m-d',mktime());
								echo $Today;
								echo '<br/>';
								$new = date('l, F d, Y', strtotime($Today));
								echo $new;
								echo '<br/>';
								
								echo date('d');
								echo '<br/>';
								
			 					echo date('m');
								echo '<br/>';
								
								echo date('Y');
								echo '<br/>';
								
								echo date('H');
								echo '<br/>';
								
								echo date('i');
								echo '<br/>';
								
								echo date('s');
								echo '<br/>';
								
								echo date('mYHdis');
								echo '<br/>';
								
								echo 'Date'.date('d-m-Y');
								echo '<br/>';
								
								echo date('Y-m-d', strtotime("+10 days"));
								
								echo "&#8377;";
								
								echo "<br>";
						
								$date=date_create("2013-03-15");
								echo date_format($date,"d-M-Y");
								
								
								?>
