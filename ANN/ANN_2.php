<!DOCTYPE html>
<!-- PHP Basic Artificial Neural Networks, Created By Artur Jerzy Perkitny, 2014 -->

<html>
<head>
	<title>ANN</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="ANN.css">
	<script type="text/javascript">
		//Variables  
			var Input_1;
			var Input_2; 
			var Input_3;
			
			var Weight_1;
			var Weight_2;
			
			var Weight_2_1;
			var Weight_2_2;
			var Weight_2_3;
			
			var Output_1;
			var Output_2;
			var Output_3;
			
			
			var AJAX_Array = new Array();
			
		$(document).ready(function(){
			$("#Run").click(function(){
				Input_1 = $("#Input_1").val();
				Input_2 = $("#Input_2").val();
				
				Weight_1 = $("#Weight_1").val();
				Weight_2 = $("#Weight_2").val();
				Weight_3 = $("#Weight_3").val();
				
				Weight_2_1 = $("#Weight_2_1").val();
				Weight_2_2 = $("#Weight_2_2").val();
				
				Weight_3_1 = $("#Weight_3_1").val();
				
				
				AJAX_Array[0] = Input_1;
				AJAX_Array[1] = Input_2;
				
				AJAX_Array[2] = Weight_1;
				AJAX_Array[3] = Weight_2;
				AJAX_Array[4] = Weight_3;
				
				AJAX_Array[5] = Weight_2_1;
				AJAX_Array[6] = Weight_2_2;
				
				AJAX_Array[7] = Weight_3_1;
				
				AJAX_Array[8] = $("#Output_1").val();
			
				var jsonString = JSON.stringify(AJAX_Array);
							
			   $.ajax({
					type: "POST",
					url: "Calculate3.php",
					data: {data : jsonString}, 
					cache: false,
					success: function(data){
						$("#Console").html(data);
						alert();
					}
				})
			});
		});
	</script>
</head>
<body>
	<div id='Contain'>
		<ul id='Input_Node_Contain'>
			Input_1:<input type='number ' id='Input_1'/>
			<li id='Input_Node'>	
			</li>
			Input_2:<input type='number ' id='Input_2'/>
			<li id='Input_Node'>	
			</li>
		</ul>
		
		<ul id='Weights_Contain'>
			Weight_1:<input type='number ' id='Weight_1'/>
			<li id='Weights'>
			</li>
			Weight_2:<input type='number ' id='Weight_2'/>
			<li id='Weights'>
			</li>
			Weight_3:<input type='number ' id='Weight_3'/>
			<li id='Weights'>
			</li>
		</ul>
		<ul id='Weights_Contain_2'>
			Weight_2_1:<input type='number ' id='Weight_2_1'/>
			<li id='Weights'>
			</li>
			Weight_2_2:<input type='number ' id='Weight_2_2'/>
			<li id='Weights'>
			</li>
		</ul>	
		
		<ul id='Output_Node_Contain'>
			Weight_3_1:<input type='number ' id='Weight_3_1'/>
			<li id='Output_Node'>
			</li>
		</ul>
	</div>
	<input type='button' value='Run' id='Run'/>
	<input type='number' id='Output_1'/>
	<div id='Console' style="overflow:auto;">
		
	</div>
</body>
</html>