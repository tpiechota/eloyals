<?php
// this is how to implement the functions in the page
include 'eloyals.php';

// test to generate 100 diferent IDs
for ($x = 0; $x < 100 ;$x++ ){
			
	// id is the customer id retrieved from the database
	$id = rand(1,100000); // id is a random number between 1 and 100000
				
	// the function code($id) returns the string to generate the barcode
	$barcode = code($id);
				
	echo "<b>ID:</b> ".$id." <b>Barcode:</b> ".$barcode;
				
	// the function decode($barcode) takes a barcode string and check whether is a eLoyals encode ID
	$check = decode($barcode);
				
	// if $check is False then it is because the string isn't a valid eLoyals barcode
	if( $check == False ) {
				
		echo "ERROR !!! IT IS NOT A VALID eLoyals BARCODE !!!";
				
	} else {
				
		echo " <b>Decode ID:</b> ".$check."<br>";
					
	}
}
?>