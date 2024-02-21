<?php
include_once "db.php";
if (isset($_GET['id'])) {
    $file = find('files', $_GET['id']);
} else {
    exit();
}
/**
 * 1.建立表單
 * 2.建立處理檔案程式
 * 3.搬移檔案
 * 4.顯示檔案列表
 */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>編輯檔案</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <h1 class="header">編輯檔案</h1>
    <!----建立你的表單及設定編碼----->
    <div class="container">
        <div class="text-center"><a href="./manage.php">回列表</a></div>
        <form action="./api/edit_file.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td>媒體</td>
                    <td>
                        <?php
                        switch ($file['type']) {
                            case "image/jpeg":
                            case "image/jpg":
                            case "image/gif":
                            case "image/bmp":
                            case "image/png":
                                $imgname = "./imgs/" . $file['name'];
                                break;
                            case "msword":
                                $imgname = "./icon/msword.png";
                                break;
                            case "msexcel":
                                $imgname = "./icon/msexcel.png";
                                break;
                            case "msppt":
                                $imgname = "./icon/msppt.png";
                                break;
                            case "pdf":
                                $imgname = "./icon/mspdf.png";
                                break;
                            default:
                                $imgname = "./icon/other.png";
                        }
                        ?>
                        <img class="thums" src="<?= $imgname; ?>" alt=""><br>
                        <input type="file" name="img" id="">
                    </td>
                </tr>
                <tr>
                    <td>檔名</td>
                    <td><input type="text" name="name" id="" value="<?= $file['name'] ?>"></td>
                </tr>
                <tr>
                    <td>說明</td>
                    <td><textarea name="desc" id="" style="width:350px;height:200px"><?= $file['desc'] ?></textarea>
                    </td>
                </tr>
            </table>
            <div class="row text-center">
                <div class="col">
                    <input type="hidden" name="id" value="<?= $file['id'] ?>">
                    <input type="submit" value="更新">
                </div>
            </div>
        </form>
    </div>
</body>

</html>