<?php
echo $_POST['test'];
if(!empty($_FILES['img']['tmp_name'])){
    $tmp=explode(".",$_FILES['img']['tmp_name']);
    $subname=".".end($tmp);
    $filename=date("Ymd").rand(10000,99999).$subname;
    move_uploaded_file($_FILES['img']['tmp_name'],"../imgs/".$filename);
    header("location:../upload.php?img=$filename");
}
else{
    header("location:../upload.php?error=檔案上傳失敗");
}
?>