<?php

class AccountService {
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

    function insertNewAccount($data): void
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Osoba (jmeno, prijmeni, email, heslo, telefon, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
            echo "Data input successful!";
        }
        catch (PDOException $e) {
            echo "Chyba pri vkladani zaznamu:" . $e->getMessage();
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
            echo "Chyba při ověřování uživatele: " . $e->getMessage();
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
            error_log("Chyba při načítání uživatelských informací: " . $e->getMessage());
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
            return "Getting User IDs was unsuccessful: " . $e->getMessage();
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
}
