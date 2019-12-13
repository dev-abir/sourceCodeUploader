<!DOCTYPE html>
<!--G0boRPorA = Abir Ganguly.-->
<html>
<head>
<title>View and upload code</title>
</head>
<body>
	<form enctype="multipart/form-data" action="" method="POST">
		Select your file to upload : <input type="file" name="fileToUpload"> <input
			type="submit" value="Upload">
	</form>

  <?php
$GLOBALS['TARGET_DIR'] = './uploads/';

if (! empty($_FILES['fileToUpload'])) {
    $max_file_size = 5 * 1024 * 1024; // 5mb
    $fileName = basename($_FILES['fileToUpload']['name']);
    $target_file = $GLOBALS['TARGET_DIR'] . basename($fileName);
    $uploadOk = 0;

    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // If no file chosen
    if (empty($fileName)) {
        echo 'No file chosen.<br>';
    } // If file already exists
    else if (file_exists($target_file)) {
        echo 'File already exists.<br>';
        echo 'File will be overriden..<br>';
        $uploadOk = 1;
    } // Check file size
    else if ($_FILES['fileToUpload']['size'] > $max_file_size) {
        echo 'File is too large.<br>';
        echo 'The file was not uploaded.<br>';
    } // Allow only txt
    else if ($fileType != 'txt') {
        echo 'Only txt file upload is allowed.<br>';
        echo 'The file was not uploaded.<br>';
    } else {
        $uploadOk = 1;
    }

    if ($uploadOk) {
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
            echo basename($_FILES['fileToUpload']['name']) . ' has been uploaded.<br>';
            // echo '<script type="text/javascript">location.reload(true);</script>';
            clearstatcache();
        } else {
            echo 'There was an error uploading your file.<br>';
        }
    }
}
?>

  <h1>Files list :</h1>

  <?php
$files = array_diff(scandir($GLOBALS['TARGET_DIR']), array(
    '.',
    '..'
));
if (count(scandir($GLOBALS['TARGET_DIR'])) == 2) { // if TARGET_DIR is empty
    echo '<i>Directory is empty!</i><br>';
} else {
    echo '<table>';
    foreach ($files as $eachFile) {
        echo '<tr>';
        echo '<td><a href="' . $GLOBALS['TARGET_DIR'] . $eachFile . '">' . $eachFile . '</a></td>';
        echo '<td><a href="' . $GLOBALS['TARGET_DIR'] . $eachFile . '" download>download</a></td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>


  Coded by G0boRPorA (See source of this file)
</body>
</html>