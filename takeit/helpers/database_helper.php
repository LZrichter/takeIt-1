<?php
class Database extends PDO{
    
    public function __construct(){
        $this->engine   = DB_ENGINE;
        $this->host     = DB_HOST;
        $this->user     = DB_USER;
        $this->database = DB_DATABASE;
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
		return DB_PASSWORD;
	}
}
?>