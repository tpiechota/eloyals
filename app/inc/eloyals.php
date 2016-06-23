<?php
	
	// function to create the string for the barcode
	// parameter: $id - ID of the customer
	function code ($id){
	
		$barcode = "eLoyals".(10 - strlen($id))."x".$id.checksum($id);
		
		return $barcode;
		
	}
	
	// function to generate the checksum of the id
	// parameter: $id - ID of the customer
	function checksum($id){

		$position = 10 - strlen($id) + 1;
		
		$sum2 = 0;
		$sum3 = 0;

		for( $loop = 0; $loop < strlen($id); $loop++ ) {
		
			$sum2 = $sum2 + pow(intval(substr($id,$loop, 1)) + $position,2);
			
			$sum3 = $sum3 + pow(intval(substr($id,$loop, 1)) + $position,3);
			
			$position++;
			
		}
		
		$chk1 = ($sum3 - $sum2) % 10;

		$chk2 = chr(($sum3 % 26) + 65);
		
		return $chk1.$chk2;
		
	}
	
	// function to check if the coming string is a valid eLoyals encode
	function decode($barcode){ 
	
		$eLoyals = strcmp(substr($barcode,0,7),"eLoyals");
		
		// Gets the ID from the barcode
		// strlen($barcode) - 11 to get the ID in the barcode
		$id  = substr($barcode,9,strlen($barcode) - 11);
		
		// Gets the check sum of the barcode
		$digit = substr($barcode,strlen($barcode) - 2,2);
		
		// check whether barcode starts with eLoyals
		if ( (bool) $eLoyals) {
			
			return False;
			
		}
		
		// Gets the checksum from the ID to compare with the one in the barcode
		$chk = checksum($id);
		
		// Check sum of the barcode not valid
		if ($digit != $chk) {
		
			return False;
			
		}
		
		return $id;
			
	}
	
	// function to generate qr code and save it as id.png in the specified folder
	function qrtoimage($barcode, $size, $id){
		
		$qr = 'http://api.qrserver.com/v1/create-qr-code/?data='.$barcode.'&size='.$size.'x'.$size;
		
		$dir = "qr_img";
								
		$fname = $id."_qr.png";
		
		$content = file_get_contents($qr);	
		
		file_put_contents("$dir/$fname", $content);
		
	}
?>