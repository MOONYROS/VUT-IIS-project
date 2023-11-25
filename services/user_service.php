<?php

require_once __DIR__ . "/../misc/db_conn_parameters.php";

class userService {
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

    function insertNewUser($data)
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

    function updateUser($data) {
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

    function verifyLogin($email, $heslo)
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

    function getUserById($userId)
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

    function getUsersByRole($role) {
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

    function getUserInfo($ID) {
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

    function deleteUser($id): string {
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

    function getRole($ID) {
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
