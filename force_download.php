<?php
if(isset($_POST['file_name'])){
    $file = $_POST['file_name'];
    header('Content-type: image/png');
    header('Content-Disposition: attachment; filename="'.$file.'"');
    readfile('qr_img/'.$file);
    exit();
}
?>