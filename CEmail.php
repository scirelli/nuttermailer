<?php
    require_once( "./CAttachment.php");

    class CEmail {
        const EOL = PHP_EOL;
        // Headers info 
        private $s_headers             = '';
        private $mimeVersion           = '';
        private $contentTypeNoAttach   = '';
        private $contentTypeAttachment = '';
        private $mime_boundary         = ''; 
        private $headerBoundary        = ''; 
        //mail info
        private $s_from;
        private $s_replyTo; //'Reply-To: webmaster@example.com' . "\r\n";
        private $s_to;
        private $s_cc; //'Cc: webmaster@example.com' . "\r\n";
        private $s_bcc;//'Bcc: webmaster@example.com' . "\r\n";
        private $s_subject;
        private $s_body;
        private $s_msg;
        private $a_attachArray;

        //options to send to cc+bcc 
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 

        function __construct( $s_from=null, $s_to=null, $s_subject=null, $s_body=null, $s_replyTo=null, $s_cc=null, $s_bcc=null ){
            if( $s_cc != null ) { $this->s_cc  = $s_cc;  }
            if( $s_bcc != null ){ $this->s_bcc = $s_bcc; }
            if( $s_replyTo != null ){ $this->s_replyTo = $s_replyTo; }
            $this->s_from    = $s_from;//strip_tags($s_from);
            $this->s_to      = $s_to;
            $this->s_subject = $s_subject;
            $this->s_msg     = nl2br($s_body);

            $this->mimeVersion           = "MIME-Version: 1.0" . self::EOL;
            $this->contentTypeNoAttach   = "Content-type: text/html; charset=iso-8859-1" . self::EOL;
            $this->contentTypeAttachment = "Content-Type: multipart/mixed;" . self::EOL;
            $this->a_attachArray         = array();
            $semi_rand                   = md5(time()); 
            $this->mime_boundary         = "==Multipart_Boundary_x{$semi_rand}x"; 
            $this->headerBoundary        = " boundary=\"{$this->mime_boundary}\""; 
        }

        //-------------------------------------------
        // addAttachment()
        // @Desc: allows you to add one or more
        //   attachments to this email.
        // @arg1: $attachments can either be an array
        //   of CAttachment or one CAttachment
        //-------------------------------------------
        public function addAttachment( &$attachments ){
            if( is_array($attachments) ){
                $str = '';
                foreach( $attachments as $att ){
                    if( is_object( $att ) && get_class( $att ) == 'CAttachment' ){
                        $str = $att->getAttachmentStr();
                        array_push( $this->a_attachArray, $str );
                    }
                }
            }else{
                if(is_object($attachments)){
                    if( get_class($attachments) == 'CAttachment' ){
                        $str = $attachments->getAttachmentStr();
                        array_push( $this->a_attachArray, $str );
                    }
                }
            } 
        }
        
        public function getBoundary(){
            return $this->mime_boundary;
        }

        private function generateHeaders(){
            $this->s_headers = "From: {$this->s_from}" . self::EOL;

            if( $this->s_replyTo != null ){
                $this->s_headers .= 'Reply-To: ' . $this->s_replyTo . self::EOL;
            }
            if( $this->s_cc != null ){
                $this->s_headers .= 'Cc: ' . $this->s_cc . self::EOL;
            }
            if( $this->s_bcc != null ){
                $this->s_headers .= 'Bcc: ' . $this->s_bcc . self::EOL;
            }
            //Check to see if there are any attachments
            if( current($this->a_attachArray) === false ){//No attachments
                $this->s_headers .= $this->mimeVersion . $this->contentTypeNoAttach;
            }else{//There are attachments
                $this->s_headers .= $this->mimeVersion . $this->contentTypeAttachment . $this->headerBoundary;
            }
        }

        private function generateBody(){
            if( current($this->a_attachArray) === false ){//No attachments
                $this->s_body = $this->s_msg;
            }else{//There are attachments
                $this->s_body = "This is a multi-part message in MIME format." . self::EOL . self::EOL
                                . "--{$this->mime_boundary}" . self::EOL
                                . "Content-Type: text/plain; charset=\"iso-8859-1\"" . self::EOL
                                . "Content-Transfer-Encoding: 7bit" . self::EOL . self::EOL
                                . $this->s_msg . "" . self::EOL . self::EOL; 
                //Attach the attachments
                foreach( $this->a_attachArray as $att ){
                    $this->s_body .= $att;
                }
                //Close out the multi-part message
                $this->s_body .= "-{$this->mime_boundary}-" . self::EOL;
            }
        }

        public function send(){
            $this->generateHeaders();
            $this->generateBody();
            echo '<br/><br/>';
            echo $this->s_to . '<br/><br/>'; 
            echo $this->s_subject . '<br/><br/>'; 
            echo $this->s_headers . '<br/><br/>'; 
            echo $this->s_body .'<br/><br/>';
            //Send the mail
            return mail($this->s_to, $this->s_subject, $this->s_body, $this->s_headers);
        }

        //----------------
        // STATIC METHODS
        //----------------

        //----------------------------------------------------
        // sendMail()
        // @Desc: Send a simple email no attachments
        //----------------------------------------------------
        public static function sendEmail( $s_from, $s_to, $s_subject, $s_body, $s_cc=null,$_bcc=null){
            $s_headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\n";
            
            $s_from = strip_tags($s_from);
            $s_to = strip_tags($s_to);
            if( $s_cc != null ){
                $s_cc = strip_tags($s_cc);
                $s_headers .= 'Cc: ' . $s_cc . "\n\r";
            }
            if( $s_bcc != null ){
                $s_bcc = strip_tags($s_bcc);
                $s_headers .= 'Bcc: ' . $s_bcc . "\n\r";
            }
            $s_subject = strip_tags($s_subject);
            $s_body = strip_tags( nl2br($s_body), '<br\>');

            if( mail($s_to, $s_subject, $s_body, $s_headers) )
                return 1;
            else 
                return 0;
        }
    }
?>
