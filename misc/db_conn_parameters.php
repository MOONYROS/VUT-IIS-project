<?php
function getDbConnectionParams()
{
    $connString = "mysql:host=db;dbname=mydatabase";
    $userName = "myuser";
    $password = "mypassword";
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
    );
    return array(
        "connString" => $connString,
        "userName" => $userName,
        "password" => $password,
        "options" => $options
    );
}