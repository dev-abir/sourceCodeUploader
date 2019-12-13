<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>D.TECH</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="ui.css">
    </head>
    <body>
        
    <header>COMPUTER ASSIGNMENT</header>

    <a id="upload" href="upload.php">UPLOAD NEW PROGRAM</a>
    <?php
$dir = "./uploads/";

$onlyStatFiles = array();

// Open a directory, and read its contents
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
    	while (($file = readdir($dh)) !== false) {
      		if($file[0]!=='.') {
      			if(explode("-",$file)[2]==='stat') {
        			array_push($onlyStatFiles, $file);
    			}
			}
		}
	closedir($dh);
	}
}

/*Sorting according to program's name*/
uasort($onlyStatFiles, function ($a, $b) {
	$prog0 = explode("-",$a)[1];
	$prog1 = explode("-",$b)[1];

	return strcasecmp($prog0, $prog1);
});

        foreach ($onlyStatFiles as $file) {
        	$uploader=explode("-",$file)[0];
        $prog=explode("-",$file)[1];
       	$myfile = fopen($dir.$file, "r") or die("Unable to open file!");
        $stat =fread($myfile,filesize($dir.$file));
        fclose($myfile);
        //$stat=readfile($dir.$file); 
        
        echo '<form action="upload.php" method="post">';
        echo '<div>';

        if($stat[0]=="9")
        echo '<span>Q</span>';
        else
        echo '<span style="background-color:greenyellow;color:red;">Q</span>';
        if($stat[1]=="9")
        echo '<span>A</span>';
        else
        echo '<span style="background-color:greenyellow;color:red;">A</span>';
        if($stat[2]=="9")
        echo '<span>O</span>';
        else
        echo '<span style="background-color:greenyellow;color:red;">O</span>';

        echo '</div>';

        echo '<input style="display:none" name="file" type="text" value="'.$uploader.'-'.$prog.'">';
        echo '<input type="submit" value="'.$prog.'">';
        echo '<label for="">'.$uploader.'</label>';
        echo '</form>';
      // 
      // //echo "filename:" . $file . "<br>";
      
      //   echo '<form action="lastupload.php"method="post">';
      //   echo '<label>'.$name.'</label>';
      // if(file_exists($dir.'Q-'.$file))
      // echo '<a href="'.$dir.'Q-'.$file.'">Q</a>';
      // else
      // {
      //   echo '
      //   <input style="display:none" name="name" type="text" value="Q-'.$name.'">
      //   <input type="submit" value="Q" style="background-color:greenyellow;color:red;">';
      // }
      // if(file_exists($dir.'A-'.$file))
      // echo '<a href="'.$dir.'A-'.$file.'">A</a>';
      // else
      // {
      //   echo '
      //   <input style="display:none" name="name" type="text" value="A-'.$name.'">
      //   <input type="submit" value="A" style="background-color:greenyellow;color:red;">';
      // }
      // echo '</form>'
}
?>
    </body>
</html>