<?php 
	//$data = json_decode(stripslashes($_POST['data']));
	
	//Variables 
		//$Input_1=$data[0]; 
		$Input_1=1; 
		
		//Normalize Input 
			$Normalized_Input = 1/(1+exp($Input_1));
		
		$Weight_1=$data[3];
		$Weight_2=$data[4];
		
		$Weight_3=$data[5];
		
		$Desired_Output_1=$data[8];
		
		// Hidden Layer 1
			$Output_1_Layer_1=($Input_1*$Weight_1);
			$Output_2_Layer_1($Input_1*$Weight_2);
		
		$final_Output = $Output_1*$Weight_3;
		
		echo "Output:".$Normalized_Input."<br>"; 		

		$Output_Error_1 = pow(($Desired_Output_1-$Output_1),2); 
		
		$Total_Network_Error = $Output_Error_1+$Output_Error_2+$Output_Error_3;
		
		
		//Backpropagation Algorithm
		
			// Normalizing the Inputs using Sigmoid Function 
			
			
			
 
		
		
		
?>