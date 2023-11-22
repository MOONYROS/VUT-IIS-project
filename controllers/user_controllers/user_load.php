<?php

require_once "../../common.php";
require_once "../../services/user_service.php";

function loadUser($ID): string
{
    $accountService = new userService();
    $userInfo = $accountService->getUserInfo($ID);
    $fullName = '<td><a href="../../views/user_views/user_info.php?ID='. $userInfo['ID_Osoba'] .'">' . $userInfo['prijmeni'] . ' ' . $userInfo['jmeno'] . '</a></td>';
    $email = '<td>' . $userInfo['email'] . '</td>';
    $phone = '<td>' . $userInfo['telefon'] . '</td>';
    $role = '<td>' . roleName($userInfo['role']) . '</td>';
    return $fullName . $email . $phone . $role;
}
