<?php
session_start();

if (isset($_SESSION['logout_time']) && (time() - $_SESSION['logout_time']) > 1800) {
    session_unset();
    echo "<script>alert(\"Byl/a jste odhlášen/a.\"); window.location.href=\"/index.php\"</script>";
    exit;
}
else {
    $_SESSION['last_timestamp'] = time();
}

function make_header($title): void
{
    $domain = 'http://localhost:8080';
    ?>
    <!DOCTYPE html>
    <html lang="cs">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="icon" type="image/x-icon" href="<?= $domain . '/public/scheduler_icon.ico'?>">
        <link rel="stylesheet" href="<?= $domain . '/public/style.css'?>">
        <script src="<?= $domain . '/public/validateForm.js'?>"></script>
        <title><?= $title;?></title>
    </head>
    <body>
    <div class="container">
    <?php
        
}

function make_footer() : void
{
    ?>
    </div>
    </body>
    </html>
    <footer>
        <div class="container">
            <div id="creators">
                <span>Vytvořili</span>
                <ul>
                    <li><a href="https://github.com/jonys124" target="_blank">Jonáš Morkus (xmorku03)</a></li>
                    <li><a href="https://github.com/MOONYROS" target="_blank">Ondřej Lukášek (xlukas15)</a></li>
                    <li><a href="https://github.com/Kumismar" target="_blank">Ondřej Koumar (xkouma02)</a></li>
                </ul>
            </div>
            <div id="origin">
                <p>IIS 2023</p>
            </div>
        </div>
    </footer>
    <?php
}

function checkSelect($option, $to_check): string {
    if ($option == $to_check)
        return "selected";
    else
        return "";
}

function roleName($input): string {
    return match ($input) {
        "admi" => "Administrátor",
        "stud" => "Student",
        "vyuc" => "Vyučující",
        "rozv" => "Rozvrhář",
        "gara" => "Garant",
        default => $input,
    };
}

function requiredField() {
    return '<span class="required">*</span>';
}
