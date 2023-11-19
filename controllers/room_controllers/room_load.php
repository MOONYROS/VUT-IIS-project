<?php

require_once "../../services/room_service.php";

function loadRoom($ID) {
    $roomService = new roomService();
    $roomInfo = $roomService->getRoomInfo($ID);
    $finalValue = "";
    foreach ($roomInfo as $item) {
        if ($finalValue == "") {
            $finalValue = '<td><a href="../../views/room_views/room_info.php?ID_mist='. $item . '">' . $item. '</a></td>';
        }
        else {
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
    }
    return $finalValue;
}