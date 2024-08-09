<?php
    include_once("utils.php");
    if(!checkConnected())
    {
        sendMessage("Vous devez être connecté pour accéder à cette page.", "error", "connexion.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Despo Couture - Création de mesure</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="gestionIndex.php">Despo Couture - Gestion</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Retour à l'accueil</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        Gestion
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="gestionComptes.php">Gestion des comptes</a>
                        <a class="dropdown-item" href="gestionCommandes.php">Gestion des commandes</a>
                        <a class="dropdown-item" href="gestionClients.php">Gestion des clients</a>
                        <a class="dropdown-item" href="gestionTissus.php">Gestion des tissus</a>
                        <a class="dropdown-item" href="gestionModeles.php">Gestion des modèles</a>
                        <a class="dropdown-item" href="gestionMesures.php">Gestion des mesures</a>
                        <a class="dropdown-item" href="gestionEmployes.php">Gestion des employés</a>
                        <a class="dropdown-item" href="gestionRendezvous.php">Gestion des rendez-vous</a>
                        <a class="dropdown-item" href="gestionFactures.php">Gestion des factures</a>
                    </div>
                </li>
            </ul>
            <a href="traitement_deconnexion.php" class="btn btn-danger ml-auto">Déconnexion</a>
        </div>
    </nav>
    <div class="container p-4">
        <?php
            include_once ("utils.php");
            showMessage();
        ?>
        <h2>Création de mesure</h2>
        <form method="post" action="#">
            <?php
                include_once("mesure.php");
                include_once("client.php");
                include_once("commande.php");
                include_once("utils.php");

                if($_SERVER["REQUEST_METHOD"] == 'GET')
                {
                    $MesClit = 0;

                    if(!isset($_GET['refCom']) && !is_numeric($_GET['refCom']))
                    {
                        sendMessage("Référence de commande incorrecte", "error", "formCreateMesure.php");
                        exit();
                    }
                    else
                    {
                        $commande = getCommandeById($_GET['refCom']);
                        if ($commande === null)
                        {
                            sendMessage("Commande introuvable", "error", "formCreateMesure.php");
                            exit();
                        }
                        else
                        {
                            $MesClit = getClientById($commande['IdClit']);

                            if ($MesClit === null)
                            {
                                sendMessage("Client introuvable", "error", "formCreateMesure.php");
                                exit();
                            }
                            else
                            {
                                $clients = getClients();
                                $mesuresDefaultDict = getMesureDefaultDict($commande["AgeCom"], $MesClit['SexeClit']);

                                echo "<input type='hidden' name='refCom' value='".$commande['RefCom']."'>";
                                echo "<div class='form-group'>";
                                echo "<label for='client'>Client</label>";
                                echo "<input type='text' class='form-control' id='client' name='client' required value='".$MesClit['NomClit']." ".$MesClit['PrenClit']. "' readonly>";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                echo "<label for='type'>Type de mesure</label>";
                                if($commande['AgeCom'] == "A")
                                    if($MesClit['SexeClit'] == "M")
                                        echo "<input type='text' class='form-control' id='type' name='type' required value='Homme adulte' readonly>";
                                    else
                                        echo "<input type='text' class='form-control' id='type' name='type' required value='Femme adulte' readonly>";
                                else
                                    echo "<input type='text' class='form-control' id='type' name='type' required value='Enfant' readonly>";
                                echo "</div>";
                                echo "<table class='table'>";
                                echo "<thead>
                                        <tr>
                                            <th scope='col'>Mesure</th>
                                            <th scope='col'>Valeur</th>
                                        </tr>
                                    </thead>";
                                echo "<tbody>";
                                foreach ($mesuresDefaultDict as $mesure)
                                {
                                    echo "<tr>";
                                    echo "<td>".$mesure['label']."</td>";
                                    echo "<td><input type='number' class='form-control'  min='0' max='100' name=\"".$mesure['label']."\" value='".$mesure['value']."' required></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                echo "<button type='submit' class='btn btn-primary'>Enregistrer</button>";
                            }
                        }
                    }
                }
            ?>
        </form>

    </div>

    <footer class="text-center p-3 bg-dark text-white mt-auto">
        © 2024, Despo Couture. Tous droits réservés.
    </footer>
    <?php
        if($_SERVER["REQUEST_METHOD"] == 'POST')
        {
            $mesures = [];
            $commande = getCommandeById($_POST['refCom']);
            $MesClit = getClientById($commande['IdClit']);
            $mesuresDefaultDict = getMesureDefaultDict($commande["AgeCom"], $MesClit['SexeClit']);

            foreach ($mesuresDefaultDict as $mesure)
            {
                $mesures[] = array(
                    "label" => $mesure['label'],
                    "value" => $_POST[str_replace(" ", "_", $mesure['label'])]
                );
            }

            if(createMesure(json_encode($mesures, JSON_UNESCAPED_UNICODE), $MesClit['IdClit']) != null)
            {
                sendMessage("Mesure enregistrée avec succès", "success", "gestionMesures.php");
            }
            else
            {
                sendMessage("Erreur lors de l'enregistrement de la mesure", "error", "formCreateMesure.php");
            }
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

