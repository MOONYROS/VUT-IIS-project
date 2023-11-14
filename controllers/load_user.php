<?php
require_once "../services/account_service.php";

function loadUser($ID): string
{
    $accountService = new AccountService();
    $userInfo = $accountService->getUserInfo($ID);
    $finalValue = "";
    foreach ($userInfo as $item) {
        $finalValue = $finalValue . '<td>' . $item . '</td>';
    }
    return $finalValue;
}
