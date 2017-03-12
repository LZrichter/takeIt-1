<?php
class Database extends PDO{
    
    public function __construct(){
    	$this->conf = new Config;

        $this->engine   = $this->conf->database["engine"];
        $this->host     = $this->conf->database["host"];
        $this->user     = $this->conf->database["user"];
        $this->database = $this->conf->database["database"];
        $this->pass     = self::getdbpass(); 

        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host; 
        
        try{
        	parent::__construct($dns, $this->user, $this->pass); 
        }catch(PDOException $e){
        	die("Unable to connect: ".$e->getMessage());	
        }
    }

	//Return the db password without the encoding
	private function getdbpass(){
		return $this->conf->database["password"];
	}
}
?>