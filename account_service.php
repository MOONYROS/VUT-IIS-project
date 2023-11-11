<?php

class AccountService {
    private $pdo;
    function __construct() {
        try {
            $connString = "mysql:host=db;dbname=mydatabase";
            $userName = "myuser";
            $password = "mypassword";   
            // $options = array(
            //     PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf-8"
            // );
            $this->pdo = new PDO($connString, $userName, $password);
        } catch (PDOException $e) {
            echo "Chyba pri navazani spojeni s databazi:" . $e->getMessage();
        }
    }

    function insertNewAccount($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO osoba (jmeno, prijmeni, login, heslo, email, telefon, role) values (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Chyba pri vkladani zaznamu:" . $e->getMessage();
        }
    }
}

?>