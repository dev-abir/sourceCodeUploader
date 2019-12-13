<!DOCTYPE html>
<!-- Coded by G0b0RPorA(Abir Ganguly) -->
<html>
<head>
<title>View programs</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width = device-width, initial-scale = 1">
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script-->
<link rel="stylesheet" href="externalFrameworks/maxcdn-bootstrap-3.4.0.min.css">
<script src="externalFrameworks/googleapis-ajax-3.4.1-jquery.min.js"></script>
<script src="externalFrameworks/maxcdn-bootstrap-3.4.0.min.js"></script>
<link rel="stylesheet" href="style-uploadPHP.css">
</head>
<body>


	<div class="container">
		<div class="page-header">
			<h1>Programs list:</h1>
		</div>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Program</th>
				<th>Creator</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>

<?php
/**
 * 
 * 
 * TODO : Create a sort button(on clicking sort button beside Program column heading, the program names will be sorted. on clicking sort button beside Creator column heading, the creator names will be sorted. Also create sort button beside status.)
 * 
 */


$STAT_FILE_TRUE = '3';
$STAT_FILE_FALSE = '9';

$targetDir = './uploads/';

$files = array_diff ( scandir ( $targetDir ), array (
		'.',
		'..'
) );
if (count ( scandir ( $targetDir ) ) == 2) { // if TARGET_DIR is empty
	echo '<i>Directory is empty!</i><br>';
} else {
	foreach ( $files as $eachFile ) {
		$ok = false;
		if(substr($eachFile, -5) === '-stat') {
			if($file = fopen($targetDir . $eachFile, 'r')) {
				$fileName = str_replace('-stat', '', $eachFile);
				echo '<tr>';
				echo '<td>' . substr ( $fileName, (strpos ( $fileName, '-' ) + 1) ) . '</td>';
				echo '<td>' . substr ( $fileName, 0, strpos ( $fileName, '-' ) ) . '</td>';
				$statFileContents = str_split ( fgets ( $file ) ); // I believe no one will do nasty things with our stat files.
				if(($statFileContents[0] === $STAT_FILE_TRUE) && ($statFileContents[1] === $STAT_FILE_TRUE) && ($statFileContents[2] === $STAT_FILE_TRUE)) {
					echo '<td class="text-success">Done!</td>';
				}
				else if(($statFileContents[0] === $STAT_FILE_TRUE) && ($statFileContents[1] === $STAT_FILE_TRUE)) {
					echo '<td class="text-warning">Almost done!</td>';
				}
				else {
					echo '<td class="text-danger">Incomplete!</td>';
				}
				fclose($file);
				echo '</tr>';
				$ok = true;
			}
			if(!$ok) {
				echo '<script>alert("Error in server!");</script>';
				die ( 'Error in server!' );
			}
		}
	}
}
?>

		</tbody>
	</table>
	</div>
	<footer>
		(This system is not XSS-proof)<br> Coded by : G0b0RpoRA(Abir Ganguly)
	</footer>

</body>
</html>





