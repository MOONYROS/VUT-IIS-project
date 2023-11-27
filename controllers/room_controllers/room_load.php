<?php

require_once "../../services/room_service.php";

/**
 * @brief Fills row of html table with room fields from database.
 *
 * @param string $ID Room ID.
 * @return string Room items as html row table elements, concatenated.
 */
function loadRoom(string $ID): string
{
    $roomService = new roomService();
    $roomInfo = $roomService->getRoomInfo($ID);
    $finalValue = "";
    foreach ($roomInfo as $item) {
        if ($finalValue == "") {
            $finalValue = '<td><a href="../../views/room_views/room_info.php?ID_mist=' . $item . '">' . $item . '</a></td>';
        }
        else {
            $item = roomTypeText($item);
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
    }
    return $finalValue;
}

/**
 * @brief Maps room type from database to better-readable format.
 *
 * @param string $type Type from database.
 * @return string Type in better format.
 */
function roomTypeText($type)
{
    return match ($type) {
        'chodba' => 'Chodba',
        'poslucharna' => 'Posluchárna',
        'pracovna' => 'Pracovna',
        'studovna' => 'Studovna',
        default => $type,
    };
}