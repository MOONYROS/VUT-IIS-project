<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

class subjectService
{
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

    /**
     * @brief Inserts new subject to the database.
     *
     * @param array $data Subject fields in array to be inserted.
     * @return string Error or success message for user.
     */
    function insertNewSubject(array $data): string
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Predmet (zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni, garant) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data["zkratka"],
                $data["nazev"],
                $data["anotace"],
                $data["pocet_kreditu"],
                $data["typ_ukonceni"],
                $data["garant"]
            ]);
            $this->addTeacher($data["zkratka"], $data["garant"]);
            return "Subject successfully added.";
        }
        catch (PDOException $e) {
            error_log("Subject insert failed: " . $e->getMessage());
            return "Subject insert failed: " . $e->getMessage();
        }
    }

    /**
     * @brief Updates subject fields from $data array in database.
     *
     * @param array $data Array of fields to be updated.
     * @return string Error or success message for user.
     */
    function updateSubject(array $data): string
    {
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
            error_log("Subject update failed: " . $e->getMessage());
            return "Subject update failed: " . $e->getMessage();
        }
    }

    /**
     * @brief Get all IDs of all subjects from database and return them in array.
     *
     * @return array|string Array of IDs on success, error string on failure.
     */
    function getSubjectIDs(): array|string
    {
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
            return "Could not get subject IDs: " . $e->getMessage();
        }
    }

    /**
     * @brief Get all fields from subject table as well as garant first and last name.
     *
     * @param string $id ID of subject to be searched for.
     * @return array|false|null Array of fields on success, false on no records found, null on exception.
     */
    function getSubjectInfo(string $id): array|false|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT Predmet.*, Osoba.jmeno, Osoba.prijmeni
                                        FROM Predmet JOIN Osoba ON Predmet.garant = Osoba.ID_Osoba 
                                        WHERE zkratka = (?)");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not get subjet info: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @brief Deletes subject specified by $id from database.
     *
     * @param string $id Subject abbreviation.
     * @return string Error or success message for user.
     */
    function deleteSubject(string $id): string
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Predmet WHERE zkratka = ?");
            $stmt->execute(array($id));
            return "Subject successfully deleted.";
        }
        catch (PDOException $e) {
            error_log("Subject removal unsuccessful: " . $e->getMessage());
            return "Subject delete failed: " . $e->getMessage();
        }
    }

    /**
     * @brief Find all abbreviations of subjects that are garanted by teacher specified with $id.
     *
     * @param string $ID Teacher ID.
     * @return array|false|null Array of subjects on success, false on no records found, null on exception.
     */
    function getGarantedSubjects(string $ID): array|false|null
    {
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

    /**
     * @brief Get all subjects that teacher specified with $ID teaches.
     *
     * @param string $ID Teacher ID.
     * @return array|false|null Array of subjects on success, false on no records, null on exception.
     */
    function getTeachedSubjects(string $ID): array|false|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT zkratka, zadost FROM Osoba_predmet WHERE ID_Osoba = ?");
            $stmt->execute(array($ID));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not get teached subjects: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @brief Add teacher to subject.
     * Adds new row to Osoba_predmet binding entity.
     *
     * @param string $subjectId Subject ID.
     * @param string $teacherId Teacher ID.
     *
     * @return string On success or when duplicated row, returns message for user.
     * @throws PDOException on error.
     */
    function addTeacher(string $subjectId, string $teacherId): string
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Osoba_predmet (ID_Osoba, zkratka) VALUES (?, ?)");
            $stmt->execute(array($teacherId, $subjectId));
            return "Učitel úspěšně přidán k předmětu.";
        }
        catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "Učitel má předmět již zaregistrovaný.";
            }
            error_log("Error adding teacher to subject $subjectId:" . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @brief Removes techer from subject.
     * Removes row from binding entity Osoba_predmet.
     *
     * @param string $subjectId Subject from which the teacher will be removed.
     * @param string $teacherId Teacher ID.
     * @return string|null String for user on success or error when teacher is garant, null on exception.
     */
    function removeTeacher(string $subjectId, string $teacherId): string|null
    {
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
            error_log("Error removing teacher from subject $subjectId:" . $e->getMessage());
            return null;
        }
    }

    /**
     * @brief Creates request from teacher for teaching subject activity.
     * It's full-text so the requirements can be any.
     *
     * @param string $ID Teacher ID.
     * @param string $subject Subject ID.
     * @param string $request Request text.
     * @return string|null Message for user on success, null on failure.
     */
    function createRequest(string $ID, string $subject, string $request): string|null
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Osoba_predmet SET zadost = ? WHERE ID_Osoba = ? AND zkratka = ?");
            $stmt->execute(array($request, $ID, $subject));
            return "Žádost úspěšně vytvořena";
        }
        catch (PDOException $e) {
            error_log("Request creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**\
     * @brief Deletes teacher request for teaching subject activity.
     *
     * @param string $ID Teacher ID.
     * @param string $subject Subject ID.
     * @return string Message for user both on success and failure.
     */
    function deleteRequest(string $ID, string $subject): string
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Osoba_predmet SET zadost = NULL WHERE ID_Osoba = ? AND zkratka = ?");
            $stmt->execute(array($ID, $subject));
            return "Žádost úspěšně smazána";
        }
        catch (PDOException $e) {
            error_log("Could not delete request: " . $e->getMessage());
            return "Žádost se nepodařilo smazat: " . $e->getMessage();
        }
    }

    /**
     * @brief Get all requests from teachers in given subject.
     *
     * @param string $subject Subject ID.
     * @return array|false|string Array of requests on success, false on no records found, err message on exception.
     */
    function getRequestsBySubject(string $subject): array|false|string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT Osoba.jmeno, Osoba.prijmeni, Osoba_predmet.zadost
                                        FROM Osoba
                                        JOIN Osoba_predmet ON Osoba.ID_Osoba = Osoba_predmet.ID_Osoba
                                        WHERE Osoba.role = 'vyuc' AND Osoba_predmet.zadost IS NOT NULL AND Osoba_predmet.zkratka = ?");
            $stmt->execute(array($subject));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not get requests: " . $e->getMessage());
            return "Could not get requests: " . $e->getMessage();
        }
    }

    /**
     * @brief Get all teachers from given subject.
     *
     * @param string $subjectId Subject ID.
     * @return array|false|null Array of teachers on success, false on no records found, null on exception.
     */
    function getSubjectTeachers(string $subjectId): array|false|null
    {
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

    /**
     * @brief Changes subject garant from one teacher to another.
     *
     * @param string $zkratka Subject ID.
     * @param string $oldGarantId Garant to be removed.
     * @param string $newGarantId Garant to be set.
     * @return void
     */
    function updateGarant(string $zkratka, string $oldGarantId, string $newGarantId): void
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Osoba_predmet WHERE ID_Osoba = ? AND zkratka = ?");
            $stmt->execute([$oldGarantId, $zkratka]);
            $this->addTeacher($zkratka, $newGarantId);
        }
        catch (PDOException $e) {
            error_log("Failed to remove garant: " . $e->getMessage());
        }
    }

    /**
     * @brief Get subject information without garant.
     *
     * @param string $zkratka Subject ID.
     * @return array|false|null Subject information without garanting teacher, false on no records found, null on exceptions.
     */
    function getSubjectInfoNoGarant(string $zkratka): array|false|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT zkratka, nazev, anotace, pocet_kreditu, typ_ukonceni FROM Predmet WHERE zkratka = ?");
            $stmt->execute([$zkratka]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Failed to remove garant: " . $e->getMessage());
            return null;
        }
    }
}