<?php 

    require_once("templates/header.php");

    if ($user_dao) {

        $user_dao->destroyToken();

    }