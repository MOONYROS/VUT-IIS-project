<?php
require '../common.php';
require '../services/account_service.php';

// Zde můžete přidat ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Přesměrování na přihlašovací stránku
    exit;
}

$service = new AccountService();
$user = $service->getUserById($_SESSION['user_id']);

make_header('Hlavní stránka');
?>

<h1>Vítejte v systému</h1>
<p>Přihlášen jako: <b><?php echo htmlspecialchars($user['role']); ?></b></p>
<p>Toto je hlavní stránka. Račte se odnavigovat.</p>

<nav>
    <ul>
        <li><a href="sprava_predmetu.php">Spravovat předměty</a></li>
        <li>Budou</li>
        <li>Nejake</li>
        <li>Odkazy</li>
    </ul>
</nav>

<?php
make_footer();
?>

