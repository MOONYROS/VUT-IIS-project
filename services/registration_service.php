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
        }
        catch (PDOException $e) {
            error_log("Error connecting to database: " . $e->getMessage());
        }
    }

    /**
     * @brief Finds all students' registered subjects in database and returns them in array.
     *
     * @param string $user ID of user whom subjects will be searched for.
     * @return array|false|string Array of subject abbreviations on success, false on no records found and error message on exception.
     */
    function retrieveRegistered(string $user): array|false|string
    {
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
            return "Could not find registered subjects: " . $e->getMessage();
        }
    }

    /**
     * @todo neni to k hovnu?
     * @param $array
     * @return array
     */
    function newlyRegistered($array): array
    {
        $registeredArray = array();
        foreach ($array as $subject) {
            $registeredArray[] = $subject;
        }
        return $registeredArray;
    }

    /**
     * @brief Unregisters subjects for student.
     * All subjects present in $old and not in $new will be deleted.
     *
     * @param array $old An array of previously registered subjects.
     * @param array $new An array of newly registered subjects.
     * @return array|string Array of all registered subjects after update, error message on failure.
     */
    function unregisterSubject(array $old, array $new): array|string
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM Osoba_predmet WHERE ID_Osoba = ? AND zkratka = ?');
            foreach ($old as $key => $subject) {
                if (!in_array($subject, $new)) {
                    $stmt->execute(array($_SESSION['user_id'], $subject));
                    unset($old[$key]);
                }
            }
            return $old;
        }
        catch (PDOException $e) {
            error_log("Couldnt unregister subjects: " . $e->getMessage());
            return "An error occured when unregistering subjects.";
        }
    }

    /**
     * @brief Registers new subjects for student in the database.
     * All subjects in $new, that aren't in $old, are added.
     *
     * @param array $old Old students' subjects.
     * @param array $new New students' subjects.
     * @return array|string Array of subjects on success, error message on failure.
     */
    function registerNewSubject(array $old, array $new): array|string
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO Osoba_predmet (ID_Osoba, zkratka) VALUES (?, ?)');
            foreach ($new as $subject) {
                if (!in_array($subject, $old)) {
                    $stmt->execute(array($_SESSION['user_id'], $subject));
                    $old[] = $subject;
                }
            }
            return $old;
        }
        catch (PDOException $e) {
            error_log("Couldn't register subjects: " . $e->getMessage());
            return "An error occured when registering subjects.";
        }
    }
}