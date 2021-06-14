<?php

// 获取json字符串, 并转换成数组
$IDJson = file_get_contents('./json/Js2Csv/id/id.json');
$IDArr = json_decode($IDJson, true)['test'];
$exportFile = './csv/Js2Csv/id/id.csv';

// $IDJson = file_get_contents('./json/Js2Csv/th/th.json');
// $IDArr = json_decode($IDJson, true)['TH'];
// $exportFile = './csv/Js2Csv/th/th.csv';

// Optimization: Use recursive: TBD
function process($arr, $filePath, $isWtihBomHeader = false)
{
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $skey => $svalue) {
                if (is_array($svalue)) {
                    foreach ($value as $sskey => $ssvalue) {
                        if (is_array($ssvalue)) {
                            foreach ($ssvalue as $ssskey => $sssvalue) {
                                if (is_array($sssvalue)) {
                                    foreach ($sssvalue as $sssskey => $ssssvalue) {
                                        if (is_array($ssssvalue)) {
                                            foreach ($ssssvalue as $ssssskey => $sssssvalue) {
                                                if (is_array($sssssvalue)) {
                                                    foreach ($sssssvalue as $sssssskey => $ssssssvalue) {
                                                        echo $sssssskey, $ssssssvalue . PHP_EOL;
                                                    }
                                                } else {
                                                    writeFile($filePath, "$key.$skey.$sskey.$ssskey.$sssskey.$ssssskey,\"$sssssvalue\"");
                                                }
                                            }
                                        } else {
                                            writeFile($filePath, "$key.$skey.$sskey.$ssskey.$sssskey,\"$ssssvalue\"");
                                        }
                                    }
                                } else {
                                    writeFile($filePath, "$key.$skey.$sskey.$ssskey,\"$sssvalue\"");
                                }
                            }
                        } else {
                            writeFile($filePath, "$key.$skey.$sskey,\"$ssvalue\"");
                        }
                    }
                } else {
                    writeFile($filePath, "$key.$skey,\"$svalue\"");
                }
            }
        } else {
            writeFile($filePath, "$key,\"$value\"");
        }
    }
}

function writeFile($filePath, $content, $isWtihBomHeader = false)
{
    $mode = file_exists($filePath) ? 'a' : 'w';
    $targetFile = fopen($filePath, $mode) or die('Unable to open file!');

    // 写入带有bom头的内容，用于正常显示简繁体中文
    if ($isWtihBomHeader) {
        $content = chr(0xEF) . chr(0xBB) . chr(0xBF) . $content;
    }

    fwrite($targetFile, $content . "\n");
    fclose($targetFile);
    echo "Successful Write: $content" . PHP_EOL;
}

process($IDArr, $exportFile);
// process($IDArr, $exportFile, true);
