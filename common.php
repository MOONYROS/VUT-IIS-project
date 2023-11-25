<?php
session_start();

if (isset($_SESSION['logout_time']) && (time() - $_SESSION['logout_time']) > 600) {
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
    <?php
        
}

function make_footer() : void
{
    ?>
    </body>
    </html>
    <footer>
        Vytvořili
        <ul>
            <li>Jonáš Morkus</li>
            <li>Ondřej Lukášek</li>
            <li>Ondřej Koumar</li>
        </ul>
        <p>IIS 2023</p>
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

function checkRole($targetRole): bool {
    global $user;
    if ($user['role'] == $targetRole) {
        return true;
    }
    else {
        return false;
    }
}

function toMainPage(): string {
    return "<a class='direct_link' href='/views/main_page.php'>Zpět na hlavní obrazovku</a>";
}

function toSelectedPage($pagePath, $name): string {
    return "<a class='direct_link' href=/views" . $pagePath . ">$name</a>";
}

function requiredField() {
    return '<span class="required">*</span>';
}
