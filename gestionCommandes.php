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
    <title>Despo Couture - Gestion des commandes</title>
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
        <h2>Gestion des commandes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Référence</th>
                    <th scope="col">Libellé</th>
                    <th scope="col">Age</th>
                    <th scope="col">Client</th>
                    <th scope="col">Date</th>
                    <th scope="col">Modèle</th>
                    <th scope="col">Tissu</th>
                    <th scope="col">Modification</th>
                    <th scope="col">Suppression</th>
                    <th scope="col">Mesures</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include_once("commande.php");
                    include_once("client.php");
                    include_once("modele.php");
                    include_once("tissu.php");

                    $commandes = getCommandes();

                    if($commandes === null)
                    {
                        echo "<tr><td colspan='6'>Aucune commande trouvée</td></tr>";
                    }
                    else
                    {

                        foreach($commandes as $commande)
                        {
                            $client = getClientById($commande['IdClit']);
                            $modele = getModeleById($commande['RefModel']);
                            $tissu = getTissuById($commande['RefTis']);
                            echo "<tr>";
                            echo "<td>".$commande['RefCom']."</td>";
                            echo "<td>".$commande['LibCom']."</td>";
                            if($commande['AgeCom'] == "A")
                                echo "<td>Adulte</td>";
                            else
                                echo "<td>Enfant</td>";
                            echo "<td>".$client["NomClit"]." ".$client["PrenClit"]."</td>";
                            echo "<td>".$commande['DatePassCom']."</td>";
                            echo "<td>".$modele["LibModel"]."</td>";
                            echo "<td>".$tissu["LibTis"]."</td>";
                            echo "<td><a href='formEditCommande.php?ref=".$commande['RefCom']."' class='btn btn-warning'>Modifier</a></td>";
                            echo "<td><a href='formDeleteCommande.php?ref=".$commande['RefCom']."' class='btn btn-danger'>Supprimer</a></td>";
                            echo "<td><a href='formCreateMesure.php?refCom=".$commande['RefCom']."' class='btn btn-success'>Prendre les mesures</a></td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
        <a href="formCreateCommande.php" class="btn btn-success">Créer une commande</a>
    </div>
    <footer class="text-center p-3 bg-dark text-white mt-auto">
        © 2024, Despo Couture. Tous droits réservés.
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
