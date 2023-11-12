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
            echo "Succcessful Database connection!";
        }
        catch (PDOException $e) {
            echo "Chyba pri navazani spojeni s databazi:" . $e->getMessage();
        }
    }

    function insertNewAccount($data): void
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Osoba (jmeno, prijmeni, email, heslo, telefon, role) VALUES (?, ?, ?,  ?, ?, ?)");
            $stmt->execute($data);
            echo "Data input successful!";
        }
        catch (PDOException $e) {
            echo "Chyba pri vkladani zaznamu:" . $e->getMessage();
        }
    }
}
