<?php
require_once "../../common.php";
require_once "../../services/activity_service.php";
require_once "../../controllers/activity_controllers/activities_list.php";

make_header("Razeni aktivit");

echo toMainPage();
?>

<h1>
    Razeni vyukovych aktivit
</h1>

<table>
    <tr>
        <th>Predmet</th>
        <th>Typ</th>
        <th>Delka v hodinach</th>
        <th>Pozadavek</th>
        <th>Opakovani</th>
        <th>Mistnost</th>
        <th>Start</th>
    </tr>
<?php
echo listActivity();
?>
</table>

<?php
make_footer();