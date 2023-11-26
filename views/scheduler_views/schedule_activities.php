<?php
require_once "../../common.php";
require_once "../../services/activity_service.php";
require_once "../../controllers/activity_controllers/activities_list.php";
require_once "../../controllers/request_controllers/requests_list.php";

make_header("Řazení aktivit");
?>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<h1>
    Řazení výukových aktivit
</h1>

<h2>
    Aktivity
</h2>

<table>
    <tr>
        <th>Předmět</th>
        <th>Typ</th>
        <th>Délka v hodinach</th>
        <th>Požadavek</th>
        <th>Opakování</th>
        <th>Místnost</th>
        <th>Den</th>
        <th>Start</th>
        <th>Vyučující</th>
    </tr>
<?= listActivity(); ?>
</table>

<?php
make_footer();
?>
