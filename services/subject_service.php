<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

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
            $stmt = $this->pdo->prepare("INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni, garant) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
            $this->addTeacher($data["zkratka"], $data["garant"]);
            return "Subject successfully added.";
        }
        catch (PDOException $e) {
            error_log("Subject insert failed:" . $e->getMessage());
            return "Subject insert failed: " . $e->getMessage();
        }
    }

    function updateSubject($data) {
        try {
            $stmt = $this->pdo->prepare("UPDATE Predmet SET nazev = ?, anotace = ?, pocet_kreditu = ?, typ_ukonceni = ?, garant = ? WHERE zkratka = ?");
            $stmt->execute([
                $data["nazev"],
                $data["anotace"],
                $data["pocet_kreditu"],
                $data["typ_ukonceni"],
                $data["garant"],
                $data["zkratka"]
            ]);
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
            $stmt = $this->pdo->prepare("SELECT Predmet.*, Osoba.jmeno, Osoba.prijmeni
                                        FROM Predmet JOIN Osoba ON Predmet.garant = Osoba.ID_Osoba 
                                        WHERE zkratka = (?)");
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

    function getGarantedSubjects($ID) {
        try {
            $stmt = $this->pdo->prepare("SELECT zkratka FROM Predmet WHERE garant = ?");
            $stmt->execute(array($ID));
            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
            error_log("Could not get subjects garanted by $ID: " . $e->getMessage());
            return null;
        }
    }

    function getTeachedSubjects($ID) {
        try {
            $stmt = $this->pdo->prepare("SELECT zkratka, zadost FROM Osoba_predmet WHERE ID_Osoba = ?");
            $stmt->execute(array($ID));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not fetch teached subjects: " . $e->getMessage());
            return null;
        }
    }

    function addTeacher($subjectId, $teacherId) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Osoba_predmet (ID_Osoba, zkratka) VALUES (?, ?)");
            $stmt->execute(array($teacherId, $subjectId));
            return "Učitel úspěšně přidán k předmětu.";
        }
        catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "Učitel má předmět již zaregistrovaný.";
            }
            error_log("Chyba pri prirazovani ucitele k predmetu $subjectId:" . $e->getMessage());
            return null;
        }
    }

    function removeTeacher($subjectId, $teacherId) {
        try {
            $subject = $this->getSubjectInfo($subjectId);
            if ($teacherId == $subject["garant"]) {
                return "Učitel je garantem.";
            }
            $stmt = $this->pdo->prepare("DELETE FROM Osoba_predmet WHERE ID_Osoba = ? AND zkratka = ?");
            $stmt->execute(array($teacherId, $subjectId));
            return "Učitel úspěšně odebrán z předmětu.";
        }
        catch (PDOException $e) {
            error_log("Chyba pri odstranovani ucitele z predmetu $subjectId:" . $e->getMessage());
            return null;
        }
    }

    function createRequest($ID, $subject, $request) {
        try {
            $stmt = $this->pdo->prepare("UPDATE Osoba_predmet SET zadost = ? WHERE ID_Osoba = ? AND zkratka = ?");
            $stmt->execute(array($request, $ID, $subject));
            return "Žádost úspěšně vytvořena";
        }
        catch (PDOException $e) {
            error_log("Tvorba žádosti selhala: " . $e->getMessage());
            return false;
        }
    }

    function deleteRequest($ID, $subject)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Osoba_predmet SET zadost = NULL WHERE ID_Osoba = ? AND zkratka = ?");
            $stmt->execute(array($ID, $subject));
            return "Žádost úspěšně smazána";
        }
        catch (PDOException $e) {
            error_log("Žádost se nepodařilo smazat: " . $e->getMessage());
            return "Žádost se nepodařilo smazat: " . $e->getMessage();
        }
    }

    function getRequests() {
        try {
            $stmt = $this->pdo->prepare("SELECT Osoba.jmeno, Osoba.prijmeni, Osoba_predmet.zkratka, Osoba_predmet.zadost
                                        FROM Osoba
                                        JOIN Osoba_predmet ON Osoba.ID_Osoba = Osoba_predmet.ID_Osoba
                                        WHERE Osoba.role = 'vyuc' AND Osoba_predmet.zadost IS NOT NULL
                                        ORDER BY Osoba_predmet.zkratka");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Nepodařilo se získat žádosti: " . $e->getMessage());
            return "Nepodařilo se získat žádosti: " . $e->getMessage();
        }
    }

    function getSubjectTeachers($subjectId) {
        try {
            $stmt = $this->pdo->prepare("SELECT Osoba.ID_Osoba, jmeno, prijmeni 
                                        FROM Osoba 
                                        JOIN Osoba_predmet ON Osoba.ID_Osoba = Osoba_predmet.ID_Osoba
                                        JOIN Predmet ON Osoba_predmet.zkratka = Predmet.zkratka
                                        WHERE Predmet.zkratka = ? AND Osoba.role = ?");
            $stmt->execute(array($subjectId, "vyuc"));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Couldn't get subject teachers: " . $e->getMessage());
            return null;
        }
    }
}