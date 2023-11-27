<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

class roomService
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
     * @brief Inserts new room to the database.
     *
     * @param array $data Database fields in array.
     * @return string Either error or success message for user.
     */
    function insertNewRoom(array $data): string
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Mistnost (ID_mist, kapacita, typ, popis, umisteni) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute($data);
            return "Room successfully added";
        }
        catch (PDOException $e) {
            error_log("Room insert failed:" . $e->getMessage());
            return "Room insert failed: " . $e->getMessage();
        }
    }

    /**
     * @brief Updates room information in database.
     *
     * @param array $data Fields to update in database.
     * @return string Either error or success message for user.
     */
    function updateRoom(array $data): string
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Mistnost SET kapacita = ?, typ = ?, popis = ?, umisteni = ? WHERE ID_mist = ?");
            $stmt->execute($data);
            return "Room info successfully updated";
        }
        catch (PDOException $e) {
            error_log("Room update failed:" . $e->getMessage());
            return "Room update failed:" . $e->getMessage();
        }
    }

    /**
     * @brief Retrieves all room IDs from database and returns it as array.
     *
     * @return array|null Array of room IDs on success, error message on failure.
     */
    function getRoomIDs(): array|string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT ID_mist FROM Mistnost");
            $stmt->execute();
            $subjectArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subjectArray[] = $row['ID_mist'];
            }
            return $subjectArray;
        }
        catch (PDOException $e) {
            error_log("Room not found: " . $e->getMessage());
            return "Room not found: " . $e->getMessage();
        }
    }

    /**
     * @brief Retrieves all information about room in database and returns it as array.
     *
     * @param string $id ID of room.
     * @return array|false|string Array of room information on success, false on no records found, error message on exception.
     */
    function getRoomInfo(string $id): array|false|string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Mistnost WHERE ID_mist = (?)");
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Could not get room info: " . $e->getMessage());
            return "An error occured when searching for room.";
        }
    }

    /**
     * @brief Deletes room from database.
     *
     * @param string $id Room ID.
     * @return string Either error or success message for user.
     */
    function deleteRoom(string $id): string
    {
        try {
            $stmt = $this->pdo->prepare("DELETE from Mistnost where ID_mist = ?");
            $stmt->execute(array($id));
            return "Room successfully deleted.";
        }
        catch (PDOException $e) {
            $this->pdo->rollBack();

            error_log("Room removal unsuccessful:" . $e->getMessage());
            return "Room removal unsuccessfull: " . $e->getMessage();
        }
    }
}