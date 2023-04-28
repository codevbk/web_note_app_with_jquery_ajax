<?php
class FileHandler{
    private $handle;
    private $fileName;
    private $fileSize;
    private $chunkMaxCount = 512;
    private $chunkCount = 1;
    private $chunkSize = 1024;
    private $chunk = 1024;
    private $data = "";

    public function __construct() {
    }

    public function __destruct() {
        self::destroy($this->handle);
        self::destroy($this->fileName);
        self::destroy($this->fileSize);
        self::destroy($this->chunkMaxCount);
        self::destroy($this->chunkCount);
        self::destroy($this->chunkSize);
        self::destroy($this->chunk);
        self::destroy($this->data);
    }

    public function open($fileName) {
        $this->fileName = $fileName;
    }

    public function close() {
        fclose($this->handle);
    }

    public function delete() {
        if(file_exists($this->fileName)){
            unlink($this->fileName);
        }
    }

    public function read() {
        $this->handle = fopen($this->fileName, "rb");
        $this->getChunks();
        while (true) {
            $dat = fread($this->handle, $this->chunk);
            $this->data .= $dat;
            if ($dat == "") {
                break;
            }
        }
        return $this->data;
    }

    public function write($data) {
        $this->handle = fopen($this->fileName, "wb");
        $buffer = 1024;
        $pos = 0;
        $buff = "";
        while (true) {
            $dat = substr($data, $pos, $this->chunk);
            $buff .= $dat;
            fwrite($this->handle, $dat);
            $pos += $this->chunk;
            if ($dat == false ) {
                break;
            }
        }
        //return $this->data;
    }

    private function getChunks() {
        fseek($this->handle, 0, SEEK_END);
        $this->fileSize = ftell($this->handle);
        fseek($this->handle, 0);
        $this->chunkCount = floor($this->fileSize / $this->chunkSize);
        $tempChuckCount = floor($this->chunkCount / $this->chunkMaxCount);
        $this->chunkCount = ($tempChuckCount < 2 ? 1 : $tempChuckCount);
        $this->chunk = $this->chunkCount * $this->chunkSize;
        return "-".$this->chunkCount;
    }

    protected function destroy($var){
        unset($var);
        $var = null;
    }

}
?>