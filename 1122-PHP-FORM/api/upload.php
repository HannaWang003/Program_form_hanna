<?php
include("../db.php");
if (!empty($_FILES['img']['tmp_name'])) {
    $tmp = explode(".", $_FILES['img']['tmp_name']);
    $subname = "." . end($tmp);
    $filename = date("Ymd") . rand(10000, 99999) . $subname;
    move_uploaded_file($_FILES['img']['tmp_name'], "../imgs/" . $filename);
    $file = [
        'name' => $filename,
        'type' => $_FILES['img']['type'],
        'size' => $_FILES['img']['size'],
        'desc' => $_POST['desc']
    ];
    insert('files', $file);


    header("location:../manage.php");
} else {
    header("location:../upload.php?error=檔案上傳失敗");
}
