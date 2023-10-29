<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    InsertAdmin();
}

// phpinfo();

function getPDOConnection() {
    // Definujte parametry databáze
    $servername = "db";  // Zde používáme název služby MySQL z vašeho docker-compose jako hostname.
    $username = "myuser";
    $password = "mypassword";
    $database = "mydatabase";

    try {
        // Vytvoření PDO instance a připojení k databázi
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

        // Nastavení atributu PDO pro zobrazení chyb
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch(PDOException $e) {
        // V případě selhání připojení vypíše chybu
        die("Připojení selhalo: " . $e->getMessage());
    }
}


function InsertAdmin () {

    
    try {
        // Získání PDO připojení
        $conn = getPDOConnection();
    
        // Příprava SQL dotazu
        $stmt = $conn->prepare("INSERT INTO Administrator (ID_Admin, jmeno, prijmeni, email, telefon) VALUES (:id_admin, :jmeno, :prijmeni, :email, :telefon)");
    
        // Vazba parametrů
        $stmt->bindParam(':id_admin', $id_admin);
        $stmt->bindParam(':jmeno', $jmeno);
        $stmt->bindParam(':prijmeni', $prijmeni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefon', $telefon);
    
        // Nastavení proměnných a spuštění dotazu
        $id_admin = '00002';
        $jmeno = 'WALTUH';
        $prijmeni = 'WHITE';
        $email = 'john.doe@example.com';
        $telefon = '123456789';
    
        $stmt->execute();
    
        echo "Záznam byl úspěšně vložen.";
    } catch(PDOException $e) {
        echo "Chyba při vkládání záznamu: " . $e->getMessage();
    }
    
    // Uzavření připojení
    $conn = null;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIS projekt</title>
</head>
<body>
    <form method="post">
        <input type="submit" value="PRIDAT">
    </form>
</body>
</html>
