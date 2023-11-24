<?php
require_once "../../common.php";
require_once "../../services/activity_service.php";
require_once "../../controllers/activity_controllers/activities_list.php";
require_once "../../controllers/request_controllers/requests_list.php";

make_header("Razeni aktivit");

echo toMainPage();
?>

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
    </tr>
<?= listActivity(); ?>
</table>

<h2>
    Zadosti vyucujicich
</h2>

<table>
    <tr>
        <th>Predmet</th>
        <th>Jmeno</th>
        <th>Prijmeni</th>
        <th>Zadost</th>
    </tr>
    <?php
    echo listRequests();
    ?>
</table>

<?php
make_footer();