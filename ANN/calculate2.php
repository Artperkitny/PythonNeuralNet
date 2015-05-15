<body>
		<input type='button' value='Train' id='button'/>
		<input type='button' value='Reset' id='reset'/>
		<input type='text' value='0' id='Count'/>
</body>
<?php
	$data = json_decode(stripslashes($_POST['data']));
		//Variables 
			$Input_1= 1;
			$Desired_Output_1=0.15;
			echo "<br><br>";
			echo "Input: ";echo $Input_1;echo "<br>";
			echo "Desired Output: ";echo $Desired_Output_1;echo "<br><br>";
		//Normalize Input 
			$normalized_input = 1/(1+(exp(-1*$Input_1)));
			$Desired_Output_Normalized = 1/(1+(exp(-1*$Desired_Output_1)));
			
		if($Input_1==null){
			//Layer one 
				$Weight_1= 1;
				$Weight_2= 1;
			
			//Output Layer 
				$Weight_3= 1;
				$Weight_4= 1;
		}else{
			//Layer one 
				$Weight_1=$_GET['Weight1'];
				$Weight_2=$_GET['Weight2'];
			
			//Output Layer 
				$Weight_3=$_GET['Weight3'];
				$Weight_4=$_GET['Weight4'];
		}
		echo "W1: ";echo $Weight_1;echo "<br>";
		echo "W2: ";echo $Weight_2;echo "<br>";
		echo "W3: ";echo $Weight_3;echo "<br>";
		echo "W4: ";echo $Weight_4;echo "<br><br>";
	
if($Input_1!=null){	
	for($x=0;$x<10000;$x++){
		//Weight Adjustments 
			$Weight_1+=$weight_adjust_1;
			$Weight_2+=$weight_adjust_2;
			$Weight_3+=$weight_adjust_3;
			$Weight_4+=$weight_adjust_4;
		// Hidden Layer 1
			$Output_1_Layer_1 = ($Input_1*$Weight_1);
			$normalized_output_1_layer_1 = 1/(1+(exp(-1*$Output_1_Layer_1)));
			
			$Output_2_Layer_1 = ($Input_1*$Weight_2);
			$normalized_output_2_layer_1 = 1/(1+(exp(-1*$Output_2_Layer_1)));
			
		//Output Layer 
			$final_Output = ($Output_1_Layer_1*$Weight_3)+($Output_2_Layer_1*$Weight_4);
			$final_Output_normalized = 1/(1+(exp(-1*$final_Output)));
		
		//Backpropagation Algorithm
			$delta = $final_Output_normalized-$Desired_Output_Normalized*$final_Output_normalized*(1-$final_Output_normalized);
			
			$weight_adjust_1 = 
				-0.01*($normalized_output_1_layer_1*(1-$normalized_output_1_layer_1)*($delta*$Weight_3));
			
			$weight_adjust_2 =
				-0.01*($normalized_output_2_layer_1*(1-$normalized_output_2_layer_1)*($delta*$Weight_4));
			
			$weight_adjust_3 =
				-0.01*(($final_Output_normalized-$Desired_Output_Normalized)*$final_Output_normalized*(1-$final_Output_normalized))*$normalized_output_1_layer_1;
			
			$weight_adjust_4 = 
				-0.01*(($final_Output_normalized-$Desired_Output_Normalized)*$final_Output_normalized*(1-$final_Output_normalized))*$normalized_output_2_layer_1;
				
		//Error 
			
			if($final_Output-$Desired_Output_1<=0.001 && $final_Output-$Desired_Output_1>=-0.001){
				echo "Done Training!";echo $x;echo"<br>";
				$x=10000;
				echo $Weight_1;echo "<br>";	
				echo $Weight_2;echo "<br>";	
				echo $Weight_3;echo "<br>";	
				echo $Weight_4;echo "<br><br>";	
				
				echo $final_Output;echo "<br>";		
				echo $Desired_Output_1;echo "<br><br>";		
				
			}
			
			if($final_Output-$Desired_Output_1>=10 || $final_Output-$Desired_Output_1<=-10){
				if($x>100){
					echo $x;echo "_Training Terminated Early! <br><br>";
					echo $final_Output;echo "<br><br>";
					$x=10000;
				}
			}
			
			if($x==9999){
				echo "Training Set Failed!";echo "<br><br>";
				echo $final_Output;echo "<br><br>";

			}
			if($x==0){
				echo $final_Output;echo "<br><br>";
			}
			
			
			
	}
};	
	
?>

<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript">
			var x = 0; 
			$(document).ready(function(){
				$("#button").click(function(){
					Training();
				});
				$("#reset").click(function(){
					Reset();
				});
			});
			
			function Training(){
					var Weight_1 = <?php echo(json_encode($Weight_1)); ?>;
					var Weight_2 = <?php echo(json_encode($Weight_2)); ?>;
					var Weight_3 = <?php echo(json_encode($Weight_3)); ?>;
					var Weight_4 = <?php echo(json_encode($Weight_4)); ?>;
					
					window.location.href = "calculate2.php?Input="
						+"&Weight1="+ Weight_1
						+"&Weight2="+ Weight_2
						+"&Weight3="+ Weight_3
						+"&Weight4="+ Weight_4;
				}
			function Reset(){
					var Weight_1 = 1;
					var Weight_2 = 1;
					var Weight_3 = 1;
					var Weight_4 = 1;
					
					window.location.href = "calculate2.php?Input="
						+"&Weight1="+ Weight_1
						+"&Weight2="+ Weight_2
						+"&Weight3="+ Weight_3
						+"&Weight4="+ Weight_4;
			
			}
			
		</script>
	</head>
</html>