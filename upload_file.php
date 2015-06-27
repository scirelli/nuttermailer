<?php 
require("./CAttachment.php");
require("./CEmail.php");
?>
<?php
$errorOut     = '';
$output       = '';
$fileUploadLocation = "upload/";
$maxfileSize  = 3720000;//bytes is 3mbs
$emailTo      = 'Steve Cirelli <scirelli@gmail.com>';
$emailFrom    = 'Web Admin <scirelli@jerinaw.org>';
$emailReplyTo = $_POST['ffName'].' <'.$_POST['ffFrom'].'>';
$cc           = 'stephencirelli@yahoo.com';
$bcc          = 'mpnutter@gmail.com';
$emailSub     = 'Image upload!';
$emailMsg     = $_POST['ffMessage'];
$email        = new CEmail($emailFrom, $emailTo, $emailSub, $emailMsg, null, $cc, $bcc); 

//var_dump( $_FILES );    
foreach($_FILES as $file){
    if( ($file["type"] == "image/jpeg" 
         || $file["type"] == "image/gif" 
         || $file["type"] == "image/bmp") 
         && ($file["size"] < $maxfileSize) ) {

        if ($file["error"] > 0) {
            $errorOut .= "Return Code: " . $file["error"] . "<br />";
        } else {
            $output .= "Uploaded: " . $file["name"] . "<br />";
            $output .= "Type: " . $file["type"] . "<br />";
            $output .= "Size: " . ($file["size"] / 1024) . " Kb<br />";
            $output .= "Temp file: " . $file["tmp_name"] . "<br />";
            
            if (file_exists($fileUploadLocation . $file["name"])) {
                $output .= $file["name"] . " already exists. ";
                $rnd = md5(time());
                $output .= 'Renaming the file to: ' . $rnd . '_' . $file["name"] . '<br/><br/>';
                $file["name"] = $rnd . '_' . $file["name"];
            } 

            move_uploaded_file($file["tmp_name"], $fileUploadLocation . $file["name"]);
            $output .= "File now stored in: " . $fileUploadLocation . $file["name"];
            //Attach the file
            $email->addAttachment(new CAttachment($fileUploadLocation . $file["name"],$file["name"], $email->getBoundary()));
        }
    } else {//Error with file size or type
        $errorOut = "Invalid file type or size.
              <br/><br/>
              Files must be of type:<br/>
              <ul>
                    <li>jpe,jpg,jpeg</li>
                    <li>bmp</li>
                    <li>gif</li>
              </ul>
              <br/><br/>
              File size may not be greater than " . ($maxfileSize/1024) . " Kb" 
              . "<br/><br/>Your file type is '" . $file["type"] . "' and has a size of '" . ($file["size"]/1024) . "' Kb";
    }
}

//Handle emails 
$email->send();
?>
<!-- ====================== Presentation ============================= -->
<html>
	<head>
		<title>Upload Results</title>
	</head>
    <body>
        <p>
            <?php echo $errorOut; ?>
        </p>
        <p>
            <?php echo $output; ?>
        </p>
	</body>
</html>
