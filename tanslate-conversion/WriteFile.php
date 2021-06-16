<?php

class WriteFile
{
    protected $wtihBomHeader = false;
    protected $targetFile;

    public function __construct($targetFile, $wtihBomHeader = false)
    {
        if (empty($targetFile)) throw new Exception('Target file does not be empty!');
        if ($wtihBomHeader) $this->wtihBomHeader = $wtihBomHeader;
        if ($targetFile) $this->targetFile = $targetFile;
    }

    public function write($content)
    {
        $mode = file_exists($this->targetFile) ? 'a' : 'w';
        $handle = fopen($this->targetFile, $mode) or die('Unable to open file!');

        // 写入带有bom头的内容，用于正常显示简繁体中文
        if ($this->wtihBomHeader) {
            $content = chr(0xEF) . chr(0xBB) . chr(0xBF) . $content;
        }

        fwrite($handle, $content . "\n");
        fclose($handle);
        print "Successful Write: $content" . PHP_EOL;
    }
}
