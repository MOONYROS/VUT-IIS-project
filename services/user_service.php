<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

class userService
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
     * @brief Inserts new user to database.
     *
     * @param array $data User information to be inserted.
     * @return string Success or error message for user.
     */
    function insertNewUser(array $data): string
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Osoba (jmeno, prijmeni, email, heslo, telefon, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
            return "User successfully created.";
        }
        catch (PDOException $e) {
            error_log("User insert failed:" . $e->getMessage());
            return "User insert failed:" . $e->getMessage();
        }
    }

    /**
     * @brief Updates user information with fields specified in $data.
     *
     * @param array $data Data to be updated.
     * @return string Success or error message for user.
     */
    function updateUser(array $data): string
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Osoba SET jmeno = ?, prijmeni = ?, email = ?, heslo = ?, telefon = ?, role = ? WHERE ID_Osoba = ?");
            $stmt->execute($data);
            return "User successfully updated";
        }
        catch (PDOException $e) {
            error_log("User update failed:" . $e->getMessage());
            return "User update failed:" . $e->getMessage();
        }
    }

    /**
     * @brief Checks if user is present in the database.
     *
     * @param string $email User email from login form.
     * @param string $heslo User password from login form.
     * @return array|null User info as array on success, null on unsuccessful login.
     */
    function verifyLogin(string $email, string $heslo): array|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Osoba WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($heslo, $user['heslo'])) {
                return $user; // Přihlášení úspěšné
            }
            return null; // Přihlášení neúspěšné
        }
        catch (PDOException $e) {
            echo "Error validating login: " . $e->getMessage();
        }
        return null;
    }

    /**
     * @brief Get user information specified with $userId.
     *
     * @param string $userId User ID.
     * @return array|false|null User information on success, false on no records found, null on exceptions.
     */
    function getUserById(string $userId): array|false|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Osoba WHERE ID_Osoba = ?");
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Error loading user info: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @brief Get all users from database who are specified $role.
     * Role can be "stud", "vyuc", etc.
     * @param string $role Role of user in the information system.
     * @return array|false|null User array on success, false on no records found, null on exceptions.
     */
    function getUsersByRole(string $role): array|false|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT ID_Osoba, jmeno, prijmeni FROM Osoba WHERE role = ?");
            $stmt->execute(array($role));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Error loading info of users with role $role: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @brief Retrieves all user IDs from database.
     *
     * @return array|string Array on success (empty or non-empty), err string on failure.
     */
    function getUserIDs(): array|string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT ID_Osoba FROM Osoba");
            $stmt->execute();
            $userArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $userArray[] = $row['ID_Osoba'];
            }
            return $userArray;
        }
        catch (PDOException $e) {
            return "Could not get user IDs: " . $e->getMessage();
        }
    }

    /**
     * @brief Get all user information and return it in array.
     *
     * @param string $ID User ID.
     * @return array|false|null Array with fields on success, false on no records found, null on exceptions.
     */
    function getUserInfo(string $ID): array|false|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Osoba WHERE ID_Osoba = ?");
            $stmt->execute(array($ID));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            error_log("Fetch of user information unsuccessful: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @brief Delete user specified by $id from database.
     *
     * @param string $id User ID.
     * @return string Success or error message for user.
     */
    function deleteUser(string $id): string
    {
        try {
            $stmt = $this->pdo->prepare("DELETE from Osoba where ID_Osoba = ?");
            $stmt->execute(array($id));
            return "User successfully deleted.";
        }
        catch (PDOException $e) {
            error_log("User removal unsuccessful:" . $e->getMessage());
            return "Error when deleting user:" . $e->getMessage();
        }
    }

    /**
     * @brief Get role of user specified with $ID.
     *
     * @param string $ID User role.
     * @return string|null User role on success, null on error.
     */
    function getRole(string $ID): string|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT role FROM Osoba WHERE ID_Osoba = ?");
            $stmt->execute(array($ID));
            $output = $stmt->fetch(PDO::FETCH_ASSOC);
            return $output['role'];
        }
        catch (PDOException $e) {
            error_log("Fetch of user role unsuccessful: " . $e->getMessage());
            return null;
        }
    }
}
