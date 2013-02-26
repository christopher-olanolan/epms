<?php

if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

		if ($ajax=="" || empty($ajax)):
			include dirname(__FILE__) . "/error.php";
		else:
			$connect = new MySQL();
			$connect->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);
	
			switch ($control):
				
				case 'show':
					
?>
				<table width="100%" border="0" cellpadding="5" cellspacing="0" class="list table_solid_top">
							<tr>
								<th>NUM </th>
								<th> </th>
								<th>PRODUCT NAME </th>
								<th>PRODUCT NUMBER </th>
								<th>PRODUCT PRICE </th>
								<th>PRODUCT TYPE </th>
							</tr>	

<?php					
						$query = $connect->get_array_result("SELECT product_id, product_name, product_number, product_price, product_type 
															 FROM epms_product");
						$product_list = count($query);
			          	
						 for($i=0;$i<$product_list;$i++):
			           	
						    $product_id = $query[$i][product_id];
						    $product_number = $query[$i][product_number];
						    $product_name = $query[$i][product_name];
							$product_price =$query[$i][product_price];
							$product_type =$query[$i][product_type];
							
?> 						

                          <script type="text/javascript">
                          		 $(document).ready(function() {
                          		 	
                          		 	  $('#edit_<?=$product_id?>').click(function(){
											ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=product&control=edit&pid=<?=$product_id?>","GET");
				                        });
				                        
                          		});
                          </script>
                  
			           	    <tr class="line_20">
			           	    	<td><?=$i+1;?> </td>
			                    <td width="1%" class="table_solid_left table_solid_right table_solid_bottom" align="center">
			                        <input type="checkbox" class="checkbox" name="action[checkbox][]" value="" />
			                    </td>
			                    <td class="table_solid_bottom"><span class="cursor-default" id="info_<?=product_number?>"><?=$user_name?>
			                    	<strong class="px_10 green"><?=$product_name?></strong></span>
			                    </td>
			                    <td>
			                    	<strong class="px_10 green" align="center"><?=$product_number?></strong></span>
			                    </td>
			                    <td>
			                    	<strong class="px_10 green" align="center"><?=$product_price?></strong></span>
			                    </td>
			                     <td>
			                    	<strong class="px_10 green" align="center"><?=$product_type?></strong></span>
			                    </td>
			                    <td class="table_solid_right table_solid_bottom px_10" align="right">
			                        <input type="button" class="clean editPop ico ico_edit" name="action[single-edit]" value="<?=$user_id?>" id="edit_<?=$product_id?>" /> Edit &nbsp;&nbsp;
			                        <input type="submit" class="clean deletePop ico ico_delete" name="action[single-delete]" value="<?=$user_id?>" id="delete_<?=$product_id?>" /> Delete
			                    </td>
                			</tr>
                	
<?php							
			          endfor;	
				
					break;
?>
				
				</table>
<?php				

				case 'edit':
					
					$product_edit = $connect->single_result_array("SELECT product_name, product_number, product_price, product_type, product_template, product_desc
																   FROM epms_product 
																   WHERE product_id = '$pid'");
					
					$product_number = $product_edit[product_number];
					$product_name = $product_edit[product_name];
					$product_price =$product_edit[product_price];
					$product_type =$product_edit[product_type];
					$product_template = $product_edit[product_template];
					$product_desc = $product_edit[product_desc];
?>											                

					<script type="text/javascript">
							$('#back').click(function(){
						ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=product&control=show","GET");	
					});
					
					</script>
				
					
					<form method="post" enctype="multipart/form-data" action="<?=__ROOT__?>/index.php?file=action&action=update_product" id="editUserForm">
	        			<div style="width:100%;" align="left" class="shadow gray">
			            	<div class="spacer_3 clean"><!-- SPACER --></div>
			            		<strong>Product Information:</strong>
			                <div class="spacer_5 clean"><!-- SPACER --></div>
			            	<div class="title_div"><!-- DIVIDER --></div>
			                <div class="spacer_0 clean"><!-- SPACER --></div>
			                
			                <table width="800" border="0" cellpadding="0" cellspacing="5">
			                	<tr>
			                		<td width="220">Product Name: </td>
                        			<td class="line_30"><input id="product_name" name="product_name" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$product_name?>" /></td>
			                	</tr>
			                	<tr>
			                    	<td>Product Number: </td>
			                        <td><input id="product_number" name="product_number" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$product_number?>" /></td>
			                    </tr>
			                    <tr>
			                    	<td>Product Template: </td>
			                        <td><input id="product_template" name="product_template" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$product_template?>" /></td>
			                    </tr>
			                     <tr>
			                    	<td>Product Type: </td>
			                        <td><input id="product_type" name="product_type" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$product_type?>" /></td>
			                    </tr>
			                    <tr>
			                    	<td>Product Description: </td>
			                    	 <td>
			          

<?php 							
				            	$CKEditor = new CKEditor();
				                $CKEditor->returnOutput = true;
				                $CKEditor->basePath = 'ckeditor/';
				                $CKEditor->textareaAttributes = array("cols" => 50, "rows" => 10);
				                $config['toolbar'] = array(
				                    array('Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'),
				                     array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
				                     array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				                    array('Styles','Format','Font','FontSize','-','TextColor','BGColor')
				                 );
				                //initialValue = html_entity_decode(htmlentities(strip_tags($product_desc)));
				                $intialValue = html_entity_decode($product_desc);
								
						        $article_title = $CKEditor->editor("article_title", $intialValue, $config);
				                echo $article_title;
?>	                    	 	
									</td> 
							   </tr>		
								</table>	                
			                <div class="spacer_40 clean"><!-- SPACER --></div>
                
			                <div style="width:100%;" align="left">
				                <input name="back" type="button" value="Back" class="button" id="back" />
				                <input name="update_product" type="submit" value="Update" class="button" id="update_product" />
			                </div>
                	</form>
<?php					
					
					break;
				default:
					
					break;
			
			endswitch;
			
			
		endif;	

?>