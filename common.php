<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['logout_time']) && (time() - $_SESSION['logout_time']) > 1800) {
    session_unset();
    echo "<script>alert(\"Byl/a jste odhlášen/a.\"); window.location.href=\"/index.php\"</script>";
    exit;
}
else {
    $_SESSION['logout_time'] = time();
}

/**
 * @brief Makes HTML head of view and sets window title.
 *
 * @param string $title Window title.
 * @return void
 */
function make_header(string $title): void
{
    $domain = 'http://localhost:8080';
    ?>
    <!DOCTYPE html>
    <html lang="cs">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="icon" type="image/x-icon" href="<?= $domain . '/public/scheduler_icon.ico' ?>">
        <link rel="stylesheet" href="<?= $domain . '/public/style.css' ?>">
        <script src="<?= $domain . '/public/validateForm.js' ?>"></script>
        <title>SPVR | <?= $title; ?></title>
    </head>
    <body>
    <div class="container">
    <?php

}

/**
 * @brief Makes footer with authors below <body> element on every page.
 *
 * @return void
 */
function make_footer(): void
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

/**
 * @brief Auxiliary function for returning "selected" option in dropdowns.
 *
 * @param string $option Option that is searched for.
 * @param string $to_check Current dropdown option.
 * @return string "Selected" for matching option.
 */
function checkSelect($option, $to_check): string
{
    if ($option == $to_check) {
        return "selected";
    }
    else {
        return "";
    }
}

/**
 * @brief Auxiliary function for mapping role abbreviations to full-named fields.
 * Used for better displaying on pages.
 *
 * @param string $input Role to match.
 * @return string Mapped role.
 */
function roleName(string $input): string
{
    return match ($input) {
        "admi" => "Administrátor",
        "stud" => "Student",
        "vyuc" => "Vyučující",
        "rozv" => "Rozvrhář",
        "gara" => "Garant",
        default => $input,
    };
}

/**
 * @brief Auxiliary function for not having to write html elements.
 * @return string Span class required.
 */
function requiredField(): string
{
    return '<span class="required">*</span>';
}
