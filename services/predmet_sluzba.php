<?php

class predmetSluzba {
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

    function vlozPredmet($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute($data);
            echo "Data input successful";
        }
        catch (PDOException $e) {
            echo "Data input failed:" . $e->getMessage();
        }
    }
    
    function ziskejZkratky() {
        try {
            $stmt = $this->pdo->prepare("SELECT zkratka from Predmet");
            $stmt->execute();
            $zkratky = "";
            while ($row = $stmt->fetch()) {
                $tmp = $row["zkratka"];
                if ($zkratky == "") {
                    $zkratky = $tmp;
                }
                else {
                    $zkratky = $zkratky . ", $tmp";
                }
            }
            return $zkratky;
        }
        catch (PDOException $e) {
            return "Data input not successful";
        }
    }
}