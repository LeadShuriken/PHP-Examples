<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("openid.php");

/**
 * Description of SteamAuth
 *
 * @author dsmis
 */
if (session_id() == '') {
    session_start();
}

class SignInWithSteam {

    private $OpenID;
    private $OnLoginCallback;
    private $OnLogoutCallback;
    private $OnLoginFailedCallback;
    private $SteamTokenID;

    public function __construct($ServerName = 'DEFAULT') {
        if ($ServerName = 'DEFAULT')
            $ServerName = $_SERVER['SERVER_NAME'];

        $this->OpenID = new LightOpenID($ServerName);
        $this->OpenID->identity = 'http://steamcommunity.com/openid';
    }

    public function Init() {
        if ($this->IsUserLoggedIn()) {
            $this->SteamTokenID = $_SESSION['steamid'];
            return;
        }

        if ($this->OpenID->mode == 'cancel') {
            $this->OnLoginFailedCallback();
        } else if ($this->OpenID->mode) {
            if ($this->OpenID->validate()) {
                $this->SteamTokenID = basename($this->OpenID->identity);
                if ($this->OnLoginCallback()) {
                    $_SESSION['steamid'] = $this->SteamTokenID;
                }
            } else {
                $this->OnLoginFailedCallback();
            }
        }
    }

    public function __call($closure, $args) {
        return call_user_func_array($this->$closure, $args);
    }

    public function IsUserLoggedIn() {
        return (isset($_SESSION['steamid']) && (strpos($_SESSION['steamid'], "7656") === 0));
    }

    public function GetLoginURL() {
        return $this->OpenID->authUrl();
    }

    public function GetStemToken() {
        return $this->SteamTokenID;
    }

    public function Logout() {
        $this->OnLogoutCallback();
        unset($_SESSION['steamid']);
        header("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    public function LoginCallback($OnLoginCallback) {
        $this->OnLoginCallback = $OnLoginCallback;
    }

    public function LogoutCallback($OnLogoutCallback) {
        $this->OnLogoutCallback = $OnLogoutCallback;
    }

    public function LoginFailedCallback($OnLoginFailedCallback) {
        $this->OnLoginFailedCallback = $OnLoginFailedCallback;
    }
}
