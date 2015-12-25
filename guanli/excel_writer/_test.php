<?php
//header("content-type:text/html;charset=utf-8");
require_once 'Writer.php';

// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer('_test.xls');
$workbook->setVersion(8);

// sending HTTP headers
//$workbook->send('_test.xls');



// Creating a worksheet
$worksheet =& $workbook->addWorksheet('Test');

$worksheet->setInputEncoding('utf-8');

// The actual data
//$worksheet->write(0, 0, encoding('姓名'));
//$worksheet->write(0, 1, encoding('年龄'));
$worksheet->write(0, 0, '姓名');
$worksheet->write(0, 1, '年龄');
$worksheet->write(1, 0, '微普科技');
$worksheet->write(1, 1, 30);
$worksheet->write(2, 0, 'Johann Schmidt');
$worksheet->write(2, 1, 31);
$worksheet->write(3, 0, 'Juan Herrera');
$worksheet->write(3, 1, 32);

// Let's send the file
$workbook->close();

function encoding($str){
    //if(strpos($_SERVER("HTTP_USER_AGENT"),"Windows") !== false)
        $str = iconv("utf-8","gb2312",$str);
    return $str;
}
?> 