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
    <title>Despo Couture - Modification de commande</title>
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
        <h2>Modification de commande</h2>
        <form method="post" action="#">
            <?php
            include_once("commande.php");
            include_once("client.php");
            include_once("modele.php");
            include_once("tissu.php");
            include_once("utils.php");

            if($_SERVER["REQUEST_METHOD"] == 'GET') {
                if (!isset($_GET['ref']) || !is_numeric($_GET['ref'])) {
                    sendMessage("Référence de commande incorrecte", "error", "formEditCommande.php");
                    exit();
                }
                $commande = getCommandeById($_GET['ref']);

                if ($commande === null) {
                    sendMessage("Commande introuvable", "error", "formEditCommande.php");
                    exit();
                }
                else
                {
                    $clients = getClients();
                    $modeles = getModeles();
                    $tissus = getTissus();
                    $age = ["E", "A"];

                    echo "<input type='hidden' name='id' value='" . $commande['RefCom'] . "'>";
                    echo "<div class='form-group'>";
                    echo "<label for='libelle'>Libellé</label>";
                    echo "<input type='text' class='form-control' id='libelle' name='libelle' required value='" . $commande['LibCom'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='age'>Age</label>";
                    echo "<select class='form-control' id='age' name='age' required>";
                    foreach ($age as $a) {
                        echo "<option value='" . $a . "'";
                        if ($a == $commande['AgeCom']) {
                            echo " selected";
                        }
                        if($a == "E")
                            echo ">Enfant</option>";
                        else
                            echo ">Adulte</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='client'>Client</label>";
                    echo "<select class='form-control' id='client' name='client' required>";
                    foreach ($clients as $client) {
                        echo "<option value='" . $client['IdClit'] . "'";
                        if ($client['IdClit'] == $commande['IdClit']) {
                            echo " selected";
                        }
                        echo ">" . $client['NomClit'] . " " . $client['PrenClit'] . "</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='modele'>Modèle</label>";
                    echo "<select class='form-control' id='modele' name='modele' required>";
                    foreach ($modeles as $modele) {
                        echo "<option value='" . $modele['RefModel'] . "'";
                        if ($modele['RefModel'] == $commande['RefModel']) {
                            echo " selected";
                        }
                        echo ">" . $modele['LibModel'] . "</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='tissu'>Tissu</label>";
                    echo "<select class='form-control' id='tissu' name='tissu' required>";
                    foreach ($tissus as $tissu) {
                        echo "<option value='" . $tissu['RefTis'] . "'";
                        if ($tissu['RefTis'] == $commande['RefTis']) {
                            echo " selected";
                        }
                        echo ">" . $tissu['LibTis'] . "</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-warning'>Modifier</button>";
                }
            }
            ?>
        </form>
    </div>

    <footer class="text-center p-3 bg-dark text-white mt-auto">
        © 2024, Despo Couture. Tous droits réservés.
    </footer>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == 'POST')
        {
            include_once ("commande.php");
            include_once ("utils.php");

            if (isset($_POST['id']) && isset($_POST['libelle']) && isset($_POST['age']) && isset($_POST['client']) && isset($_POST['modele']) && isset($_POST['tissu']))
            {
                $id = $_POST['id'];
                $libelle = $_POST['libelle'];
                $client = $_POST['client'];
                $modele = $_POST['modele'];
                $tissu = $_POST['tissu'];
                $age = $_POST['age'];

                if (is_numeric($id) && is_numeric($client) && is_numeric($modele) && is_numeric($tissu))
                {
                    if (editCommande($id, $libelle, $age,$client, $modele, $tissu))
                    {
                        sendMessage("Commande modifiée avec succès", "success", "gestionCommandes.php");
                    } else {
                        sendMessage("Erreur lors de la modification de la commande", "error", "formEditCommande.php");
                    }
                } else {
                    sendMessage("Données invalides", "error", "formEditCommande.php");
                }
            }
            else
            {
                sendMessage("Données manquantes", "error", "formEditCommande.php");
            }
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>