<?php 
    if(isset($_POST['canvasdata'])){
        $img = $_POST['canvasdata'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = '../../drawings/'.$_POST['filename'];
        $success = file_put_contents($file, $data);
    }
?>