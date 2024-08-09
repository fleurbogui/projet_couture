<!DOCTYPE html>
<html>
<head>
    <title>Despo Couture - Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Despo Couture</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="commande.php">Passer une commande</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container p-4">
        <?php
            include_once("utils.php");

            showMessage();
        ?>
        <h2>Commander</h2>
        <form action="traitement_commande.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="clientFirstName">Nom</label>
                <input type="text" class="form-control" id="clientFirstName" name="clientFirstName"
                       required placeholder="John">
            </div>
            <div class="form-group">
                <label for="clientLastName">Prénoms</label>
                <input type="text" class="form-control" id="clientLastName" name="clientLastName"
                       required placeholder="Doe">
            </div>
            <div class="form-group">
                <label for="clientSexe">Sexe</label>
                <select class="form-control" id="clientSexe" name="clientSexe" required>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div> 
            <div class="form-group">
                <label for="clientEmail">Email</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail"
                       required placeholder="johndoe@gmail.com">
            </div>            
            <div class="form-group">
                <label for="clientContact">Numéro</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">+225</div>
                    </div>
                    <input type="text" class="form-control" id="clientContact" placeholder="0101010101"
                           minlength="10"  maxlength="10" name="clientContact">
                </div>
            </div>
            <div class="form-group">
                <label for="clientAddress">Adresse</label>
                <input type="text" class="form-control" id="clientAddress" name="clientAddress"
                       required placeholder="Cocody, Abidjan, Côte d'Ivoire">
            </div>
            <div class="form-group">
                <label for="commandeLibelle">Description de la commande</label>
                <input type="text" class="form-control" id="commandeLibelle" name="commandeLibelle"
                       required placeholder="Robe de soirée avec tissu">
            </div>
            <div class="form-group">
                <label for="commandeAge">Age</label>
                <select class="form-control" id="commandeAge" name="commandeAge" required>
                    <option value="A">Adulte</option>
                    <option value="E">Enfant</option>
                </select>
            </div>
            <div class="form-group">
                <label for="modeleLibelle">Libellé du modèle</label>
                <input type="text" class="form-control" id="modeleLibelle" name="modeleLibelle"
                       required placeholder="Robe de soirée">
                <label for="modelePhoto">Photo du modèle</label>
                <input type="file" class="form-control-file" id="modelePhoto" name="modelePhoto"
                       required accept=".png, .jpg, .jpeg">
            </div>
            <div class="form-group">
                <label for="tissuLibelle">Libellé du tissu</label>
                <input type="text" class="form-control" id="tissuLibelle" name="tissuLibelle"
                       required placeholder="Soie">
                <label for="tissuPhoto">Photo du tissu</label>
                <input type="file" class="form-control-file" id="tissuPhoto" name="tissuPhoto"
                       required accept=".png, .jpg, .jpeg">
            </div>
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>
    <footer class="text-center p-3 bg-dark text-white">
        © 2024, Despo Couture. Tous droits réservés.
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>