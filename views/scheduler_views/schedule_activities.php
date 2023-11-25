<?php
require_once "../../common.php";
require_once "../../services/activity_service.php";
require_once "../../controllers/activity_controllers/activities_list.php";
require_once "../../controllers/request_controllers/requests_list.php";

make_header("Razeni aktivit");
?>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<h1>
    Razeni vyukovych aktivit
</h1>

<h2>
    Aktivity
</h2>

<table>
    <tr>
        <th>Predmet</th>
        <th>Typ</th>
        <th>Delka v hodinach</th>
        <th>Pozadavek</th>
        <th>Opakovani</th>
        <th>Mistnost</th>
        <th>Den</th>
        <th>Start</th>
        <th>Vyucujici</th>
    </tr>
<?= listActivity(); ?>
</table>

<?php
make_footer();
?>
