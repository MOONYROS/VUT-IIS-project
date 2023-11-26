<?php

require_once "../../common.php";
require_once "../../controllers/user_controllers/user_load.php";
require_once "../../services/user_service.php";

make_header("Správa uživatelů");
?>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<script>
    let fields = ['jmeno', 'prijmeni', 'email', 'heslo', 'telefon'];
</script>

<h2>Registrace uživatele</h2>
<form action="../../controllers/user_controllers/user_register.php" method="post" onsubmit="return validateForm(fields);">
    <label for="jmeno">Jméno<?= requiredField(); ?></label>
    <input type="text" name="jmeno" id="jmeno"><br>

    <label for="prijmeni">Příjmení<?= requiredField(); ?></label>
    <input type="text" name="prijmeni" id="prijmeni"><br>

    <label for="email">Email<?= requiredField(); ?></label>
    <input type="email" name="email" id="email"><br>

    <label for="heslo">Heslo<?= requiredField(); ?></label>
    <input type="password" name="heslo" id="heslo"><br>

    <label for="telefon">Telefon<?= requiredField(); ?></label>
    <input type="tel" id="telefon" name="telefon"><br>

    <label for="role">Role<?= requiredField(); ?></label>
    <select id="role" name="role">
        <option value="admi">Admin</option>
        <option value="stud" selected>Student</option>
        <option value="vyuc">Vyučující</option>
        <option value="rozv">Rozvrhář</option>
    </select><br>

    <input type="submit" value="Vytvořit nového uživatele">
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
    Správa Uživatelů
</h2>

<div>
    <table>
        <tr>
            <th>Příjmení a jméno</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Role</th>
        </tr>
        <?php

        $service = new userService();
        $userIDs = $service->getUserIDs();
        foreach($userIDs as $ID) {
            echo '<tr>' . loadUser($ID) . '</tr>';
        }
        ?>
    </table>
</div>

<?php
make_footer();
?>
