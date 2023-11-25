<?php
require_once '../common.php';
require_once '../services/user_service.php';
require_once '../controllers/main_page_controller.php';

// Zde můžete přidat ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Přesměrování na přihlašovací stránku
    exit;
}

$service = new userService();
$user = $service->getUserById($_SESSION['user_id']);

make_header('Hlavní stránka');
?>
<a class="direct_link" id="logout" href="/controllers/logout.php">Odhlásit se</a>

<h1>
    Vítejte v systému pro vytváření rozvrhů
</h1>

<p>Přihlášen jako: <b><?= $user["jmeno"] . " " . $user["prijmeni"] . "</b> (" . roleName($user['role']); ?>)</p>

<p>Toto je hlavní stránka. Račte se odnavigovat.</p>

<nav>
    <?php
    switch ($user["role"]) {
        case "admi": {
           echo loadAdmin();
           break;
        }
        case "stud": {
            echo loadStudent();
            break;
        }
        case "vyuc": {
            echo loadTeacher();
            break;
        }
        case "rozv": {
            echo loadRozv();
            break;
        }
        default: {
            echo "Yikes neco neni uplne dobre";
            break;
        }
    }
    ?>
</nav>

<?php
make_footer();
?>

