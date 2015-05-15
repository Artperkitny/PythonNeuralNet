<body>
		<input type='button' value='Auto Train' id='Auto'/>
		<input type='button' value='Reset' id='reset'/>
		<br><br>
</body>
<?php
	//$data = json_decode(stripslashes($_POST['data']));

		//Variables 
			$Input_1= 0.57263-0.5727;
			$Input_2= 0.11069-0.01901;
			$Desired_Output_1= 572.59;
		
		//Normalize Input 
			$normalized_input_1 = 1/(1+(exp(-1*$Input_1)));
			$normalized_input_2 = 1/(1+(exp(-1*$Input_2)));
			
			$Desired_Output_Normalized = 1/(1+(exp(-1*$Desired_Output_1)));
		//Count	
			$Count = 0;
			$learning_rate= -1000;
	/*		
		//Layer 1 (Input layer)
			// Layer_Input_Node
			//Node 1 (Input 1)
				$Weight_1_1_1= rand (-10,10)/10;
				$Weight_1_1_2= rand (-10,10)/10;
				$Weight_1_1_3= rand (-10,10)/10;
			//Node 2 (Input 2)
				$Weight_1_2_1= rand (-10,10)/10;
				$Weight_1_2_2= rand (-10,10)/10;
				$Weight_1_2_3= rand (-10,10)/10;
		//Layer 2	
			// Layer_Input_Node
			//Node 1
				$Weight_2_1_1= rand (-10,10)/10;
				$Weight_2_1_2= rand (-10,10)/10;
			//Node 2
				$Weight_2_2_1= rand (-10,10)/10;
				$Weight_2_2_2= rand (-10,10)/10;
			//Node 3
				$Weight_2_3_1= rand (-10,10)/10;
				$Weight_2_3_2= rand (-10,10)/10;
			
		//Layer 3
			//Layer_Input_Node
			//Node 1
				$Weight_3_1_1= rand (-10,10)/10;
			//Node 2
				$Weight_3_2_1= rand (-10,10)/10;
		
			
		echo $Input_1;echo "<br>";
		echo $Input_2;echo "<br>";
		echo $Desired_Output_1;echo "<br>";echo "<br>";
			
		echo $Weight_1_1_1;echo "<br>";
		echo $Weight_1_1_2;echo "<br>";
		echo $Weight_1_1_3;echo "<br>";
		echo $Weight_1_2_1;echo "<br>";
		echo $Weight_1_2_2;echo "<br>";
		echo $Weight_1_2_3;echo "<br>";
		echo $Weight_2_1_1;echo "<br>";
		echo $Weight_2_1_2;echo "<br>";
		echo $Weight_2_2_1;echo "<br>";
		echo $Weight_2_2_2;echo "<br>";
		echo $Weight_2_3_1;echo "<br>";
		echo $Weight_2_3_2;echo "<br>";
		echo $Weight_3_1_1;echo "<br>";
		echo $Weight_3_2_1;echo "<br>";			
			
		//Output Layer 1
			//Input_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_1 = ($Input_1*$Weight_1_1_1);
				$Output_1_2_Layer_1 = ($Input_1*$Weight_1_1_2);
				$Output_1_3_Layer_1 = ($Input_1*$Weight_1_1_3);
			//Input_2 Weighted  
				$Output_2_1_Layer_1 = ($Input_2*$Weight_1_2_1);
				$Output_2_2_Layer_1 = ($Input_2*$Weight_1_2_2);
				$Output_2_3_Layer_1 = ($Input_2*$Weight_1_2_3);
			
			//Output Layer 1 node 1
				//$Output_Layer_Node
				$Final_Output_1_1 = $Output_1_1_Layer_1 + $Output_2_1_Layer_1;
				$Final_Output_1_1_Normalized = 1/(1+(exp(-1*$Final_Output_1_1))); 
			//Output Layer 1 node 2
				$Final_Output_1_2 = $Output_1_2_Layer_1 + $Output_2_2_Layer_1;
				$Final_Output_1_2_Normalized = 1/(1+(exp(-1*$Final_Output_1_2))); 
			//Output Layer 1 node 3
				$Final_Output_1_3 = $Output_1_3_Layer_1 + $Output_2_3_Layer_1; 
				$Final_Output_1_3_Normalized = 1/(1+(exp(-1*$Final_Output_1_3))); 
				
		//Output Layer 2
			//Input 2_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_2 = ($Final_Output_1_1*$Weight_2_1_1);
				$Output_1_2_Layer_2 = ($Final_Output_1_1*$Weight_2_1_2);

			//Input 2_2 Weighted
				$Output_2_1_Layer_2 = ($Final_Output_1_2*$Weight_2_2_1);
				$Output_2_2_Layer_2 = ($Final_Output_1_2*$Weight_2_2_2);
				
			//Input 2_3 Weighted
				$Output_3_1_Layer_2 = ($Final_Output_1_3*$Weight_2_3_1);
				$Output_3_2_Layer_2 = ($Final_Output_1_3*$Weight_2_3_2);
				
			//Output Layer 2 node 1
				//$Output_Layer_Node
				$Final_Output_2_1 = $Output_1_1_Layer_2 + $Output_2_1_Layer_2 + $Output_3_1_Layer_2;
				$Final_Output_2_1_Normalized = 1/(1+(exp(-1*$Final_Output_2_1))); 
			//Output Layer 2 node 2
				$Final_Output_2_2 = $Output_1_2_Layer_2 + $Output_2_2_Layer_2 + $Output_3_2_Layer_2;
				$Final_Output_2_2_Normalized = 1/(1+(exp(-1*$Final_Output_2_2))); 
				
		//Layer 3 (Output Layer)
			//Input 3_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_3 = ($Final_Output_2_1*$Weight_3_1_1);
				$Output_2_1_Layer_3 = ($Final_Output_2_2*$Weight_3_2_1);
			//Output Layer 3 node 1
				//$Output_Layer_Node
				$Final_Output_3_1 = $Output_1_1_Layer_3 + $Output_2_1_Layer_3;
				$Final_Output_3_1_Normalized = 1/(1+(exp(-1*$Final_Output_3_1))); 
		
		echo "<br>";echo $Final_Output_3_1;echo "<br><br>";
	

				
		//Output Layer 1
			//Input_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_1 = ($Input_1*$Weight_1_1_1);
				$Output_1_2_Layer_1 = ($Input_1*$Weight_1_1_2);
				$Output_1_3_Layer_1 = ($Input_1*$Weight_1_1_3);
			//Input_2 Weighted  
				$Output_2_1_Layer_1 = ($Input_2*$Weight_1_2_1);
				$Output_2_2_Layer_1 = ($Input_2*$Weight_1_2_2);
				$Output_2_3_Layer_1 = ($Input_2*$Weight_1_2_3);
			
			//Output Layer 1 node 1
				//$Output_Layer_Node
				$Final_Output_1_1 = $Output_1_1_Layer_1 + $Output_2_1_Layer_1;
				$Final_Output_1_1_Normalized = 1/(1+(exp(-1*$Final_Output_1_1))); 
			//Output Layer 1 node 2
				$Final_Output_1_2 = $Output_1_2_Layer_1 + $Output_2_2_Layer_1;
				$Final_Output_1_2_Normalized = 1/(1+(exp(-1*$Final_Output_1_2))); 
			//Output Layer 1 node 3
				$Final_Output_1_3 = $Output_1_3_Layer_1 + $Output_2_3_Layer_1; 
				$Final_Output_1_3_Normalized = 1/(1+(exp(-1*$Final_Output_1_3))); 
				
		//Output Layer 2
			//Input 2_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_2 = ($Final_Output_1_1*$Weight_2_1_1);
				$Output_1_2_Layer_2 = ($Final_Output_1_1*$Weight_2_1_2);

			//Input 2_2 Weighted
				$Output_2_1_Layer_2 = ($Final_Output_1_2*$Weight_2_2_1);
				$Output_2_2_Layer_2 = ($Final_Output_1_2*$Weight_2_2_2);
				
			//Input 2_3 Weighted
				$Output_3_1_Layer_2 = ($Final_Output_1_3*$Weight_2_3_1);
				$Output_3_2_Layer_2 = ($Final_Output_1_3*$Weight_2_3_2);
				
			//Output Layer 2 node 1
				//$Output_Layer_Node
				$Final_Output_2_1 = $Output_1_1_Layer_2 + $Output_2_1_Layer_2 + $Output_3_1_Layer_2;
				$Final_Output_2_1_Normalized = 1/(1+(exp(-1*$Final_Output_2_1))); 
			//Output Layer 2 node 2
				$Final_Output_2_2 = $Output_1_2_Layer_2 + $Output_2_2_Layer_2 + $Output_3_2_Layer_2;
				$Final_Output_2_2_Normalized = 1/(1+(exp(-1*$Final_Output_2_2))); 
				
		//Layer 3 (Output Layer)
			//Input 3_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_3 = ($Final_Output_2_1*$Weight_3_1_1);
				$Output_2_1_Layer_3 = ($Final_Output_2_2*$Weight_3_2_1);
			//Output Layer 3 node 1
				//$Output_Layer_Node
				$Final_Output_3_1 = $Output_1_1_Layer_3 + $Output_2_1_Layer_3;
				$Final_Output_3_1_Normalized = 1/(1+(exp(-1*$Final_Output_3_1)));
				
				echo "Initiating Round, Final Output: ";
				echo $Final_Output_3_1;echo "<br>";
				echo "Initiating Round, Input 1: ";
				echo $Input_1;echo "<br>";
				echo "Initiating Round, Input 2: ";
				echo $Input_2;echo "<br>";
				echo "Initiating Round, Desired_Output: ";
				echo $Desired_Output_1;
				echo "<br>";
				echo "Weight_1_1_1: ";echo $Weight_1_1_1;echo "<br>";
				echo "Weight_1_1_2: ";echo $Weight_1_1_2;echo "<br>";
				echo "Weight_1_1_3: ";echo $Weight_1_1_3;echo "<br>";
				echo "Weight_1_2_1: ";echo $Weight_1_2_1;echo "<br>";
				echo "Weight_1_2_2: ";echo $Weight_1_2_2;echo "<br>";
				echo "Weight_1_2_3: ";echo $Weight_1_2_3;echo "<br>";
				echo "Weight_2_1_1: ";echo $Weight_2_1_1;echo "<br>";
				echo "Weight_2_1_2: ";echo $Weight_2_1_2;echo "<br>";
				echo "Weight_2_2_1: ";echo $Weight_2_2_1;echo "<br>";
				echo "Weight_2_2_2: ";echo $Weight_2_2_2;echo "<br>";
				echo "Weight_2_3_1: ";echo $Weight_2_3_1;echo "<br>";
				echo "Weight_2_3_2: ";echo $Weight_2_3_2;echo "<br>";
				echo "Weight_3_1_1: ";echo $Weight_3_1_1;echo "<br>";
				echo "Weight_3_2_1: ";echo $Weight_3_2_1;echo "<br>";"<br>";
		*/	
				
		//Layer 1 (Input layer)
			// Layer_Input_Node
			//Node 1 (Input 1)
				$Weight_1_1_1= $_GET['Weight1'];
				$Weight_1_1_2= $_GET['Weight2'];
				$Weight_1_1_3= $_GET['Weight3'];
			//Node 2 (Input 2)
				$Weight_1_2_1= $_GET['Weight4'];
				$Weight_1_2_2= $_GET['Weight5'];
				$Weight_1_2_3= $_GET['Weight6'];
		//Layer 2	
			// Layer_Input_Node
			//Node 1
				$Weight_2_1_1= $_GET['Weight7'];
				$Weight_2_1_2= $_GET['Weight8'];
			//Node 2
				$Weight_2_2_1= $_GET['Weight9'];
				$Weight_2_2_2= $_GET['Weight10'];
			//Node 3
				$Weight_2_3_1= $_GET['Weight11'];
				$Weight_2_3_2= $_GET['Weight12'];
			
		//Layer 3
			//Layer_Input_Node
			//Node 1
				$Weight_3_1_1= $_GET['Weight13'];
			//Node 2
				$Weight_3_2_1= $_GET['Weight14'];
		//Count 
			$Count = $_GET['count'];
			
		//Speed 
			$Speed	= $_GET['speed'];
		
		//Variables Learning Rate 
			/*
			if($Count==0){
				$learning_rate= -10*10;
			};
			
			if($Count>1 && $Count<10){
				$learning_rate= 10*pow(10,2);
			};
			
			if($Count>10 && $Count<100){
				$learning_rate= 10*pow(10,2);
			};
			
			if($Count>100 && $Count<1000){
				$learning_rate= 10*pow(10,2);
			};
			if($Count>1000){
				$learning_rate= 10*pow(10,2);
			};
		*/
				
	for($x=0;$x<=1000;$x++){
		
		//Output Layer 1
			//Input_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_1 = ($Input_1*$Weight_1_1_1);
				$Output_1_2_Layer_1 = ($Input_1*$Weight_1_1_2);
				$Output_1_3_Layer_1 = ($Input_1*$Weight_1_1_3);
			//Input_2 Weighted  
				$Output_2_1_Layer_1 = ($Input_2*$Weight_1_2_1);
				$Output_2_2_Layer_1 = ($Input_2*$Weight_1_2_2);
				$Output_2_3_Layer_1 = ($Input_2*$Weight_1_2_3);
			
			//Output Layer 1 node 1
				//$Output_Layer_Node
				$Final_Output_1_1 = $Output_1_1_Layer_1 + $Output_2_1_Layer_1;
				$Final_Output_1_1_Normalized = 1/(1+(exp(-1*$Final_Output_1_1))); 
			//Output Layer 1 node 2
				$Final_Output_1_2 = $Output_1_2_Layer_1 + $Output_2_2_Layer_1;
				$Final_Output_1_2_Normalized = 1/(1+(exp(-1*$Final_Output_1_2))); 
			//Output Layer 1 node 3
				$Final_Output_1_3 = $Output_1_3_Layer_1 + $Output_2_3_Layer_1; 
				$Final_Output_1_3_Normalized = 1/(1+(exp(-1*$Final_Output_1_3))); 
				
		//Output Layer 2
			//Input 2_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_2 = ($Final_Output_1_1*$Weight_2_1_1);
				$Output_1_2_Layer_2 = ($Final_Output_1_1*$Weight_2_1_2);

			//Input 2_2 Weighted
				$Output_2_1_Layer_2 = ($Final_Output_1_2*$Weight_2_2_1);
				$Output_2_2_Layer_2 = ($Final_Output_1_2*$Weight_2_2_2);
				
			//Input 2_3 Weighted
				$Output_3_1_Layer_2 = ($Final_Output_1_3*$Weight_2_3_1);
				$Output_3_2_Layer_2 = ($Final_Output_1_3*$Weight_2_3_2);
				
			//Output Layer 2 node 1
				//$Output_Layer_Node
				$Final_Output_2_1 = $Output_1_1_Layer_2 + $Output_2_1_Layer_2 + $Output_3_1_Layer_2;
				$Final_Output_2_1_Normalized = 1/(1+(exp(-1*$Final_Output_2_1))); 
			//Output Layer 2 node 2
				$Final_Output_2_2 = $Output_1_2_Layer_2 + $Output_2_2_Layer_2 + $Output_3_2_Layer_2;
				$Final_Output_2_2_Normalized = 1/(1+(exp(-1*$Final_Output_2_2))); 
				
		//Layer 3 (Output Layer)
			//Input 3_1 Weighted
				//$Output_input_node_layer
				$Output_1_1_Layer_3 = ($Final_Output_2_1*$Weight_3_1_1);
				$Output_2_1_Layer_3 = ($Final_Output_2_2*$Weight_3_2_1);
			//Output Layer 3 node 1
				//$Output_Layer_Node
				$Final_Output_3_1 = $Output_1_1_Layer_3 + $Output_2_1_Layer_3;
				$Final_Output_3_1_Normalized = 1/(1+(exp(-1*$Final_Output_3_1))); 
				
		//Adding to Weights 
			//Layer 1 (Input layer)
				//Node 1 (Input 1)
					$Weight_1_1_1+=$Weight_1_1_1_Adujst;
					$Weight_1_1_2+=$Weight_1_1_2_Adujst;
					$Weight_1_1_3+=$Weight_1_1_3_Adujst;
				//Node 2 (Input 2)
					$Weight_1_2_1+=$Weight_1_2_1_Adujst;
					$Weight_1_2_2+=$Weight_1_2_2_Adujst;
					$Weight_1_2_3+=$Weight_1_2_3_Adujst;
			//Layer 2	
				// Layer_Input_Node
				//Node 1
					$Weight_2_1_1+=$Weight_2_1_1_Adujst;
					$Weight_2_1_2+=$Weight_2_1_2_Adujst;
				//Node 2
					$Weight_2_2_1+=$Weight_2_2_1_Adujst;
					$Weight_2_2_2+=$Weight_2_2_2_Adujst;
				//Node 3
					$Weight_2_3_1+=$Weight_2_3_1_Adujst;
					$Weight_2_3_2+=$Weight_2_3_2_Adujst;
			//Layer 3
				//Layer_Input_Node
				//Node 1
					$Weight_3_1_1+=$Weight_3_1_1_Adujst;
				//Node 2
					$Weight_3_2_1+=$Weight_3_2_1_Adujst;
		//Back-propagation Algorithm
			//Output Layer 
				$Delta_output_layer = 
					$Final_Output_3_1_Normalized*(1-$Final_Output_3_1_Normalized)*($Final_Output_3_1_Normalized-$Desired_Output_Normalized);
					
			//Hidden Layer 2
				$Delta_Hidden_Layer_2_1 = 
					$Final_Output_2_1_Normalized*(1-$Final_Output_2_1_Normalized)*($Delta_output_layer*$Weight_3_1_1);
				
				$Delta_Hidden_Layer_2_2 = 
					$Final_Output_2_2_Normalized*(1-$Final_Output_2_2_Normalized)*($Delta_output_layer*$Weight_3_2_1);
				
			//Hidden Layer 1	
				$Delta_Hidden_Layer_1_1 = 
					$Final_Output_1_1_Normalized*(1-$Final_Output_1_1_Normalized)*
					(($Delta_Hidden_Layer_2_1*$Weight_2_1_1)+($Delta_Hidden_Layer_2_1*$Weight_2_1_2));
				$Delta_Hidden_Layer_1_2 =
					$Final_Output_1_2_Normalized*(1-$Final_Output_1_2_Normalized)*
					(($Delta_Hidden_Layer_2_1*$Weight_2_2_1)+($Delta_Hidden_Layer_2_1*$Weight_2_2_2));
				$Delta_Hidden_Layer_1_3 = 
					$Final_Output_1_3_Normalized*(1-$Final_Output_1_3_Normalized)*
					(($Delta_Hidden_Layer_2_1*$Weight_2_3_1)+($Delta_Hidden_Layer_2_1*$Weight_2_3_2));
			
		//Weight Adjustments 
			//Output Layer 
				$Weight_3_1_1_Adujst = $learning_rate*$Delta_output_layer*$Final_Output_2_1_Normalized;
				$Weight_3_2_1_Adujst = $learning_rate*$Delta_output_layer*$Final_Output_2_2_Normalized;
			
			//Hidden Layer 2
				$Weight_2_1_1_Adujst = $learning_rate*$Delta_Hidden_Layer_2_1*$Final_Output_1_1_Normalized;
				$Weight_2_1_2_Adujst = $learning_rate*$Delta_Hidden_Layer_2_2*$Final_Output_1_1_Normalized;
				
				$Weight_2_2_1_Adujst = $learning_rate*$Delta_Hidden_Layer_2_1*$Final_Output_1_2_Normalized;
				$Weight_2_2_2_Adujst = $learning_rate*$Delta_Hidden_Layer_2_2*$Final_Output_1_2_Normalized;
				
				$Weight_2_3_1_Adujst = $learning_rate*$Delta_Hidden_Layer_2_1*$Final_Output_1_3_Normalized;
				$Weight_2_3_2_Adujst = $learning_rate*$Delta_Hidden_Layer_2_2*$Final_Output_1_3_Normalized;
			
			//Hidden Layer 1
				$Weight_1_1_1_Adujst = $learning_rate*$Delta_Hidden_Layer_1_1*$normalized_input_1;
				$Weight_1_1_2_Adujst = $learning_rate*$Delta_Hidden_Layer_1_2*$normalized_input_1;
				$Weight_1_1_3_Adujst = $learning_rate*$Delta_Hidden_Layer_1_3*$normalized_input_1;
				
				$Weight_1_2_1_Adujst = $learning_rate*$Delta_Hidden_Layer_1_1*$normalized_input_2;
				$Weight_1_2_2_Adujst = $learning_rate*$Delta_Hidden_Layer_1_2*$normalized_input_2;
				$Weight_1_2_3_Adujst = $learning_rate*$Delta_Hidden_Layer_1_3*$normalized_input_2;
				
			
			
			
		if($Desired_Output_1==round($Final_Output_3_1,2)){
			echo "Done Training!";echo"<br>";
			echo "Learning Rate: ".$learning_rate;echo"<br>";
			echo "Final Output: ".$Final_Output_3_1;echo"<br>";
			echo "Desired Output: ".$Desired_Output_1;echo"<br>";
			echo "Error of Output: ".($Desired_Output_1/$Final_Output_3_1)*100;echo"%<br>";
			echo "Input 1: ".$Input_1;echo"<br>";
			echo "Input 2: ".$Input_2;echo"<br>";
				
			echo "Weight_1_1_1: ";echo $Weight_1_1_1;echo "<br>";
			echo "Weight_1_1_2: ";echo $Weight_1_1_2;echo "<br>";
			echo "Weight_1_1_3: ";echo $Weight_1_1_3;echo "<br>";
			echo "Weight_1_2_1: ";echo $Weight_1_2_1;echo "<br>";
			echo "Weight_1_2_2: ";echo $Weight_1_2_2;echo "<br>";
			echo "Weight_1_2_3: ";echo $Weight_1_2_3;echo "<br>";
			echo "Weight_2_1_1: ";echo $Weight_2_1_1;echo "<br>";
			echo "Weight_2_1_2: ";echo $Weight_2_1_2;echo "<br>";
			echo "Weight_2_2_1: ";echo $Weight_2_2_1;echo "<br>";
			echo "Weight_2_2_2: ";echo $Weight_2_2_2;echo "<br>";
			echo "Weight_2_3_1: ";echo $Weight_2_3_1;echo "<br>";
			echo "Weight_2_3_2: ";echo $Weight_2_3_2;echo "<br>";
			echo "Weight_3_1_1: ";echo $Weight_3_1_1;echo "<br>";
			echo "Weight_3_2_1: ";echo $Weight_3_2_1;echo "<br>";"<br>";	
			$x=1001;

		}
		if($x==1000){
			echo "Training Round ".$x*$Count;echo"<br>";
			echo "Learning Rate: ".$learning_rate;echo"<br>";
			echo "Final Output: ".$Final_Output_3_1;echo"<br>";
			echo "Desired Output: ".$Desired_Output_1;echo"<br>";
			echo "Error of Output: ".($Desired_Output_1/$Final_Output_3_1)*100;echo"%<br>";
			echo "Speed of Training: ".(($Desired_Output_1/$Final_Output_3_1)-$speed)/100;
			echo"/Per Round";
			echo"<br>";
			echo "Input 1: ".$Input_1;echo"<br>";
			echo "Input 2: ".$Input_2;echo"<br>";
			echo "Weight_1_1_1: ";echo $Weight_1_1_1;echo "<br>";
			echo "Weight_1_1_2: ";echo $Weight_1_1_2;echo "<br>";
			echo "Weight_1_1_3: ";echo $Weight_1_1_3;echo "<br>";
			echo "Weight_1_2_1: ";echo $Weight_1_2_1;echo "<br>";
			echo "Weight_1_2_2: ";echo $Weight_1_2_2;echo "<br>";
			echo "Weight_1_2_3: ";echo $Weight_1_2_3;echo "<br>";
			echo "Weight_2_1_1: ";echo $Weight_2_1_1;echo "<br>";
			echo "Weight_2_1_2: ";echo $Weight_2_1_2;echo "<br>";
			echo "Weight_2_2_1: ";echo $Weight_2_2_1;echo "<br>";
			echo "Weight_2_2_2: ";echo $Weight_2_2_2;echo "<br>";
			echo "Weight_2_3_1: ";echo $Weight_2_3_1;echo "<br>";
			echo "Weight_2_3_2: ";echo $Weight_2_3_2;echo "<br>";
			echo "Weight_3_1_1: ";echo $Weight_3_1_1;echo "<br>";
			echo "Weight_3_2_1: ";echo $Weight_3_2_1;echo "<br>";"<br>";	
	
		}else{
			
		}
	
	};

?>
<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript">
			var x = 0; 

			$(document).ready(function(){
					Training();
				$("#reset").click(function(){
					Reset();
				});
			});

			function Training(){
					var Weight_1 = <?php echo(json_encode($Weight_1_1_1)); ?>;
					var Weight_2 = <?php echo(json_encode($Weight_1_1_2)); ?>;
					var Weight_3 = <?php echo(json_encode($Weight_1_1_3)); ?>;
					var Weight_4 = <?php echo(json_encode($Weight_1_2_1)); ?>;
					var Weight_5 = <?php echo(json_encode($Weight_1_2_2)); ?>;
					var Weight_6 = <?php echo(json_encode($Weight_1_2_3)); ?>;
					var Weight_7 = <?php echo(json_encode($Weight_2_1_1)); ?>;
					var Weight_8 = <?php echo(json_encode($Weight_2_1_2)); ?>;
					var Weight_9 = <?php echo(json_encode($Weight_2_2_1)); ?>;
					var Weight_10 = <?php echo(json_encode($Weight_2_2_2)); ?>;
					var Weight_11 = <?php echo(json_encode($Weight_2_3_1)); ?>;
					var Weight_12 = <?php echo(json_encode($Weight_2_3_2)); ?>;
					var Weight_13 = <?php echo(json_encode($Weight_3_1_1)); ?>;
					var Weight_14 = <?php echo(json_encode($Weight_3_2_1)); ?>;
					var count = <?php echo(json_encode($Count)); ?>;
					var speed = <?php echo(json_encode($Desired_Output_1/$Final_Output_3_1)); ?>;
					
					count++;
					window.location.href = "Calculate3.php?"
						+"Weight1="+ Weight_1
						+"&Weight2="+ Weight_2
						+"&Weight3="+ Weight_3
						+"&Weight4="+ Weight_4
						+"&Weight5="+ Weight_5
						+"&Weight6="+ Weight_6
						+"&Weight7="+ Weight_7
						+"&Weight8="+ Weight_8
						+"&Weight9="+ Weight_9
						+"&Weight10="+ Weight_10
						+"&Weight11="+ Weight_11
						+"&Weight12="+ Weight_12
						+"&Weight13="+ Weight_13
						+"&Weight14="+ Weight_14
						+"&count="+ count
						+"&speed="+ speed;
					
					
			}
			function Reset(){
					count=0;
					var Weight_1 = Math.random();
					var Weight_2 = Math.random();
					var Weight_3 = Math.random();
					var Weight_4 = Math.random(); 
					var Weight_5 = Math.random();
					var Weight_6 = Math.random(); 
					var Weight_7 = Math.random(); 
					var Weight_8 = Math.random(); 
					var Weight_9 = Math.random(); 
					var Weight_10 = Math.random(); 
					var Weight_11 = Math.random(); 
					var Weight_12 = Math.random(); 
					var Weight_13 = Math.random(); 
					var Weight_14 = Math.random(); 
					
					window.location.href = "Calculate3.php?"
						+"Weight1="+ Weight_1
						+"&Weight2="+ Weight_2
						+"&Weight3="+ Weight_3
						+"&Weight4="+ Weight_4
						+"&Weight5="+ Weight_5
						+"&Weight6="+ Weight_6
						+"&Weight7="+ Weight_7
						+"&Weight8="+ Weight_8
						+"&Weight9="+ Weight_9
						+"&Weight10="+ Weight_10
						+"&Weight11="+ Weight_11
						+"&Weight12="+ Weight_12
						+"&Weight13="+ Weight_13
						+"&Weight14="+ Weight_14
						+"&count="+ count;
			
			}
			
		</script>
	</head>
</html>