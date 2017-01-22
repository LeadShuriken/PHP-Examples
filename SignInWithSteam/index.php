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
        <link rel="stylesheet" href="css/main.css" type="text/css">
    </head>
    <body>
        <div>
            <?php
            include("src/SignInWithSteam.class.php");
            $signIn = new SignInWithSteam();

            $signIn->LoginCallback(function() {
                $messege = "LoginCallback: Perform something....";
                echo "<script type=\"text/javascript\"> alert('" . $messege . "'); </script>";
                return true;
            });

            $signIn->LogoutCallback(function() {
                $messege = "LogoutCallback: Perform something....";
                echo "<script type=\"text/javascript\"> alert('" . $messege . "'); </script>";
                return true;
            });

            $signIn->LoginFailedCallback(function() {
                $messege = "LoginFailedCallback: Perform something....";
                echo "<script type=\"text/javascript\"> alert('" . $messege . "'); </script>";
                return true;
            });

            $signIn->Init();

            if (isset($_POST['logout'])) {
                $signIn->Logout();
            }
            if ($signIn->IsUserLoggedIn()) {
                echo "<div class=\"steam-key-token-holder\"><div class=\"steam-key-token\">" . $signIn->GetStemToken() . "</div></div>";
                echo "<form class=\"form-style\" method=\"POST\"><input class=\"logout-image\" type=\"submit\" name=\"logout\" value=\"Logout\" /></form>";
            } else {
                echo "<a class=\"form-style\" href=\"" . $signIn->GetLoginURL() . "\"><img class=\"form-image\" src=\"img/sits.png\" /></a>";
            }
            ?>
        </div>
        <div class="background-holder">
        </div>
    </body>
</html>