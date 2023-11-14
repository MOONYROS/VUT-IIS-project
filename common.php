<?php

session_start();

function make_header($title): void
{
    ?>
    <!DOCTYPE html>
    <html lang="cs">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title><?php echo $title;?></title>
    </head>
    <body>
    <?php
}

function make_footer() : void
{
    ?>
    </body>
    </html>
    <?php
}

function checkSelect($option, $to_check): string {
    if ($option == $to_check)
        return "selected";
    else
        return "";
}