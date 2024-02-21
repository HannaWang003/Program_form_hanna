<h2>資料夾瀏覽</h2>
<?php
$dir = "./imgs";
$files = scandir($dir);
$filestr = 'beauty';
echo "<ul>";
if (!empty($files)) {
    foreach ($files as $file) {
        if (str_contains($file, 'thumb') && is_file($dir . '/' . $file)) {
            $ext = explode('.', $file)[1];
            $filename = 'thumb_' . $filestr . sprintf('%04d', $idx + 1) . "." . $ext;
            rename($dir . "/" . $files, $dir . "/" . $filename);
            echo "<li>";
            echo "<img src='$dir/$filename'>";
            echo  "</li>";
        }
    }
}
echo "</ul>";

?>