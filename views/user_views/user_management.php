<?php

require_once "../../common.php";
require_once "../../controllers/user_controllers/user_load.php";
require_once "../../services/user_service.php";

make_header("sprava uzivatelu");
?>

<?= toMainPage(); ?>

<h2>Registrace uzivatele</h2>
<form action="../../controllers/user_controllers/user_register.php" method="post">
    <label for="jmeno">Jmeno</label>
    <input type="text" name="jmeno" id="jmeno"><br>

    <label for="prijmeni">Prijmeni</label>
    <input type="text" name="prijmeni" id="prijmeni"><br>

    <label for="email">Email</label>
    <input type="email" name="email" id="email"><br>

    <label for="heslo">Password</label>
    <input type="password" name="heslo" id="heslo"><br>

    <label for="telefon">Telefon</label>
    <input type="tel" id="telefon" name="telefon"><br>

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="admi">Admin</option>
        <option value="stud" selected>Student</option>
        <option value="vyuc">Vyucujici</option>
        <option value="rozv">Rozvrhar</option>
        <option value="gara">Garant</option>
    </select><br>

    <input type="submit" value="Create new user">
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
