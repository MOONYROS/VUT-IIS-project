<?php
require '../common.php';
require '../services/user_service.php';

// Zde můžete přidat ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Přesměrování na přihlašovací stránku
    exit;
}

$service = new UserService();
$user = $service->getUserById($_SESSION['user_id']);

make_header('Hlavní stránka');
?>

<h1>Vítejte v systému</h1>
<p>Přihlášen jako: <b><?= roleName($user['role']); ?></b></p>
<p>Toto je hlavní stránka. Račte se odnavigovat.</p>

<nav>
    <ul>
        <li><a href="subject_management.php">Spravovat předměty</a></li>
        <li><a href="room_management.php">Spravovat místnosti</a></li>
        <li><a href="user_management.php">Spravovat uživatele</a></li>
        <li><a href="activity_management.php">Spravovat výukové aktitity</a></li>
        <li><a href="subject_registration.php">Registrace předmětů</a></li>
    </ul>
</nav>

<?php
make_footer();
?>

