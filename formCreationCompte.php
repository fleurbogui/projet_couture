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
    <title>Despo Couture - Création de compte</title>
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
        <h2>Création de compte</h2>
        <form method="post" action="#">
            <?php
                if($_SERVER["REQUEST_METHOD"] == 'GET')
                {
                    include_once ("employe.php");

                    $employes = getEmployes();

                    echo "<div class='form-group'>";
                    echo "<label for='username'>Nom d'utilisateur</label>";
                    echo "<input type='text' class='form-control' id='username' name='username' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo  "<label for='password'>Mot de passe</label>";
                    echo "<input type='password' class='form-control' id='password' name='password' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='password2'>Confirmer le mot de passe</label>";
                    echo "<input type='password' class='form-control' id='password2' name='password2' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='role'>Rôle</label>";
                    echo "<select class='form-control' name='role'>";
                    echo "<option value='admin'>Administrateur</option>";
                    echo "<option value='user'>Utilisateur</option>";
                    echo "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='employe'>Employé</label>";
                    echo "<select class='form-control' id='employe' name='employe'>";
                    foreach ($employes as $employe)
                    {
                        echo "<option value='".$employe['IdEmp']."'>".$employe['NomEmp']." ".$employe['PrenEmp']."</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary'>Créer le compte</button>";
                }
            ?>
        </form>
    </div>
    <footer class="text-center p-3 bg-dark text-white mt-auto">
        © 2024, Despo Couture. Tous droits réservés.
    </footer>
    <?php
        include_once("compte.php");
        include_once("utils.php");

        if($_SERVER["REQUEST_METHOD"] == 'POST')
        {
            if(isset($_POST['username']) &&
                isset($_POST['password']) &&
                isset($_POST['password2']) &&
                isset($_POST['role']) &&
                isset($_POST['employe']))
            {
                if($_POST['password'] != $_POST['password2'])
                {
                    sendMessage("Les mots de passe ne correspondent pas", "error", "formCreationCompte.php");
                    exit();
                }

                $username = $_POST['username'];
                $password = $_POST['password'];
                $role = $_POST['role'];
                $idEmploye = $_POST['employe'];

                if(createCompte($username, $password, $role, $idEmploye))
                {
                    sendMessage("Compte créé avec succès", "success", "gestionComptes.php");
                }
                else
                {
                    if(checkIfUsernameExists($username))
                    {
                        sendMessage("Nom d'utilisateur déjà utilisé", "error", "formCreationCompte.php");
                    }
                    else
                    {
                        sendMessage("Erreur lors de la création du compte", "error", "formCreationCompte.php");
                    }
                }
            }
            else
            {
                sendMessage("Veuillez remplir tous les champs", "error", "formCreationCompte.php");
            }
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
