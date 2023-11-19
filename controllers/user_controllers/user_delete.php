<?php

require_once "../../services/user_service.php";

if (isset($_POST["ID_Osoba"])) {
    $service = new userService();
    $returnMessage = $service->deleteUser($_POST["ID_Osoba"]);
    header("Location: ../../views/user_views/user_management.php?message=$returnMessage");
}