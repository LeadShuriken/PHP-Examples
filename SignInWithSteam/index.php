<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include("src/SignInWithSteam.php");
        $signIn = new SignInWithSteam();

        $signIn->LoginCallback(function($steamid) {
            return true;
        });

        $signIn->LogoutCallback(function($steamid) {
            return true;
        });

        $signIn->Init();

        if (isset($_POST['logout'])) {
            $signIn->Logout();

        if ($signIn->IsUserLoggedIn()) {
            echo "Your SteamTokenID is " . $signIn->GetStemToken() . "<br/>";
            echo "<form method=\"POST\"><input type=\"submit\" name=\"logout\" value=\"Logout\" /></form>";
        } else {
            // Display login button
            echo "<a href=\"" . $signIn->GetLoginURL() . "\"><img src=\"img/sits.png\" /></a>";
        }
        ?>
    </body>
</html>
