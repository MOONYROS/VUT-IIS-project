<?php
require_once '../common.php';
require_once '../services/user_service.php';
require_once '../controllers/main_page_controller.php';

// Zde můžete přidat ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Přesměrování na přihlašovací stránku
    exit;
}

$service = new UserService();
$user = $service->getUserById($_SESSION['user_id']);

make_header('Hlavní stránka');
?>
<a href="/controllers/logout.php">Odhlásit se</a>
<h1>Vítejte v systému</h1>
<p>Přihlášen jako: <b><?= roleName($user['role']); ?></b></p>
<p>Toto je hlavní stránka. Račte se odnavigovat.</p>

<nav>
    <?php
    switch ($user["role"]) {
        case "admi": {
           echo loadAdmin();
           break;
        }
        case "stud": {
            break;
        }
        case "vyuc": {
            break;
        }
        default: {
            break;
        }
    }
    ?>
</nav>

<?php
make_footer();
?>

