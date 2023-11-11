<?php

session_start();

function make_header($title)
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


function make_footer()
{
    ?>
    <footer>&copy; FIT 2023</footer>
    </body>
    </html>
    <?php
}