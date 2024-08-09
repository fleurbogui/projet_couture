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
    <title>Despo Couture - Création de rendez-vous</title>
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
        <h2>Création de rendez-vous</h2>
        <form method="post" action="#">
            <?php
                include_once("rendezvous.php");
                include_once("client.php");
                include_once("utils.php");

                if($_SERVER["REQUEST_METHOD"] == 'GET')
                {
                    $RdvClit = 0;
                    $clients = getClients();
                    if(isset($_GET["client"]))
                    {
                        $RdvClit = $_GET["client"];
                    }
                    echo "<div class='form-group'>";
                    echo "<label for='client'>Client</label>";
                    echo "<select class='form-control' id='client' name='client'>";
                    foreach($clients as $client)
                    {
                        echo "<option value='".$client["IdClit"]."'";
                        if($client["IdClit"] == $RdvClit)
                        {
                            echo " selected";
                        }
                        echo ">".$client["NomClit"]." ".$client["PrenClit"]."</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='libelle'>Libellé</label>";
                    echo "<input type='text' class='form-control' id='libelle' name='libelle' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='date'>Date</label>";
                    echo "<input type='datetime-local' class='form-control' id='date' name='date' required>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary'>Créer</button>";
                }
             ?>
    </div>

    <footer class="text-center p-3 bg-dark text-white mt-auto">
        © 2024, Despo Couture. Tous droits réservés.
    </footer>
    <?php
        if($_SERVER["REQUEST_METHOD"] == 'POST')
        {
            include_once("rendezvous.php");
            include_once("utils.php");

            if(isset($_POST['client']) && isset($_POST['libelle']) && isset($_POST['date']))
            {
                $idClient = $_POST['client'];
                $libelle = $_POST['libelle'];
                $date = $_POST['date'];
                $idEmploye = getIdEmpFromConnectedAccount();

                if(createRdv($libelle, $date, $idEmploye, $idClient))
                {
                    sendMessage("Rendez-vous créé avec succès", "success", "gestionRendezvous.php");
                }
                else
                {
                    sendMessage("Erreur lors de la création du rendez-vous", "error", "formCreateRdv.php");
                }
            }
            else
            {
                sendMessage("Veuillez remplir tous les champs", "error", "formCreateRdv.php");
            }
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
