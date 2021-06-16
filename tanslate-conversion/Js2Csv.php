<?php

require_once './WriteFile.php';

class Js2Csv
{
    private $jsonStr;
    private $jsonArr;
    private $writeFileInstance = null;

    public function __construct($importFile = './json/Js2Csv/id/id.json', $exportFile = './csv/Js2Csv/id/id.csv', $withBomHeader = false)
    {
        $this->jsonStr = file_get_contents($importFile);
        $this->jsonArr = json_decode($this->jsonStr, true);
        $this->writeFileInstance = new WriteFile($exportFile, $withBomHeader);
    }

    // It's a stupid way
    private function process(array $arr)
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
                                                        $this->writeFileInstance->write("$key.$skey.$sskey.$ssskey.$sssskey.$ssssskey,\"$sssssvalue\"", $this->withBomHeader);
                                                    }
                                                }
                                            } else {
                                                $this->writeFileInstance->write("$key.$skey.$sskey.$ssskey.$sssskey,\"$ssssvalue\"", $this->withBomHeader);
                                            }
                                        }
                                    } else {
                                        $this->writeFileInstance->write("$key.$skey.$sskey.$ssskey,\"$sssvalue\"", $this->withBomHeader);
                                    }
                                }
                            } else {
                                $this->writeFileInstance->write("$key.$skey.$sskey,\"$ssvalue\"", $this->withBomHeader);
                            }
                        }
                    } else {
                        $this->writeFileInstance->write("$key.$skey,\"$svalue\"", $this->withBomHeader);
                    }
                }
            } else {
                $this->writeFileInstance->write("$key,\"$value\"", $this->withBomHeader);
            }
        }
    }

    // Entrance of run
    public function run()
    {
        // Get first element
        $data = reset($this->jsonArr);
        $this->process($data);
    }
}

// ID
$importFile = './json/Js2Csv/id/id.json';
$exportFile = './csv/Js2Csv/id/id.csv';

// TH
// $importFile = './json/Js2Csv/th/th.json';
// $exportFile = './csv/Js2Csv/th/th.csv';

$Js2Csv = new Js2Csv($importFile, $exportFile);
// $Js2Csv = new Js2Csv($importFile, $exportFile, true);
$Js2Csv->run();
