<?php
require_once "../misc/db_conn_parameters.php";

class subjectService {
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

    function insertNewSubject($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute($data);
            return "Subject successfully added.";
        }
        catch (PDOException $e) {
            error_log("Subject insert failed:" . $e->getMessage());
            return "Subject insert failed: " . $e->getMessage();
        }
    }

    function updateSubject($data) {
        try {
            $stmt = $this->pdo->prepare("UPDATE Predmet SET nazev = ?, anotace = ?, pocet_kreditu = ?, typ_ukonceni = ? WHERE zkratka = ?");
            $stmt->execute($data);
            return "Subject successfully edited.";
        }
        catch (PDOException $e) {
            error_log("Subject update failed:" . $e->getMessage());
            return "Subject update failed: " . $e->getMessage();
        }
    }
    
    function getSubjectIDs() {
        try {
            $stmt = $this->pdo->prepare("SELECT zkratka FROM Predmet");
            $stmt->execute();
            $subjectArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subjectArray[] = $row['zkratka'];
            }
            return $subjectArray;
        }
        catch (PDOException $e) {
            return "Data input not successful: " . $e->getMessage();
        }
    }

    function getSubjectInfo($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Predmet WHERE zkratka = (?)");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Data input not successful");
            return null;
        }
    }

    function deleteSubject($id): string {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM Osoba_predmet WHERE zkratka = ?");
            $stmt->execute(array($id));

            $stmt = $this->pdo->prepare("DELETE FROM Vyuk_aktivita WHERE predmet = ?");
            $stmt->execute(array($id));

            $stmt = $this->pdo->prepare("DELETE FROM Predmet WHERE zkratka = ?");
            $stmt->execute(array($id));

            $this->pdo->commit();

            return "Subject successfully deleted from Predmet, Osoba_predmet and Vyuk_aktivita table.";
        }
        catch (PDOException $e) {
            $this->pdo->rollBack();

            error_log("Subject removal not successful: " . $e->getMessage());
            return "Subject delete failed: " . $e->getMessage();
        }
    }
}