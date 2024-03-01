<?php
include_once "db_export.php";
if (!empty($_POST)) {
    // echo "您希望匯出";
    // print_r($_POST['select']);
    // echo "這些資料";
    $rows = all("coa_opendata", " where `farm_name` in ('" . join("','", $_POST['select']) . "')");
    $filename = date("Ymd") . rand(100000000, 999999999);
    $file = fopen("./doc/{$filename}.csv", "w+");
    //important
    fwrite($file, "\xEF\xBB\xBF");
    $chk = false;
    foreach ($rows as $row) {
        if (!$chk) {
            $cols = array_keys($row);
            fwrite($file, join(",", $cols) . "\r\n");
            $chk = true;
        }
        fwrite($file, join(',', $row) . "\r\n");
    }
    fclose($file);

    echo "<a href='./doc/{$filename}.csv' download>檔案已匯出，請點此連結下載</a>";
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