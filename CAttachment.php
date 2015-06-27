<?php
class CAttachment{
    private $message;
    const EOL = PHP_EOL;

    function __construct($file, $fileName, $mime_boundary ){
        $this->generateAttachString( $file, $fileName, $mime_boundary);
    }

    public function getAttachmentStr(){
        return $this->message;
    }

    private function generateAttachString( $file, $fileName, $mime_boundary ) {
        // multipart boundary 
        $this->message = "--{$mime_boundary}". self::EOL;
         
        // preparing attachments
        $hfile = fopen($file,"rb");
        $data = fread($hfile,filesize($file));
        fclose($hfile);
        $data = chunk_split(base64_encode($data));
        $this->message .= "Content-Type: {\"application/octet-stream\"};" . self::EOL 
                        . " name=\"$fileName\"" . self::EOL 
                        . "Content-Disposition: attachment;" . self::EOL
                        . " filename=\"$fileName\"" . self::EOL
                        . "Content-Transfer-Encoding: base64" . self::EOL . self::EOL
                        . $data . self::EOL . self::EOL;
    }
}

/*
$fileatt = “./test.pdf”;

$fileatttype = “application/pdf”;

$fileattname = “newname.pdf”;
 */
?>
