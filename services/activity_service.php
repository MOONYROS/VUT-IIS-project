<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

/**
 * @brief A class responsible for writing activity-related data to the database.
 * Uses PDO for data manipulation.
 */
class activityService
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
     * @brief Inserts requirement from subject garant for activity into the database.
     * Doesn't have room, teacher, time and day specified yet.
     *
     * @param array $data Fields in array to be inserted.
     * @return string Message that will be printed out to the user, whether it succeeds or not.
     */
    function insertNewActivity(array $data): string
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Vyuk_aktivita(typ, delka, popis, opakovani, pozadavek, predmet) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
            return "Activity successfully added";
        }
        catch (PDOException $e) {
            error_log("Data input failed:" . $e->getMessage());
            if (str_contains($e->getMessage(), 'mistnost')) {
                return "Activity input failed - unknown room: " . $e->getMessage();
            }
            elseif (str_contains($e->getMessage(), 'predmet')) {
                return "Activity input failed - unknown subject: " . $e->getMessage();
            }
            else {
                return "Activity input failed: " . $e->getMessage();
            }
        }
    }

    /**
     * @brief Updates activity requirement in database when teacher edits it.
     * The updated fields don't include teacher, room, time and day.
     *
     * @param array $data Updated fields to be inserted into database.
     * @return string Message to be shown to user, whether it succeeds or not.
     */
    function updateActivity(array $data): string
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Vyuk_aktivita SET  typ = ?, delka = ?, popis = ?, opakovani = ?, pozadavek = ?, predmet = ? WHERE ID_Aktiv = ?");
            $stmt->execute($data);
            return "Activity info successfully updated";
        }
        catch (PDOException $e) {
            error_log("Activity update failed:" . $e->getMessage());
            if (str_contains($e->getMessage(), 'mistnost')) {
                return "Activity update failed - unknown room: " . $e->getMessage();
            }
            elseif (str_contains($e->getMessage(), 'predmet')) {
                return "Activity update failed - unknown subject: " . $e->getMessage();
            }
            else {
                return "Activity update failed: " . $e->getMessage();
            }
        }
    }

    /**
     * @brief Sets room, day, time and teacher to activity requirement, making it a valid activity.
     *
     * @param array $data Fields to be inserted into the database.
     * @return string Message to be printed out to the user, whether it succeeds or not.
     */
    function scheduleActivity(array $data)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Vyuk_aktivita SET mistnost = ?, den = ?, start = ?, vyucujici = ? WHERE ID_Aktiv = ?");
            $stmt->execute([
                $data['mistnost'],
                $data['den'],
                $data['start'],
                $data['vyucujici'],
                $data['ID_Aktiv']
            ]);
            return "Activity info successfully updated";
        }
        catch (PDOException $e) {
            error_log("Activity not found: " . $e->getMessage());
            return "Activity not found: " . $e->getMessage();
        }
    }

    /**
     * @brief Searches for all activities of one subject and returns them in array.
     *
     * @param string $subject Subject abbreviation for which the activities will be searched.
     * @return array|null Array of activity IDs on success, null on failure.
     */
    function getActivityIDs(string $subject): array|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT ID_Aktiv FROM Vyuk_aktivita WHERE predmet = ?");
            $stmt->execute(array($subject));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Activity not found: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @brief Finds all the information about activity and returns it as array.
     *
     * @param string $id Activity ID for which the information will be searched.
     * @return array|false|null Array of fields on success, false on no record found, null on PDO exception.
     */
    function getActivityInfo(string $id): array|false|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Vyuk_aktivita WHERE ID_Aktiv = (?)");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Data input unsuccessful");
            return null;
        }
    }

    /**
     * @brief Deletes activity from database.
     *
     * @param string $id ID of activity to be deleted.
     * @return string Message for user that will be printed out, it succeeds or not.
     */
    function deleteActivity(string $id): string
    {
        try {
            $stmt = $this->pdo->prepare("DELETE from Vyuk_aktivita where ID_Aktiv = ?");
            $stmt->execute(array($id));
            return "Activity successfully deleted.";
        }
        catch (PDOException $e) {
            error_log("Activity removal unsuccessful:" . $e->getMessage());
            return "Activity removal unsuccessfull: " . $e->getMessage();
        }
    }

    /**
     * @brief Gets all the activities from database.
     *
     * @return array|false|string Array of activities on success, false on no records found, error message on exception.
     */
    function getAllActivities(): array|false|string
    {
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

    /**
     * @brief Gets all activities from database in specified room and day and returns it as array.
     *
     * @param string $room Room ID in which the activities take place.
     * @param string $day Day in which the activities are organized.
     * @return array|false|string Array of activities on success, false on no records found, error message on exception.
     */
    function getRoomDayActivity(string $room, string $day): array|false|string
    {
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

    /**
     * @brief Gets all activities from database that user is included in.
     * User can be either teacher or student.
     *
     * @param string $userId ID of the user for whom activities are being searched.
     * @return array|false|string Array of activities on success, false on no records found, error message on exception.
     */
    function getUserActivities(string $userId): array|false|string
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT den, predmet, typ, start, delka, mistnost, opakovani, vyucujici
                        FROM Vyuk_aktivita
                        WHERE predmet IN (SELECT zkratka FROM Osoba_predmet WHERE ID_Osoba = ?)
                            AND start IS NOT NULL
                            AND mistnost IS NOT NULL
                        ORDER BY
                          CASE
                            WHEN den = 'po' THEN 1
                            WHEN den = 'ut' THEN 2
                            WHEN den = 'st' THEN 3
                            WHEN den = 'ct' THEN 4
                            WHEN den = 'pa' THEN 5
                            ELSE 6 
                          END,
                          start");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not load activities: " . $e->getMessage());
            return "Could not load activities:  " . $e->getMessage();
        }
    }

    /**
     * @brief Gets all activities that user is included in on specified day.
     * User can be either teacher or student.
     *
     * @param string $userId ID of the user for whom activities are being searched.
     * @param string $day Specifies the target day for activity retrieval.
     * @return array|false|string Array of activities on success, false on no records found, error message on exception.
     */
    function getUserActivitiesDay(string $userId, string $day): array|false|string
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT den, predmet, typ, start, delka, mistnost, opakovani, vyucujici
                FROM Vyuk_aktivita WHERE predmet  IN 
                (SELECT zkratka FROM Osoba_predmet WHERE ID_Osoba = ? AND den = ?) ORDER BY start;"
            );
            $stmt->execute([$userId, $day]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not load activities: " . $e->getMessage());
            return "Could not load activities: " . $e->getMessage();
        }
    }

    /**
     * @brief Gets all activities on specified day independently on users.
     *
     * @param string $day Specifies the target day for activity retrieval.
     * @return array|false|string Array of activities on success, false on no records found, error message on exception.
     */
    function getActivitiesDay(string $day): array|false|string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT mistnost, den, start, delka, opakovani FROM Vyuk_aktivita WHERE den = ?");
            $stmt->execute([$day]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not load activities: " . $e->getMessage());
            return "Could not load activities: " . $e->getMessage();
        }
    }

    /**
     * @brief Gets all activities of teacher specified by $teacher.
     *
     * @param string $teacher ID of the teacher for whom activities are being searched.
     * @return array|false|string Array of activities on success, false on no records found, error message on exception.
     */
    function getTeacherActivities(string $teacher): array|false|string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT den, predmet, typ, mistnost, start, delka, opakovani FROM Vyuk_aktivita WHERE vyucujici = ?");
            $stmt->execute([$teacher]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not load teacher activities: " . $e->getMessage());
            return "Could not load activities: " . $e->getMessage();
        }
    }

    /**
     * @brief Gets all activities that teacher is included in on specified day.
     * User can be either teacher or student.
     *
     * @param string $teacher ID of the teacher for whom activities are being searched.
     * @param string $day Specifies the target day for activity retrieval.
     * @return array|false|string Array of activities on success, false on no records found, error message on exception.
     */
    function getTeacherActivitiesDay(string $teacher, string $day): array|false|string
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT den, predmet, typ, mistnost, start, delka, opakovani
                FROM Vyuk_aktivita WHERE vyucujici = ? AND den = ? ;"
            );
            $stmt->execute([$teacher, $day]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not load teacher day activities: " . $e->getMessage());
            return "Could not load activities: " . $e->getMessage();
        }
    }

}