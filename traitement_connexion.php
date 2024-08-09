<?php
    include_once("utils.php");
    include_once("compte.php");

    if($_SERVER["REQUEST_METHOD"] = "POST")
    {
        if (isset($_POST["username"]) && isset($_POST["password"]))
        {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $result = checkIfUserExists($username, $password);
            if ($result[0])
            {
                $compte = getCompteByUsername($username);
                connect($compte);
                sendMessage($result[1], "success", "gestionIndex.php");
            } else
            {
                sendMessage($result[1], "error", "connexion.php");
            }
        }
        else
        {
            sendMessage("Veuillez remplir tous les champs.", "error", "connexion.php");
        }
    }
?>