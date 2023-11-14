<?php

require_once "../services/room_service.php";

if (isset($_POST["ID_mist"])) {
    $service = new roomService();
    $message = $service->deleteRoom($_POST["ID_mist"]);
    header("Location: ../views/room_management.php?message=$message");
}