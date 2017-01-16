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
        include("SteamAuth.php");
        $auth = new SteamAuth();

        $auth->SetOnLoginCallback(function($steamid) {
            return true;
        });

        $auth->SetOnLoginFailedCallback(function() {
            return true;
        });

        $auth->SetOnLogoutCallback(function($steamid) {
            return true;
        });

        $auth->Init();

        if (isset($_POST['logout'])) {
            $auth->Logout(); // The logout function also refreshes the page
        }

        if ($auth->IsUserLoggedIn()) {
            echo "Your SteamID is " . $auth->SteamID . "<br/>";
            // We use POST to logout so people can't embed images to the logout function and annoy people.
            echo "<form method=\"POST\"><input type=\"submit\" name=\"logout\" value=\"Logout\" /></form>";
        } else {
            // Display login button
            echo "<a href=\"" . $auth->GetLoginURL() . "\"><img src=\"assets/sits_large_noborder.png\" alt=\"Sign in through Steam\" /></a>";
        }
        ?>
    </body>
</html>
