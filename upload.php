

<!DOCTYPE html>
<!-- Coded by G0b0RPorA(Abir Ganguly) -->
<html>
<head>
<title>Upload new program</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width = device-width, initial-scale = 1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script-->
<link rel="stylesheet" href="externalFrameworks/maxcdn-bootstrap-3.4.0.min.css">
<script src="externalFrameworks/googleapis-ajax-3.4.1-jquery.min.js"></script>
<script src="externalFrameworks/maxcdn-bootstrap-3.4.0.min.js"></script>
<link rel="stylesheet" href="style-uploadPHP.css">
<script src="default-uploadPHP.js"></script>
</head>
<body>

<?php

/**
 *
 * @author Abir Ganguly.
 *        
 *        
 */
function string_is_not_proper_POST_file_variable($str_var) {
	$strAsArray = str_split ( $str_var );
	return ((count ( $strAsArray ) === 3) && ($strAsArray [1] === '-') && (ctype_alnum ( $strAsArray [0] )) && (ctype_alnum ( $strAsArray [2] )));
}

$_GLOBALS ['targetDir'] = './uploads/';

$_GLOBALS ['STAT_FILE_TRUE'] = '3';
$_GLOBALS ['STAT_FILE_FALSE'] = '9';

if (isset ( $_POST ['file'] )) {

	$fileName = $_POST ['file'];

	if (string_is_not_proper_POST_file_variable ( $fileName )) {
		echo '<script>alert("Smart :-)");</script>';
		die ( 'User may have changed POST data!!!' );
	} else {
		$ques = '';
		$soln = '';
		$outp = '';
		$foundProgram = false;
		if ($file = fopen ( ($_GLOBALS ['targetDir'] . $fileName . '-stat'), "r" )) {
			$_GLOBALS ['statFileContents'] = str_split ( fgets ( $file ) ); // I believe no one will do nasty things with our stat files.
			fclose ( $file );
			$foundProgram = true;
		}
		if ($_GLOBALS ['statFileContents'] [0] === $_GLOBALS ['STAT_FILE_TRUE']) {
			if ($file = fopen ( ($_GLOBALS ['targetDir'] . $fileName . '-q'), "r" )) {
				while ( ! feof ( $file ) ) {
					$ques = $ques . fgets ( $file );
				}
				fclose ( $file );
				$_GLOBALS ['question'] = $ques;
				$foundProgram = true;
			}
		}
		if ($_GLOBALS ['statFileContents'] [1] === $_GLOBALS ['STAT_FILE_TRUE']) {
			if ($file = fopen ( ($_GLOBALS ['targetDir'] . $fileName . '-s'), "r" )) {
				while ( ! feof ( $file ) ) {
					$soln = $soln . fgets ( $file );
				}
				fclose ( $file );
				$_GLOBALS ['solution'] = $soln;
				$foundProgram = true;
			}
		}
		if ($_GLOBALS ['statFileContents'] [2] === $_GLOBALS ['STAT_FILE_TRUE']) {
			if ($file = fopen ( ($_GLOBALS ['targetDir'] . $fileName . '-o'), "r" )) {
				while ( ! feof ( $file ) ) {
					$outp = $outp . fgets ( $file );
				}
				$_GLOBALS ['output'] = $outp;
				fclose ( $file );
			}
		}
		if ($foundProgram) {
			$_GLOBALS ['creator'] = substr ( $fileName, 0, strpos ( $fileName, '-' ) );
			$_GLOBALS ['questionInOneWord'] = substr ( $fileName, (strpos ( $fileName, '-' ) + 1) );
		} else {
			echo '<script>alert("Error in server! Could not open the program(or you may have changed POST data!) or just the output may have been found.");</script>';
			die ( 'Error in server! Could not open the program(or user may have changed POST data!) or just the output may have been found.' );
		}
	}
}

?>
	<div class="container">
		<div class="page-header">
			<h1>Upload JAVA code</h1>
		</div>
		<form onsubmit="return validateForm();" action="" method="POST">
			<div class="form-group" id="acceptCreator">
				<label for="textInput-creator">Creator:</label> <input type="text" id="textInput-creator" class="form-control" name="creator" <?php if(isset($_GLOBALS['creator'])) { echo "value=\"" . $_GLOBALS['creator'] . "\" "; echo 'readonly'; } ?>>
				<div id="info0" class="text-primary">
					This field is mandatory<br> (Please don't add spaces in creator's name.(Use camel case like : romeshNath))<br> (This field should only contain alphabets and digits(alpha-numeric))<br>
				</div>
			</div>
			<div class="form-group" id="acceptQuestionInOneWord">
				<label for="textInput-acceptQuestionInOneWord">Describe question in one word:</label> <input type="text" id="textInput-acceptQuestionInOneWord" class="form-control" name="questionInOneWord" <?php if(isset($_GLOBALS['questionInOneWord'])) { echo "value=\"" . $_GLOBALS['questionInOneWord'] . "\" "; echo 'readonly'; } ?>>
				<div id="info1" class="text-primary">
					This field is mandatory<br> (Please don't add spaces in creator's name.(Use camel case like : palindromeWord))<br> (This field should only contain alphabets and digits(alpha-numeric))<br>
				</div>
			</div>
			<div class="form-group">
				<label for="textArea-question">Question:</label>
				<textarea id="textArea-question" rows="10" class="lg-textarea form-control" name="question" <?php if(isset($_GLOBALS['question'])) echo 'readonly';  ?>><?php if(isset($_GLOBALS['question'])) echo htmlspecialchars($_GLOBALS['question']); ?></textarea>
			</div>
			<div class="form-group">
				<label for="textArea-solution">Solution(JAVA code):</label>
				<textarea id="textArea-solution" rows="10" class="lg-textarea form-control" name="solution" <?php if(isset($_GLOBALS['solution'])) echo 'readonly';  ?>><?php if(isset($_GLOBALS['solution'])) echo htmlspecialchars($_GLOBALS['solution']); ?></textarea>
			</div>
			<!-- Will be added in next release(Maybe) -->
			<!-- <div class="form-group">
				<label for="table-varDesc">Variable description:</label> <br>
				<button class="btn btn-info" onclick="scanForVars()">Scan for variables</button>
				<table id="table-varDesc" class="table table-condensed">
					<thead>
						<tr>
							<th>Variable</th>
							<th>Data type</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>ss</td>
							<td>Doe</td>
							<td><textarea id="varDesc1" rows="5" class="lg-textarea form-control" name="varDesc1"></textarea></td>
						</tr>
					</tbody>
				</table>
			</div> -->
			<div class="form-group">
				<label for="textArea-output">Output:</label>
				<textarea id="textArea-output" rows="10" class="lg-textarea form-control" name="output" <?php if(isset($_GLOBALS['output'])) echo 'readonly';  ?>><?php if(isset($_GLOBALS['output'])) echo htmlspecialchars($_GLOBALS['output']); ?></textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn pull-right btn-success col-md-2">Submit</button>
				<!--button class="btn pull-left btn-warning col-md-2">Cancel</button-->
				<a href="index.php" class="btn pull-left btn-warning col-md-2">Cancel</a>
			</div>
		</form>
	</div>
	<footer>
		(This system is not XSS-proof)<br> Coded by : G0b0RpoRA(Abir Ganguly)
	</footer>
	
	<?php

	/**
	 * In stat files(like duffer-bigProgram-stat), there will be one two or three digit number.
	 * The digits will be 3 and 9. 3 = true(present), 9 = false(absent).
	 * The first digit represents presentness of question file.
	 * The second digit represents presentness of solution file.
	 * The third digit represents presentness of output file.
	 *
	 * Examples:
	 * 393 - represents question present, solution absent, output present.
	 * 993 - represents question absent, solution absent, output present.
	 *
	 * (1 is not considered as true, and 0 not as false, because in PHP
	 * , 1 is considered as true, and 0 as false, so to ensure that this convention
	 * of PHP will not cause any bugs.)
	 */

	if (isset ( $_POST ['creator'] ) || isset ( $_POST ['questionInOneWord'] ) || isset ( $_POST ['question'] ) || isset ( $_POST ['solution'] ) || isset ( $_POST ['output'] )) {

		$max_file_upload_size = 5 * 1024 * 1024; // 5mb
		$creator = 'defaultCreator';
		$questionInOneWord = 'defaultQuestion';
		$uploadOk = false;
		$doneChanges = false;
		if (isset ( $_POST ['creator'] )) {
			$creator = $_POST ['creator'];
			if (! empty ( $creator )) {
				if (! ctype_alnum ( $creator )) {
					echo '<script>alert("Please don\'t add spaces in creator\'s name.(Use camel case like : romeshNath). This field should only contain alphabets and digits(alpha-numeric)");</script>';
					die ();
				}
			} else {
				echo '<script>alert("Filling up the creator\'s name field is mandatory.");</script>';
				die ();
			}
		}
		if (isset ( $_POST ['questionInOneWord'] )) {
			$questionInOneWord = $_POST ['questionInOneWord'];
			if (! empty ( $questionInOneWord )) {
				if (! ctype_alnum ( $questionInOneWord )) {
					echo '<script>alert("Please don\'t add spaces in describe question in one word field.(Use camel case like : romeshNath). This field should only contain alphabets and digits(alpha-numeric)");</script>';
					die ();
				}
			} else {
				echo '<script>alert("Filling up the describe question in one word field is mandatory.");</script>';
				die ();
			}
		}
		$temp = $_GLOBALS ['targetDir'] . $creator . '-' . $questionInOneWord;
		$questionFile = $temp . '-q';
		$solutionFile = $temp . '-s';
		$outputFile = $temp . '-o';
		$statFile = $temp . '-stat';

		if(file_exists($statFile)) {
			if ($file = fopen ($statFile, "r" )) {
				$_GLOBALS ['statFileContents'] = str_split ( fgets ( $file ) ); // I believe no one will do nasty things with our stat files.
				fclose ( $file );
			} else {
				echo '<script>alert("Error in server!");</script>';
				die("Error in server! Cannot open stat file.");
			}
		} else {
			$_GLOBALS ['statFileContents'] = array (
					$_GLOBALS ['STAT_FILE_FALSE'],
					$_GLOBALS ['STAT_FILE_FALSE'],
					$_GLOBALS ['STAT_FILE_FALSE']
			);
		}


		if (($_GLOBALS['statFileContents'][0] === $_GLOBALS['STAT_FILE_TRUE']) && ($_GLOBALS['statFileContents'][1] === $_GLOBALS['STAT_FILE_TRUE']) && ($_GLOBALS['statFileContents'][2] === $_GLOBALS['STAT_FILE_TRUE'])) {
			echo '<script>alert("Program already exists!(Create a new program by changing creator\'s name, or question\'s description in one word)");</script>';
			die ( "Program already exists" );
		}
		if (isset ( $_POST ['question'] )) {
			$question = $_POST ['question'];
			if ($_GLOBALS['statFileContents'][0] === $_GLOBALS['STAT_FILE_FALSE']) {
				if (! empty ( $question )) {
					$doneChanges = true;
					if ($file = fopen ( $questionFile, "w" )) {
						fwrite ( $file, $question . "\n" );
						fclose ( $file );
						$_GLOBALS ['statFileContents'] [0] = $_GLOBALS ['STAT_FILE_TRUE'];
						$uploadOk = true;
					}
				}
			}
		}
		if (isset ( $_POST ['solution'] )) {
			$solution = $_POST ['solution'];
			if ($_GLOBALS['statFileContents'][1] === $_GLOBALS['STAT_FILE_FALSE']) {
				if (! empty ( $solution )) {
					$doneChanges = true;
					if ($file = fopen ( $solutionFile, "w" )) {
						fwrite ( $file, $solution . "\n" );
						fclose ( $file );
						$_GLOBALS ['statFileContents'] [1] = $_GLOBALS ['STAT_FILE_TRUE'];
						$uploadOk = true;
					}
				}
			}
		}
		if (isset ( $_POST ['output'] )) {
			$output = $_POST ['output'];
			if ($_GLOBALS['statFileContents'][2] === $_GLOBALS['STAT_FILE_FALSE']) {
				if (! empty ( $output )) {
					$doneChanges = true;
					if ($file = fopen ( $outputFile, "w" )) {
						fwrite ( $file, $output . "\n" );
						fclose ( $file );
						$_GLOBALS ['statFileContents'] [2] = $_GLOBALS ['STAT_FILE_TRUE'];
						$uploadOk = true;
					}
				}
			}
		}
		if (! $doneChanges) {
			echo '<script>alert("You have not done any changes"); window.location="index.php"</script>';
			die ( 'Not done any changes' );
		}
		if ($uploadOk) {
			if ($file = fopen ( $statFile, 'w' )) {
				fwrite ( $file, implode ( '', $_GLOBALS ['statFileContents'] ) );
				fclose ( $file );
				echo '<script>alert("Program has been uploaded successfully"); window.location="index.php"</script>';
				die ( 'Program has been uploaded successfully' );
			} else {
				echo '<script>alert("Error in server! Your program cannot be uploaded");</script>';
				die ( 'Error in server! Program cannot be uploaded' );
			}
		}
		if ($doneChanges && (! $uploadOk)) {
			echo '<script>alert("Error in server! Your program cannot be uploaded");</script>';
			die ( 'Error in server! Program cannot be uploaded' );
		}
	}
	?>
	
</body>
</html>

