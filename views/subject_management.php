<?php
require "../common.php";
make_header("tvorba predmetu");
?>

<?= toMainPage(); ?>

<h2>
   Vytvořit předmět
</h2>

<form action="../controllers/subject_create.php" method="post">
    <label for="nazev">Nazev</label>
    <input type="text" name="nazev" id="nazev"><br>

    <label for="zkratka">Zkratka</label>
    <input type="text" name="zkratka" id="zkratka"><br>

    <label for="anotace">Anotace</label>
    <textarea name="anotace" id="anotace"></textarea><br>

    <label for="pocet_kreditu">Pocet kreditu</label>
    <input type="number" name="pocet_kreditu" id="pocet_kreditu"><br>

    <label for="typ_ukonceni">Typ ukonceni</label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" selected>zapocet</option>
        <option value="klza">kl zapocet</option>
        <option value="zk">zkouska</option>
        <option value="zazk">zapocet zkouska</option>
    </select><br>

    <input type="submit" value="Vytvorit predmet">
</form>
<br>
<div>
    <?php
        if (isset($_GET["message"])) {
            echo $_GET["message"];
        }
    ?>
</div>

<h2>
   Správa předmětů
</h2>

<div>
    <table>
        <tr>
            <th>Zkratka</th>
            <th>Nazev</th>
            <th>Anotace</th>
            <th>Pocet kreditu</th>
            <th>Typ ukonceni</th>
        </tr>
        <?php
        require_once "../services/subject_service.php";
        require "../controllers/subject_load.php";
        $servis = new subjectService();
        $zkratky = $servis->getSubjectIDs();
        foreach($zkratky as $zkratka) {
            echo '<tr>' . loadSubject($zkratka) . '</tr>';
        }
        ?>
    </table>
</div>