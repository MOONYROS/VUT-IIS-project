<?php

class roomService{

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

    function insertNewRoom($data){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute($data);
            echo "Data input successful";
        }
        catch (PDOException $e) {
            echo "Data input failed:" . $e->getMessage();
        }
    }
}