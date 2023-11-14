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
            return "Room successfully added";
        }
        catch (PDOException $e) {
            error_log("Data input failed:" . $e->getMessage());
            return "Room insert failed: " . $e->getMessage();
        }
    }

    function updateRoom($data){
        try {
            $stmt = $this->pdo->prepare("UPDATE Mistnost SET kapacita = ?, typ = ?, popis = ?, umisteni = ? WHERE ID_mist = ?");
            $stmt->execute($data);
            return "Room info successfully updated";
        }
        catch (PDOException $e) {
            error_log("Room update failed:" . $e->getMessage());
            return "Room update failed:" . $e->getMessage();
        }
    }

    function getRoomIDs(){
        try {
            $stmt = $this->pdo->prepare("SELECT ID_mist FROM Mistnost");
            $stmt->execute();
            $subjectArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subjectArray[] = $row['ID_mist'];
            }
            return $subjectArray;
        }
        catch (PDOException $e) {
            error_log("Room not found: " . $e->getMessage());
        }
    }

    function getRoomInfo($id){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Mistnost WHERE ID_mist = (?)");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Data input not successful");
            return null;
        }
    }

    function deleteRoom($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE from Mistnost where ID_mist = ?");
            $stmt->execute(array($id));
            return "Room successfully deleted.";
        }
        catch (PDOException $e) {
            error_log("Room removal not successful:" . $e->getMessage());
            return "Room removal not successfull: " . $e->getMessage();
        }
    }
}