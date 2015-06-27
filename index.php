<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//WC3//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <title>Nutter Mail</title>
        <meta name="description" content="" />
        <meta name="keywords" content="images,photogallery,photos" />
        <link REL="SHORTCUT ICON" HREF="http://jerinaw.org/favicon.ico">

        <!-- ------------ Javascript ------------ -->
        <script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
        <script type="text/javascript" src="js/extras-location.js""></script>
        <script type="text/javascript">
            //Name space
            var cirelli = new Object();
            window.location.searchObj =  searchtoObj();
            cirelli.fileCount = 0;

            $(document).ready(function(){
                if( window.location.searchObj.multifile ){
                    var addButton = $('<input type="button" id="ffAdd" name="ffAdd" value="+" />');
                    $('#submitCont').append(addButton);
                    addButton.click( addNewFile );
                }
                $('#fFileUpload').submit( validateForm );
            });

            function addNewFile(){
                var fileListCont = $('div#listOfFiles');
                var subBtn,elemStr;

                cirelli.fileCount++;
                //We're gonig to add a new child the cheesy way
                elemStr = '<div id="cont_File_' + cirelli.fileCount + '">' + 
                              '<label for="file_' + cirelli.fileCount + '">Filename:</label>' +
                              '<input type="file" name="file_' + cirelli.fileCount + '" id="file_' + cirelli.fileCount + '" accept="image/bmp,image/cis-cod,image/gif,image/ief,image/jpeg,image/pipeg,image/pjpeg,image/png,image/svg+xml,image/tiff,image/x-cmu-raster,image/x-cmx,image/x-icon,image/x-png,image/x-portable-anymap,image/x-portable-bitmap,image/x-portable-graymap,image/x-portable-pixmap,image/x-rgb,image/x-xbitmap,image/x-xpixmap,image/x-xwindowdump" /> </div>';
                fileListCont.append( elemStr );
                subBtn = $('<input type="button" id="ffSub_'+ cirelli.fileCount +'" name="ffSub_'+ cirelli.fileCount +'" value="-" />');
                $('#cont_File_'+cirelli.fileCount).append(subBtn );
                subBtn .click( removeFile );
            }

            function removeFile( eventObj ){
                //cirelli.fileCount--;//this is not needed
                //alert($(this).parent().attr('id'));
                $(this).parent().remove();
            }

            function validateForm(){
                var emailPattern = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
                var reg = new RegExp( emailPattern );

                if( $('#ffName').val() == null || $('#ffName').val().length <= 0 ){
                    alert('Name must be entered!');
                    $('#ffName').focus();
                    return false;
                }

                if( $('#ffFrom').val() == null || $('#ffFrom').val().length <= 0 ){
                    alert('Email must be filled in!');
                    $('#ffFrom').focus();
                    return false;
                }
                if( reg.test( $('#ffFrom').val() ) == false ){
                    alert('Please enter a valid email address!');
                    $('#ffFrom').focus();
                    return false;
                }
                if( $('#file_0').val() == null || $('#file_0').val().length <= 0 ){
                    alert('You must have at least one file attached!');
                    $('#file_0').focus();
                    return false;
                }
                return true;
            }
        </script>
        <!-- ------------------------------------ -->

        <!-- ------------ CSS Styles ------------ -->
        <!-- <link rel="stylesheet" type="text/css" href="mystyle.css" media="screen" />-->
		<style type="text/css">
            fieldset
            {
                width:30%;
            }
        </style>
        <!--[if IE ]>
        <link rel="stylesheet" href="" type="text/css" media="screen"/>
        <style type="text/css">
        </style>
        <![endif]-->
        <!-- ------------------------------------ -->

    </head>

    <body>
        <div id="mainContentContainerDiv">
            <div id="mainTopContentDiv" class="roundedBorder">
            </div>
            <div>
                <div id="mainLeftContentDiv" class="roundedBorder">
                    <div>
                    </div>
                </div>
                <div id="mainCenterContentDiv" class="roundedBorder">
                    <form id="fFileUpload" name="fFileUpload" action="upload_file.php" method="post" enctype="multipart/form-data">
                        <div id="emailCont">
                            <fieldset>
                                <div>
                                    <label for="ffName">Name:</label>
                                    <input type="text" name="ffName" id="ffName" value=""/> 
                                </div>
                                <div>
                                    <label for="ffFrom">Email:</label>
                                    <input type="text" name="ffFrom" id="ffFrom" value=""/> 
                                </div>
                                <div>
                                    <label for="ffMessage">Message:</label>
                                    <textarea id="ffMessage" name="ffMessage" rows="7" cols="28"></textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div>
                            <fieldset>
                                <div>
                                    Files should be of type:
                                    <ul>
                                        <li>jpe,jpg,jpeg</li>
                                        <li>bmp</li>
                                        <li>gif</li>
                                    </ul>
                                </div>
                            </fieldset>
                    
                            <fieldset>
                                <div id="listOfFiles">
                                    <div id="cont_File_0">
                                        <label for="file_0">Filename:</label>
                                        <input type="file" name="file_0" id="file_0" accept="image/bmp,image/cis-cod,image/gif,image/ief,image/jpeg,image/pipeg,image/pjpeg,image/png,image/svg+xml,image/tiff,image/x-cmu-raster,image/x-cmx,image/x-icon,image/x-png,image/x-portable-anymap,image/x-portable-bitmap,image/x-portable-graymap,image/x-portable-pixmap,image/x-rgb,image/x-xbitmap,image/x-xpixmap,image/x-xwindowdump" /> 
                                    </div>
                                </div>
                                <div id="submitCont">
                                    <input type="submit" id="ffSubmit" name="ffSsubmit" value="Submit" />
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
            <!--<div id="mainRightContentDiv" class="roundedBorder">Right Content Div&nbsp;</div>-->
            <div id="mainBottomContentDiv" class="roundedBorder">
            </div>
       </div> 
    </body>
</html>
