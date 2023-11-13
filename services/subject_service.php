<?php

class subjectService {
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

    function insertNewSubject($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute($data);
            echo "Data input successful";
        }
        catch (PDOException $e) {
            echo "Data input failed:" . $e->getMessage();
        }
    }

    function updateSubject($data) {
        try {
            $stmt = $this->pdo->prepare("UPDATE Predmet SET nazev = ?, anotace = ?, pocet_kreditu = ?, typ_ukonceni = ? WHERE zkratka = ?");
            $stmt->execute($data);
            echo "Subject update successful!";
        }
        catch (PDOException $e) {
            echo "Subject update failed:" . $e->getMessage();
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
            return "Data input not successful";
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
}