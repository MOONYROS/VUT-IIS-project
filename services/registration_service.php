<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

class registrationService
{
    private PDO $pdo;

    function __construct()
    {
        try {
            $params = getDbConnectionParams();
            $this->pdo = new PDO($params["connString"], $params["userName"], $params["password"], $params["options"]);
        } catch (PDOException $e) {
            error_log("Error connecting to database: " . $e->getMessage());
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
            error_log("Could not find registered subjects: " . $e->getMessage());
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