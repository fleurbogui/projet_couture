<?php
    $bd = new PDO("mysql:host=localhost:3306;dbname=despocouturedevoir",
        "root",
        "");

    function sendMessage($message, $typeMessage, $page)
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        $_SESSION["message"] = $message;
        $_SESSION["typeMessage"] = $typeMessage;
        header("Location: $page");
    }

    function showMessage()
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        if(isset($_SESSION['message']))
        {
            if(isset($_SESSION['typeMessage']) && $_SESSION['typeMessage'] === 'error')
            {
                echo "<div class='alert alert-danger'>".$_SESSION['message']."</div>";
            }
            else
            {
                echo "<div class='alert alert-success'>".$_SESSION['message']."</div>";
            }
            unset($_SESSION['message']);
            unset($_SESSION['typeMessage']);
        }
    }

    function connect($compte)
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        $_SESSION["compte"] = $compte;
    }

    function disconnect()
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        unset($_SESSION["compte"]);
    }

    function checkConnected()
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION["compte"]);
    }

    function getIdEmpFromConnectedAccount()
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return $_SESSION["compte"]["IdEmp"];
    }
?>