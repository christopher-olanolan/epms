<?php 

if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

		 if(empty($_GET['panel']) || empty($_GET['section'])): 
			include dirname(__FILE__) . "/error.php";
		else:
			switch($section):
					case 'import-product':
						 
?>						 

          <form id="uploadForm" action="<?=__ROOT__?>/index.php?file=action&action=upload" method="post" enctype="multipart/form-data">
			<div style="width:100%;" align="left" class="shadow gray">
            	<div class="spacer_3 clean"><!-- SPACER --></div>
            	<strong>Product Upload</strong>
          		 <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>
						 
						 <table width="500"  border="0" cellpadding="0" cellspacing="5">
						
							<tr>
								<td>Select file</td>
								<td width="20%"><input type="file" name="file" id="file"/></td>
							</tr>
							
							<tr>
								<td></td>
								<td><input type="submit" name="submit" class="button small_button" /></td>
							</tr>
							
						</table>
				   <div class="spacer_40 clean"><!-- SPACER --></div>
				   <div style="width:100%;" align="left">
				</div>	
				
		 </form>		
		 <script>
		  $(document).ready(function() { 
		  		$("#uploadForm").validate({
		  			rules: {
						file : {
							required: true
						},	
				
					},
					messages: {
						file : {
							required: "Please include file for upload",
						},	
					
				},
				onkeyup: false,
		  		onblur: true
		 	});
		  });
		 </script>
					<?php 

						break;	
						
			case 'manage-product':``
				
					?>
						<script type="text/javascript">
							$(document).ready(function() {
								ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=product&control=show","GET");	
							});
						</script>
						
						<div id="loadajax" align="center">
							<div class="spacer_100 clean"><!-- SPACER --></div>
							<img src="<?=__IMAGE__?>load.gif" class="clean" />
							<div class="spacer_5 clean"><!-- SPACER --></div>
							<span class="shadow pt_8">Please wait...</span>
						</div>
						
						<div id="ajax" class="hidden"></div>
			<?php
				
				break;		
						
					default:
						include dirname(__FILE__) . "/error.php";
						break;
			
			endswitch;
		endif;



?>