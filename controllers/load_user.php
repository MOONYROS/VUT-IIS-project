<?php
require_once "../services/account_service.php";

function loadUser($ID): string
{
    $accountService = new AccountService();
    $userInfo = $accountService->getUserInfo($ID);
    $fullName = '<td>' . $userInfo['prijmeni'] . ' ' . $userInfo['jmeno'] . '</td>';
    $email = '<td>' . $userInfo['email'] . '</td>';
    $phone = '<td>' . $userInfo['telefon'] . '</td>';
    $role = '<td>' . $userInfo['role'] . '</td>';
    return $fullName . $email . $phone . $role;
}
