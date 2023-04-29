<?php
class NoteModel {
	
	private $fileHandler;
	
	public function __construct() {
        $this->fileHandler = new FileHandler();
    }
	
    public function create($data) {
		$jsonData = json_decode($data,true);
		$fileLocation = DOCUMENT_ROOT."/data/".$jsonData["id"].".json";
		$this->fileHandler->open($fileLocation);
		$this->fileHandler->write($data);
		$this->fileHandler->close();
    }

    public function read() {
        $filesNotes = glob(DOCUMENT_ROOT."/data/*");
		$noteArr = array();
		if(isset($filesNotes) && !empty($filesNotes) && count($filesNotes) > 0){
			foreach($filesNotes as $fileNote){
				$fileLocation = $fileNote;
				$this->fileHandler->open($fileLocation);
				$noteArr[] = $this->fileHandler->read($fileLocation);
				$this->fileHandler->close();
			}
		}
		return json_encode($noteArr);
    }

    public function update($data) {
		$jsonData = json_decode($data,true);
		//$this->delete($data); maybe fix problem of write permission
		$fileLocation = DOCUMENT_ROOT."/data/".$jsonData["id"].".json";
		$this->fileHandler->open($fileLocation);
		$this->fileHandler->write($data);
		$this->fileHandler->close();
    }

    public function delete($data) {
		$jsonData = json_decode($data,true);
		$fileLocation = DOCUMENT_ROOT."/data/".$jsonData["id"].".json";
		if(file_exists($fileLocation)){
			$this->fileHandler->open($fileLocation);
			$this->fileHandler->delete();
		}
    }

    public function clear() {
		$filesNotes = glob(DOCUMENT_ROOT."/data/*");
		$noteArr = array();
		if(isset($filesNotes) && !empty($filesNotes) && count($filesNotes) > 0){
			foreach($filesNotes as $fileNote){
				$fileLocation = $fileNote;
				if(file_exists($fileLocation)){
					$this->fileHandler->open($fileLocation);
					$this->fileHandler->delete();
				}
			}
		}
    }
}
?>