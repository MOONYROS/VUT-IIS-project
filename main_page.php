<?php
require 'common.php';

// Zde můžete přidat ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Přesměrování na přihlašovací stránku
    exit;
}

make_header('Hlavní stránka');
?>

<h1>Vítejte v systému</h1>
<p>Toto je hlavní stránka. Račte se odnavigovat.</p>

<nav>
    <ul>
        <li>Tady</li>
        <li>Budou</li>
        <li>Nejake</li>
        <li>Odkazy</li>
    </ul>
</nav>

<?php
make_footer();
?>

