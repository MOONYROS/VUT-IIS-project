<?php

class AccountService {
    private PDO $pdo;
    function __construct()
    {
        try {
            $connString = "mysql:host=db;dbname=mydatabase";
            $userName = "myuser";
            $password = "mypassword";
//            $options = array(
//                PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf-8"
//            );
            $this->pdo = new PDO($connString, $userName, $password);
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
}
