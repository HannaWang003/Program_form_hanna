<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'kaiu');
$dompdf = new Dompdf($options);

include_once "db_export.php";
if (!empty($_POST)) {
    // echo "您希望匯出";
    // print_r($_POST['select']);
    // echo "這些資料";
    $rows = all("coa_opendata", " where `farm_name` in ('" . join("','", $_POST['select']) . "')");
    // $filename = date("Ymd") . rand(100000000, 999999999);
    $filename = date("Ymd") . rand(100000000, 999999999) . ".pdf";
    // $file = fopen("./doc/{$filename}.csv", "w+");
    //important
    // fwrite($file, "\xEF\xBB\xBF");
    $html = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Document</title>
    </head>
    <body>";
    $html .= "<img src='./icon/logo.jpg'>
    <table>";
    $chk = false;
    foreach ($rows as $row) {
        if (!$chk) {
            $cols = array_keys($row);
            $html .= "<tr>";
            foreach ($cols as $col) {
                $html .= "<td>";
                $html .= $col;
                $html .= "</td>";
            }
            $html .= "</tr>";
            $chk = true;
        }
        $html .= "<tr>";
        foreach ($row as $r) {
            $html .= "<td>";
            $html .= $r;
            $html .= "</td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table></body>
    </html>";

    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream("./doc/{$filename}", array('Attachment' => 0));
    $dompdf->setPaper('A4', 'portrait');
    file_put_contents("./doc/{$filename}", $dompdf->output());

    fclose($file);

    echo "<a href='./doc/{$filename}' download>檔案已匯出，請點此連結下載</a>";
}
?>
<style>
    table {
        margin-top: 10px;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #333;
        padding: 5px 12px;
    }

    th {
        background: #666;
        color: #fff;
    }
</style>
<script src="./jquery-1.9.1.min.js"></script>
<form action="?" method="post">
    <input type="submit" value="匯出選擇的資料">
    <table>
        <tr>
            <th><input type="checkbox" id="select">city</th>
            <th>farm_name</th>
            <th>job_name</th>
            <th>demand_num</th>
            <th>leave_num</th>
            <th>manager</th>
            <th>unit_addre</th>
            <th>dining_off</th>
            <th>dorm_offer</th>
            <th>on_work</th>
            <th>job_intro</th>
            <th>conditions</th>
            <th>address</th>
            <th>workfare</th>
            <th>service</th>
        </tr>
        <?php
        $rows = all('coa_opendata');
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $key => $val) {
                echo "<td>";
                if ($key == "city") {
                    echo "<input type='checkbox' name='select[]' value='{$row['farm_name']}'>";
                }
                echo $val;
                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</form>
<script>
    $('#select').on("change", function() {
        if ($(this).prop('checked')) {
            $("input[name='select[]']").prop('checked', true);
        } else {
            $("input[name='select[]']").prop('checked', false);
        }
    })
</script>