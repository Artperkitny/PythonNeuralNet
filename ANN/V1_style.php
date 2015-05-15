<!DOCTYPE html>
<!-- Created By Artur Jerzy Perkitny, 2013 -->

<html>
	<head>
		<title>Version 1.0</title>
		<link rel="stylesheet" type="text/css" href="style2.css">
		<link rel="stylesheet" type="text/css" href="ajax/ajaxfileupload.css">
		<link rel="stylesheet" type="text/css" href="jqueryFileTree/jqueryFileTree.css">
		<script type='text/javascript'  src="jq.txt"></script>
		<script type='text/javascript'  src="js.js"></script>
		<script type='text/javascript'  src="csv.js"></script>
		<script type='text/javascript'  src="js_draft.js"></script>
		<script type='text/javascript'  src="Table.js"></script>
		<script type='text/javascript'  src="vars.js"></script>
		<script type='text/javascript'  src="jqueryFileTree.js"></script>
		
		<script type='text/javascript'  src="ajax/ajaxfileupload.js"></script>
		
		<script type="text/javascript">
		// Upload Plug-in Function 
		function ajaxFileUpload()
			{
				$("#loading")
				.ajaxStart(function(){
					$(this).show();
				})
				.ajaxComplete(function(){
					$(this).hide();
				});

				$.ajaxFileUpload
				(
					{
						url:'doajaxfileupload.php',
						secureuri:false,
						fileElementId:'fileToUpload',
						dataType: 'json',
						data:{name:'logan', id:'id'},
						success: function (data, status)
						{
							if(typeof(data.error) != 'undefined')
							{
								if(data.error != '')
								{
									alert(data.error);
								}else
								{
									alert(data.msg);
								}
							}
						},
						error: function (data, status, e)
						{
							alert(e);
						}
					}
				)
				
				return false;

			}
			var log_in = "<div id='log_in'><input type='text'/> </div>";
			//log in function 
				//$(document).mousemove(function(event){
					//$("body").css("opacity","0.4");
					//$("body").prepend(log_in);
				//});
			// Buttons
				//Search
				$(document).ready(function(){
					//Click on Icon
					$("#first").on().click(function(){
						$("#Commands").html(search_html);
					});
				});
				//Settings 
				$(document).on("click","#third", function(){
					if(Scanning_session == false){
						$("#Commands").html(bar_edit);
						// Load Bars from SQL database	
						if (window.XMLHttpRequest){
							xmlhttp=new XMLHttpRequest();
						}
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState>0 && xmlhttp.readyState<4){
									$("#bar_select").append("<option class='bar'>Loading...</option>");
								}
							}
						xmlhttp.open("GET","Bar.php",true);
						xmlhttp.send();
						xmlhttp.onreadystatechange=function(){
						if (xmlhttp.readyState==4 && xmlhttp.status==200){
								$("#bar_select").empty();
								$("#bar_select").append(xmlhttp.responseText);
								//Conif Options
									if (window.XMLHttpRequest){
											xmlhttp=new XMLHttpRequest();
										}
										xmlhttp.open("GET","Bar_config.php?submit="+$(".bar select").val(),true);
										xmlhttp.send();
										xmlhttp.onreadystatechange=function(){
										if (xmlhttp.readyState==4 && xmlhttp.status==200){
												$("#white_box").append(xmlhttp.responseText);
											}
										}
								}
							}
						}
					});
					// Update Invetory 
					$(document).on("click","#Current_Inventory", function(){
						$("#Table_Top").empty();
						if (window.XMLHttpRequest){
							xmlhttp=new XMLHttpRequest();
						}
					
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState>0 && xmlhttp.readyState<4){
								$("#Tables").append("<img id='loading' src='images/loading.gif'/>");
							}
						}
						xmlhttp.open("GET","current_inventory.php?bar_info="+$(".bar select").val(),true);
						xmlhttp.send();
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState==4 && xmlhttp.status==200){
								$("#Tables").empty();
								$("#Table_Top").append(print_choice);
								$("#Tables").append("<table border='1px' id='current_inv_table'><th>Type</th><th>Name</th><th>Current Inv</th><th>Previous Inv</th><th>Ordered</th></table>");
								$("#current_inv_table").append(xmlhttp.responseText);
								if (window.XMLHttpRequest){
									xmlhttp=new XMLHttpRequest();
								}
								xmlhttp.open("GET","Previous_invt.php?bar_info="+$(".bar select").val(),true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function(){
								if (xmlhttp.readyState==4 && xmlhttp.status==200){
										var str = xmlhttp.responseText;
										var str_split = str.split(" ");
		
										for(var x=0;x<(Object.keys(str_split).length-1);x++){
											var y= x+1;
											var Table = '#current_inv_table tr:eq('+y+') td:eq(3)';
											$(Table).append(str_split[x]);
										}
										
										if (window.XMLHttpRequest){
												xmlhttp=new XMLHttpRequest();
											}
											xmlhttp.open("GET","Sales.php?bar_info="+$(".bar select").val(),true);
											xmlhttp.send();
											xmlhttp.onreadystatechange=function(){
												if (xmlhttp.readyState==4 && xmlhttp.status==200){
													
												}
											} 
										/* if (window.XMLHttpRequest){
											xmlhttp=new XMLHttpRequest();
										}
										xmlhttp.open("GET","Old.php?bar_info="+$(".bar select").val(),true);
										xmlhttp.send();
										xmlhttp.onreadystatechange=function(){
											if (xmlhttp.readyState==4 && xmlhttp.status==200){
												
											}
										} */
									}
								}
							}
						}
					
					// Click Generate Onhand Report 
					
					$(document).on("click","#onhand", function(){
						   $("#onhand").prop("disabled",true);
						// Onhand Beer 
						if($("#select_type_drink").val()=='Beer'){
							var d = new Date();
							var month = d.getMonth()+1;
							var day = d.getDate();
							var year = d.getFullYear();
							
							var full_date = month+"_"+day+"_"+year+"_";
							var full_date2 = month+"/"+day+"/"+year;
						
							var bar = $(".bar select").val();
							var file_name = "Onhand/onhand_beer_"+full_date + bar+".html";
							
							var array = new Array()
							
							for(var x=0;x<$(".onhand_beer").size();x++)
											{		
											array[x] = $(".onhand_beer").eq(x).html();
											};
									var x = 0;
							array.unshift(file_name);
							array.unshift(bar);
							array.unshift(full_date2);
							
							var jsonString = JSON.stringify(array);
							
									   $.ajax({
											type: "POST",
											url: "onhand_report_beer.php",
											data: {data : jsonString}, 
											cache: false,
											success: function(){
												window.open(file_name);
												$("#onhand").removeAttr("disabled");
											}
										})
						}
						
						// Onhand Wine 
						if($("#select_type_drink").val()=='Wine'){
							var d = new Date();
							var month = d.getMonth()+1;
							var day = d.getDate();
							var year = d.getFullYear();
							
							var full_date = month+"_"+day+"_"+year+"_";
							var full_date2 = month+"/"+day+"/"+year;
						
							var bar = $(".bar select").val();
							var file_name = "Onhand/onhand_wine_"+full_date + bar+".html";
							
							var array = new Array()
							
							for(var x=0;x<$(".onhand_wine").size();x++)
											{		
											array[x] = $(".onhand_wine").eq(x).html();
											};
									var x = 0;
							array.unshift(file_name);
							array.unshift(bar);
							array.unshift(full_date2);
						
							var jsonString = JSON.stringify(array);
							
									   $.ajax({
											type: "POST",
											url: "onhand_report_wine.php",
											data: {data : jsonString}, 
											cache: false,
											success: function(){
												window.open(file_name);
												$("#onhand").removeAttr("disabled");
											}
										})
						}
						
						//Onhand Liquor
						if($("#select_type_drink").val()=='Liquor'){
							var d = new Date();
							var month = d.getMonth()+1;
							var day = d.getDate();
							var year = d.getFullYear();
							
							var full_date = month+"_"+day+"_"+year+"_";
							var full_date2 = month+"/"+day+"/"+year;
						
							var bar = $(".bar select").val();
							var file_name = "Onhand/onhand_liquor_"+full_date + bar+".html";
							
							var array = new Array()
							
							for(var x=0;x<$(".onhand_liquor").size();x++)
											{		
											array[x] = $(".onhand_liquor").eq(x).html();
											};
									var x = 0;
							array.unshift(file_name);
							array.unshift(bar);
							array.unshift(full_date2);
						
							var jsonString = JSON.stringify(array);
							
									   $.ajax({
											type: "POST",
											url: "onhand_report_liquor.php",
											data: {data : jsonString}, 
											cache: false,
											success: function(){
												window.open(file_name);
												$("#onhand").removeAttr("disabled");
											}
										})
						}
					});
					
					// Click Generate Z Report 
					
						$(document).on("click","#Z", function(){
							$("#Z").prop("disabled",true);
							
							for(var x=0;x<$(".ordered_txt").size();x++){
								var ordered = $(".ordered").eq(x-x).val();
								if (ordered == ""){
									ordered=0;
								}
								$(".ordered").eq(x-x).remove();
								$(".ordered_txt").eq(x).html(ordered);
							}
						
						// Beer 
							if($("#select_type_drink").val()=='Beer'){
								var d = new Date();
								var month = d.getMonth()+1;
								var day = d.getDate();
								var year = d.getFullYear();
								
								var full_date = month+"_"+day+"_"+year+"_";
								var full_date2 = month+"/"+day+"/"+year;
							
								var bar = $(".bar select").val();
								var file_name = "Z_beer_"+full_date+bar+".html";
								
								var array = new Array()
								
								for(var x=0;x<$(".Z_beer").size();x++)
												{		
												array[x] = $(".Z_beer").eq(x).html();
												};
										var x = 0;
								array.unshift(file_name);
								array.unshift(bar);
								array.unshift(full_date2);
							
								var jsonString = JSON.stringify(array);
								
										   $.ajax({
												type: "POST",
												url: "Z_report_beer.php",
												data: {data : jsonString}, 
												cache: false,
												success: function(){
													window.open(file_name);
													$("#Z").removeAttr("disabled");
												}
											})
							}
								
								
						});
					
				//Sales Upload								
					$(document).on("click","#Sales", function(){
						$('#Tables').fileTree(
							{ 
								root: '<?php echo getcwd();echo'/upload/'; ?>',
								script: 'jqueryFileTree.php',
								multiFolder: true,
								loadMessage:'Loading...'
							},
							
						function openFile(file){
							var raw_file_URL = file;
							var final_file_URL = raw_file_URL.replace("<?php echo getcwd();echo'/'?>","");
							$('#Tables').empty();
							$('#Tables').CSVToTable(final_file_URL,
							{
								loadingImage: 'images/loading.gif',
								tdClass:'SQL',
								trClass:'sales',
								thClass :'sales',
								tbodyClass :'sales'
							});
						});
					});
					
					//Sales to SQL Database 
						$(document).on("click","#SQL", function(){
							var SQL_to_CSV_Array = new Array()
								for(var x=0;x<$(".SQL").size();x++)
									{		
										SQL_to_CSV_Array[x] = $(".SQL").eq(x).html();
									};
									
								SQL_to_CSV_Array.unshift($('#bar_select').val());	
								
								var jsonString = JSON.stringify(SQL_to_CSV_Array);
							
									   $.ajax({
											type: "POST",
											url: "Sales_to_CSV.php",
											data: {data : jsonString}, 
											cache: false,
											success: function(data){
												alert(data);
											}
										})
						});
					//Reload Conifg Options when changing Bar select option
					$("#bar_select").change(function(){
						$("div").remove("#config_inventory");
						if (window.XMLHttpRequest){
							xmlhttp=new XMLHttpRequest();
						}
						xmlhttp.open("GET","Bar_config.php?submit="+$(".bar select").val(),true);
						xmlhttp.send();
						xmlhttp.onreadystatechange=function(){
						if (xmlhttp.readyState==4 && xmlhttp.status==200){
								$("#white_box").append(xmlhttp.responseText);
							}
						}
					});
					
					//Config Options Clicked
					
						//Inventory
							$(document).on("click","#config_inventory", function(){
								if (window.XMLHttpRequest){
										xmlhttp=new XMLHttpRequest();
									}
									
									xmlhttp.onreadystatechange=function(){
										if (xmlhttp.readyState>0 && xmlhttp.readyState<4){
											$("#Tables").empty();
											$("#Tables").append("<img id='loading' src='images/loading.gif'/>");
										}
									}			
									xmlhttp.open("GET","Config_Invt.php?submit="+$(".bar select").val(),true);
									xmlhttp.send();
									xmlhttp.onreadystatechange=function(){
									if (xmlhttp.readyState==4 && xmlhttp.status==200){
											$("#Tables").empty();
											$("#Tables").append("<table border='1px' id='current_inv_table'><th>Type</th><th>Name</th><th>Par</th><th>Vendor</th></table>");
											$("#Table_Top").empty();
											$("#Table_Top").append("<input type='button' value='Submit' id='Submit_config_invt'/>");
											$("#Table_Top").append("Please Do not use apostrophe, ie: '");
											$("#current_inv_table").append(xmlhttp.responseText);
										};
									};
							});
							
							//Submit Config Options (Vendor, Par)
								//$("#Submit_config_invt").unbind('click').bind('click', function (){
								$(document).on("click","#Submit_config_invt", function(){
								
								var array_beer_case = new Array()
									for(var x=0;x<$(".beer_case").size();x++)
										{		
											array_beer_case[x] = $(".beer_case").eq(x).val();
										};
									var x = 0;
									array_beer_case.unshift($('#bar_select').val());
									
								var array_beer_open = new Array()
									for(var x=0;x<$(".beer_open").size();x++)
										{		
											array_beer_open[x] = $(".beer_open").eq(x).val();
										};
									var x = 0;
									array_beer_open.unshift($('#bar_select').val());
									
								var array_wine_open = new Array()
									for(var x=0;x<$(".wine_open").size();x++)
										{		
											array_wine_open[x] = $(".wine_open").eq(x).val();
										};
									var x = 0;
									array_wine_open.unshift($('#bar_select').val());
									
								var array_wine_closed = new Array()
									for(var x=0;x<$(".wine_closed").size();x++)
										{		
											array_wine_closed[x] = $(".wine_closed").eq(x).val();
										};
									var x = 0;
									array_wine_closed.unshift($('#bar_select').val());
									
								var array_liquor_open = new Array()
									for(var x=0;x<$(".liquor_open").size();x++)
										{		
											array_liquor_open[x] = $(".liquor_open").eq(x).val();
										};
									var x = 0;
									array_liquor_open.unshift($('#bar_select').val());
									
								var array_liquor_closed = new Array()
									for(var x=0;x<$(".liquor_closed").size();x++)
										{		
											array_liquor_closed[x] = $(".liquor_closed").eq(x).val();
										};
									var x = 0;
									array_liquor_closed.unshift($('#bar_select').val());
								
									//Sumbit Ajax Methods 
										//Vars 
											var jsonString_beer_case = JSON.stringify(array_beer_case);
											var jsonString_beer_open = JSON.stringify(array_beer_open);
											var jsonString_wine_open = JSON.stringify(array_wine_open);
											var jsonString_wine_closed = JSON.stringify(array_wine_closed);
											var jsonString_liquor_open = JSON.stringify(array_liquor_open);
											var jsonString_liquor_closed = JSON.stringify(array_liquor_closed);
										
											//Beer 	
											   $.ajax({
													type: "POST",
													url: "config_beer_case_invt.php",
													data: {data : jsonString_beer_case}, 
													cache: false,
													success: function(){}
														
													})
												$.ajax({
													type: "POST",
													url: "config_beer_open_invt.php",
													data: {data : jsonString_beer_open}, 
													cache: false,
													success: function(){}
														
													})
											//Wine 		
											   $.ajax({
													type: "POST",
													url: "config_wine_open_invt.php",
													data: {data : jsonString_wine_open}, 
													cache: false,
													success: function(){}
														
													})
												$.ajax({
													type: "POST",
													url: "config_wine_closed_invt.php",
													data: {data : jsonString_wine_closed}, 
													cache: false,
													success: function(){}
														
													})
											// Liquor 
												$.ajax({
													type: "POST",
													url: "config_liquor_open_invt.php",
													data: {data : jsonString_liquor_open}, 
													cache: false,
													success: function(){}
														
													})
												$.ajax({
													type: "POST",
													url: "config_liquor_closed_invt.php",
													data: {data : jsonString_liquor_closed}, 
													cache: false,
													success: function(){}
														
													})
													
									$("#Tables").empty();
									$("#Table_Top").empty();
								});
						//POS
							$(document).on("click","#config_POS", function(){
								$("#config_POS").attr("disabled", "disabled");
								$("#Table_Top").append(pop_config_POS);
								$(document).on("click",".cancel_img", function(){
									$("#pop").remove();
									$("#config_POS").removeAttr("disabled");
								});
								$(document).on("click","#number_rows_submit", function(){
									var array = new Array()
									array[0]=$("#number_rows_pos").val();
									array[1]=$("#bar_select").val();
									$("div").remove("#pop");
									$("#Tables").empty();
									$("#config_POS").removeAttr("disabled");
								//Manage CSV Upload
									
								//Create Table with rows and uploaded file
									var table = $('<table border="1px"></table>').addClass('');
										for(i=0; i<array[0]; i++){
											var row = $('<td></td>').addClass('bar').text('result ' + i);
											table.append(row);
										}
										$('#Tables').append(table);
								//Store rows nubmer with Bar name ID
									var jsonString = JSON.stringify(array);
									   $.ajax({
											type: "POST",
											url: "POS_Table.php",
											data: {data : jsonString}, 
											cache: false,
											success: function(){
												
											}	
									});
								});
							});
						//Drink Mix
					
				});	

				//New Project 
				$(document).ready(function(){
					//Click on Icon
						$("#second").click(function(){
							if(Scanning_session == false){
								$("#Commands").html(new_project_html);
								$("#Tables").empty();
								if (window.XMLHttpRequest){
									xmlhttp=new XMLHttpRequest();
								}
								xmlhttp.onreadystatechange=function(){
									if (xmlhttp.readyState>0 && xmlhttp.readyState<4){
											$("#bar_select").append("<option class='bar'>Loading...</option>");
										}
									}
								xmlhttp.open("GET","Bar.php",true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function(){
								if (xmlhttp.readyState==4 && xmlhttp.status==200){
										$("#bar_select").empty();
										$("#bar_select").append(xmlhttp.responseText);
									}
								}
							};
							if(Scanning_session == true){
								alert("You have initialized a session, please cancel or complete the session before starting a new one.");
							};
					});
					//Click on Add New Bar
					$(document).on("click",".new_bar", function(){
						$(".bar").html(add_new_bar);
					});	
						//Submit New Bar 
						$(document).on("click","#submit_new_bar", function(){
							if(!$("#new_bar_value").val()==""){
								var submit_value = $("#new_bar_value").val();
								$(".bar").empty();
								$(".bar").html(reload_select_bar);
								$("#bar_select").empty();
								if (window.XMLHttpRequest){
									xmlhttp=new XMLHttpRequest();
								}
								xmlhttp.open("GET","add_new.php?submit="+submit_value,true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function(){
									if (xmlhttp.readyState>0 && xmlhttp.readyState<4){
											$("#bar_select").append("<option class='bar'>Loading...</option>");
										}
									}
								xmlhttp.onreadystatechange=function(){
									if (xmlhttp.readyState==4 && xmlhttp.status==200){
										$("#bar_select").append(xmlhttp.responseText);
									};
								};
							}else{
								$("#new_bar_value").val("Please Enter Name");
							}
						});
						//Cancel New Bar
						$(document).on("click","#new_bar_cancel", function(){
							$(".bar").empty();
							$(".bar").html(reload_select_bar);
							$("#bar_select").empty();
							if (window.XMLHttpRequest){
								xmlhttp=new XMLHttpRequest();
							}
							xmlhttp.onreadystatechange=function(){
								if (xmlhttp.readyState>0 && xmlhttp.readyState<4){
										$("#bar_select").append("<option class='bar'>Loading...</option>");
									}
								}
							xmlhttp.open("GET","Bar.php",true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState==4 && xmlhttp.status==200){
									$("#bar_select").empty();
									$("#bar_select").append(xmlhttp.responseText);
								}
							}
						});	
						
					//Begin Clicked
						//Beer Case 
						$(document).on("click","#check_beer_case", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							beer_boolean = true;
							$('#Tables').append(Beer_Case_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Beer_Case_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});	
						// Beer Bottled 
						$(document).on("click","#check_beer_bottle", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							beer_boolean = true;
							$('#Tables').append(Beer_Bottled_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Beer_Bottled_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
					
						// Wine Closed 
						$(document).on("click","#check_wine_closed", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							wine_boolean = true;
							$('#Tables').append(Wine_Closed_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Wine_Closed_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						// Wine Open
						$(document).on("click","#check_wine_open", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							wine_boolean = true;
							$('#Tables').append(Wine_Open_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Wine_Open_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						
						// Liquor Closed
						$(document).on("click","#check_liquor_closed", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							liquor_boolean = true;
							$('#Tables').append(Liquor_Closed_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Liquor_Closed_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						// Liquor Open
						$(document).on("click","#check_liquor_open", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							liquor_boolean = true;
							$('#Tables').append(Liquor_Open_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Liquor_Open_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						
						// Draft Beer Closed
							$(document).on("click","#check_draft_beer_closed", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							draft_beer_boolean = true;
							$('#Tables').append(Beer_Draft_Closed_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Beer_Draft_Closed_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						// Draft Beer Open
							$(document).on("click","#check_draft_beer_open", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							draft_beer_boolean = true;
							$('#Tables').append(Beer_Draft_Open_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Beer_Draft_Open_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						
						// Draft Wine Closed
							$(document).on("click","#check_draftwine_closed", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							draft_wine_boolean = true;
							$('#Tables').append(Wine_Draft_Closed_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Wine_Draft_Closed_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						// Draft Wine Open
							$(document).on("click","#check_draftwine_open", function(){
							Scanning_session = true;
							$(".bar").hide();	
							$(".alcohol").hide();	
							draft_wine_boolean = true;
							$('#Tables').append(Wine_Draft_Open_Table);
							$('#Table_Top').empty();
							$('#Table_Top').append(Wine_Draft_Open_Top);
							
							$('#Commands').append(submit_all_data);
							$('#Commands').append(cancel_session);
						});
						
					//Using Dropdown Menus to Change UPC inputs 
					$(document).on("change","#select_next", function(){
						//beer case 
						if($('#select_next').val()=='Beer_Case_UPC'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Beer_Case_Table);
							$("#Table_Top").append(Beer_Case_Top);
						}
						//beer bottle
						if($("#select_next").val()=='Beer_Bottle_UPC'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Beer_Bottled_Table);
							$("#Table_Top").append(Beer_Bottled_Top);
						}	
						//wine open
						if($('#select_next').val()=='wine_open_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Wine_Open_Table);
							$("#Table_Top").append(Wine_Open_Top);
						}
						//wine closed
						if($("#select_next").val()=='wine_closed_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Wine_Closed_Table);
							$("#Table_Top").append(Wine_Closed_Top);
						}	
						//draft wine open
						if($("#select_next").val()=='draft_wine_open_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Wine_Draft_Open_Table);
							$("#Table_Top").append(Wine_Draft_Open_Top);
						}	
						//draft wine closed
						if($("#select_next").val()=='draft_wine_closed_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Wine_Draft_Closed_Table);
							$("#Table_Top").append(Wine_Draft_Closed_Top);
						}	
						//draft beer closed
						if($("#select_next").val()=='draft_beer_closed_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Beer_Draft_Closed_Table);
							$("#Table_Top").append(Beer_Draft_Closed_Top);
						}
						//draft beer open
						if($("#select_next").val()=='draft_beer_open_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Beer_Draft_Open_Table);
							$("#Table_Top").append(Beer_Draft_Open_Top);
						}
						//liquor open
						if($("#select_next").val()=='liquor_open_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Liquor_Open_Table);
							$("#Table_Top").append(Liquor_Open_Top);
						}	
						//liquor closed
						if($("#select_next").val()=='liquor_closed_next'){
							$("#Tables").empty();
							$("#Table_Top").empty();
							$("#Tables").append(Liquor_Closed_Table);
							$("#Table_Top").append(Liquor_Closed_Top);
						}	
					});
				});
		</script>
	</head>
	<body>
		<header>
			<div id="Header">
				<div id="Square">
				</div>
			</div>
		</header>
		<div id="Main"> 
			<div id="left">
				<div id="Controls">
					<div id="first" class="image">
					</div>
					<div id="second" class="image">
					</div>
					<div id="third" class="image">
					</div>
					<div id="forth" class="image">
					</div>
					<div id="fifth" class="image">
					</div>
				</div>
			</div>
			<div id="Center">
				<div id="Commands">
					
				</div>
			</div>
			<div id="right">
				<div id="Table_Top">
				</div>
				<div id="Tables">
				</div>
			</div>
		</div>
		<footer>
			
		</footer>
	</body>
</html>