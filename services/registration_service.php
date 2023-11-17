<?php

class registrationService
{
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
        } catch (PDOException $e) {
            error_log("Chyba při navazování spojení s databází: " . $e->getMessage());
        }
    }

    function retrieveRegistered($user) {
        try {
            $stmt = $this->pdo->prepare('SELECT zkratka FROM Osoba_predmet WHERE ID_Osoba = ?');
            $stmt->execute(array($user));
            $subjectArray = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subjectArray[] = $row['zkratka'];
            }
            return $subjectArray;
        }
        catch (PDOException $e) {
            error_log("Nepodarilo se najit predmety uzivatele: " . $e->getMessage());
            return null;
        }
    }

    function newlyRegistered($array) {
        $registeredArray = array();
        foreach ($array as $subject) {
            $registeredArray[] = $subject;
        }
        return $registeredArray;
    }

    function unregisterSubject($old, $new) {
        $stmt = $this->pdo->prepare('DELETE FROM Osoba_predmet WHERE ID_Osoba = ? AND zkratka = ?');
        foreach ($old as $key => $subject) {
            if (!in_array($subject, $new)) {
                $stmt->execute(array($_SESSION['user_id'], $subject));
                unset($old[$key]);
            }
        }
        return $old;
    }

    function registerNewSubject($old, $new) {
        $stmt = $this->pdo->prepare('INSERT INTO Osoba_predmet (ID_Osoba, zkratka) VALUES (?, ?)');
        foreach ($new as $subject) {
            if (!in_array($subject, $old)) {
                $stmt->execute(array($_SESSION['user_id'], $subject));
                $old[] = $subject;
            }
        }
        return $old;
    }
}