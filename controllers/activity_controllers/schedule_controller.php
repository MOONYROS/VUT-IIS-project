<?php

require_once "../../services/user_service.php";

function getStudentName(): string {
    $servis = new userService();
    $person = $servis->getUserInfo($_SESSION["user_id"]);
    return $person["jmeno"] . " " . $person["prijmeni"];
}