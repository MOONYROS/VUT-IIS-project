<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

class activityService {

    private PDO $pdo;
    function __construct()
    {
        try {
            $params = getDbConnectionParams();
            $this->pdo = new PDO($params["connString"], $params["userName"], $params["password"], $params["options"]);
        }
        catch (PDOException $e) {
            error_log("Chyba při navazování spojení s databází: " . $e->getMessage());
        }
    }

    function insertNewActivity($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Vyuk_aktivita(typ, delka, popis, opakovani, pozadavek, predmet) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
            return "Activity successfully added";
        }
        catch (PDOException $e) {
            error_log("Data input failed:" . $e->getMessage());
            if (str_contains($e->getMessage(), 'mistnost')) {
                return "Activity input failed - neznama mistnost: " . $e->getMessage();
            }
            elseif (str_contains($e->getMessage(), 'predmet')) {
                return "Activity input failed - neznamy predmet: " . $e->getMessage();
            }
            else {
                return "Activity input failed: " . $e->getMessage();
            }
        }
    }

    function updateActivity($data){
        try {
            $stmt = $this->pdo->prepare("UPDATE Vyuk_aktivita SET  typ = ?, delka = ?, popis = ?, opakovani = ?, pozadavek = ?, predmet = ? WHERE ID_Aktiv = ?");
            $stmt->execute($data);
            return "Activity info successfully updated";
        }
        catch (PDOException $e) {
            error_log("Activity update failed:" . $e->getMessage());
            if(strpos($e->getMessage(), 'mistnost') !== false){
                return "Activity update failed - neznama mistnost: " . $e->getMessage();
            }
            elseif(strpos($e->getMessage(), 'predmet') !== false){
                return "Activity update failed - neznamy predmet: " . $e->getMessage();
            }
            else{
                return "Activity update failed: " . $e->getMessage();
            }
        }
    }

    function scheduleActivity($data) {
        try {
            $stmt = $this->pdo->prepare("UPDATE Vyuk_aktivita SET mistnost = ?, den = ?, start = ? WHERE ID_Aktiv = ?");
            $stmt->execute($data);
            return "Activity info successfully updated";
        }
        catch (PDOException $e) {
            error_log("Activity not found: " . $e->getMessage());
            return null;
        }
    }

    function getActivityIDs($zkratka){
        try {
            $stmt = $this->pdo->prepare("SELECT ID_Aktiv FROM Vyuk_aktivita WHERE predmet = ?");
            $stmt->execute(array($zkratka));
            $subjectArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subjectArray[] = $row['ID_Aktiv'];
            }
            return $subjectArray;
        }
        catch (PDOException $e) {
            error_log("Activity not found: " . $e->getMessage());
            return null;
        }
    }

    function getActivityInfo($id){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Vyuk_aktivita WHERE ID_Aktiv = (?)");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Data input not successful");
            return null;
        }
    }

    function deleteActivity($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE from Vyuk_aktivita where ID_Aktiv = ?");
            $stmt->execute(array($id));
            return "Activity successfully deleted.";
        }
        catch (PDOException $e) {
            error_log("Activity removal not successful:" . $e->getMessage());
            return "Activity removal not successfull: " . $e->getMessage();
        }
    }

    function getGarantedActivities($zkratka) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Vyuk_aktivita WHERE predmet = ?");
            $stmt->execute(array($zkratka));
            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
            error_log("Activity removal not successful:" . $e->getMessage());
            return "Activity removal not successfull: " . $e->getMessage();
        }
    }

    function getAllActivities() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Vyuk_aktivita");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
            error_log("Could not load activities: " . $e->getMessage());
            return "Could not load activities:  " . $e->getMessage();
        }
    }

    function getRoomDayActivity($room, $day) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Vyuk_aktivita WHERE mistnost = ? AND den = ?");
            $stmt->execute(array($room, $day));
            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
            error_log("Could not load specific activities: " . $e->getMessage());
            return "Could not load specific activities:  " . $e->getMessage();
        }
    }

    function getUserActivities($userId) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT den, predmet, typ, start, delka, mistnost
                FROM Vyuk_aktivita WHERE predmet IN 
                (SELECT zkratka FROM Osoba_predmet WHERE ID_Osoba = ?)
                AND start IS NOT NULL 
                AND mistnost IS NOT NULL;"
            );
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not load activities: " . $e->getMessage());
            return "Could not load activities:  " . $e->getMessage();
        }
    }

    function getUserActivitiesDay($userId, $day) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT den, predmet, typ, start, delka, mistnost
                FROM Vyuk_aktivita WHERE predmet IN 
                (SELECT zkratka FROM Osoba_predmet WHERE ID_Osoba = ? AND den = ?);"
            );
            $stmt->execute([$userId, $day]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not load activities: " . $e->getMessage());
            return "Could not load activities:  " . $e->getMessage();
        }
    }
}