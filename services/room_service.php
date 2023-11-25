<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

class roomService{

    private PDO $pdo;
    function __construct()
    {
        try {
            $params = getDbConnectionParams();
            $this->pdo = new PDO($params["connString"], $params["userName"], $params["password"], $params["options"]);
        }
        catch (PDOException $e) {
            error_log("Error connecting to database: " . $e->getMessage());
        }
    }

    function insertNewRoom($data){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute($data);
            return "Room successfully added";
        }
        catch (PDOException $e) {
            error_log("Room insert failed:" . $e->getMessage());
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
            return null;
        }
    }

    function getRoomInfo($id){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Mistnost WHERE ID_mist = (?)");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not get room info: " . $e->getMessage());
            return null;
        }
    }

    function deleteRoom($id) {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE from Vyuk_aktivita where mistnost = ?");
            $stmt->execute(array($id));

            $stmt = $this->pdo->prepare("DELETE from Mistnost where ID_mist = ?");
            $stmt->execute(array($id));

            $this->pdo->commit();

            return "Room successfully deleted.";
        }
        catch (PDOException $e) {
            $this->pdo->rollBack();

            error_log("Room removal unsuccessful:" . $e->getMessage());
            return "Room removal unsuccessfull: " . $e->getMessage();
        }
    }
}