<?php

class activityService{

    private PDO $pdo;
    function __construct()
    {
        try {
            $connString = "mysql:host=db;dbname=mydatabase";
            $userName = "myuser";
            $password = "mypassword";
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
            );
            $this->pdo = new PDO($connString, $userName, $password, $options);
        }
        catch (PDOException $e) {
            error_log("Chyba při navazování spojení s databází: " . $e->getMessage());
        }
    }

    function insertNewActivity($data){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Vyuk_aktivita(typ, delka, popis, opakovani, mistnost, predmet) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
            return "Activity successfully added";
        }
        catch (PDOException $e) {
            error_log("Data input failed:" . $e->getMessage());
            if(strpos($e->getMessage(), 'mistnost') !== false){
                return "Activity input failed - neznama mistnost: " . $e->getMessage();
            }
            elseif(strpos($e->getMessage(), 'predmet') !== false){
                return "Activity input failed - neznamy predmet: " . $e->getMessage();
            }
            else{
                return "Activity input failed: " . $e->getMessage();
            }
        }
    }
}