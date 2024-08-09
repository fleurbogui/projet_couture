<?php

    include_once("client.php");
    include_once("modele.php");
    include_once("tissu.php");
    include_once("commande.php");
    include_once("utils.php");

    
    
    if($_SERVER["REQUEST_METHOD"] === "POST")
    {

        
        if(!isset($_POST["clientFirstName"]) ||
            !isset($_POST["clientLastName"]) ||
            !isset($_POST["clientSexe"]) ||
            !isset($_POST["clientEmail"]) ||
            !isset($_POST["clientContact"]) ||
            !isset($_POST["clientAddress"]) ||
            !isset($_POST["commandeLibelle"]) ||
            !isset($_POST["commandeAge"]) ||
            !isset($_POST["modeleLibelle"]) ||
            !isset($_POST["tissuLibelle"]) ||
            !isset($_FILES["modelePhoto"]) ||
            !isset($_FILES["tissuPhoto"]))            
        {
            sendMessage("Veuillez remplir tous les champs.", "error", "formcommande.php");
            exit();
        }

        $clientFirstName = $_POST["clientFirstName"];
        $clientLastName = $_POST["clientLastName"];
        $clientEmail = $_POST["clientEmail"];
        $clientSexe = $_POST["clientSexe"];
        $clientContact = $_POST["clientContact"];
        $clientAddress = $_POST["clientAddress"];
        $commandeLibelle = $_POST["commandeLibelle"];
        $commandeAge = $_POST["commandeAge"];
        $modeleLibelle = $_POST["modeleLibelle"];
        $tissuLibelle = $_POST["tissuLibelle"];

        if($clientSexe !== "M" && $clientSexe !== "F")
        {
            sendMessage("Veuillez sélectionner un sexe valide.", "error", "formcommande.php");
            exit();
        }

        if(!filter_var($clientEmail, FILTER_VALIDATE_EMAIL))
        {
            sendMessage("Veuillez saisir une adresse email valide.", "error", "formcommande.php");
            exit();
        }
        
        if(strlen($clientContact) != 10 || !preg_match("/^[0-9]{10}$/", $clientContact))
        {
            sendMessage("Veuillez saisir un numéro de téléphone valide.", "error", "formcommande.php");
            exit();
        }

        $modelePhoto = $_FILES["modelePhoto"];
        $modelePhotoFileName = $modelePhoto["name"];
        $modelePhotoFileType = $modelePhoto["type"];
        $modelePhotoFileSize = $modelePhoto["size"];
        $modelePhotoFileTmpName = $modelePhoto["tmp_name"];
        $modelePhotoFileError = $modelePhoto["error"];

        $modelePhotoFileExt = explode(".", $modelePhotoFileName);
        $modelePhotoFileActualExt = strtolower(end($modelePhotoFileExt));

        $tissuPhoto = $_FILES["tissuPhoto"];
        $tissuPhotoFileName = $tissuPhoto["name"];
        $tissuPhotoFileType = $tissuPhoto["type"];
        $tissuPhotoFileSize = $tissuPhoto["size"];
        $tissuPhotoFileTmpName = $tissuPhoto["tmp_name"];
        $tissuPhotoFileError = $tissuPhoto["error"];

        $tissuPhotoFileExt = explode(".", $tissuPhotoFileName);
        $tissuPhotoFileActualExt = strtolower(end($tissuPhotoFileExt));

        $allowed = ["jpg", "jpeg", "png"];

        if(in_array($modelePhotoFileActualExt, $allowed) && in_array($tissuPhotoFileActualExt, $allowed))
        {
            if($modelePhotoFileError === 0 && $tissuPhotoFileError === 0)
            {
                if($modelePhotoFileSize < 10000000 && $tissuPhotoFileSize < 10000000)
                {
                    $clientContact = "+225".$clientContact;

                    $clientId = createClient($clientFirstName, $clientLastName, $clientSexe, $clientEmail, $clientContact, $clientAddress);

                    if($clientId != null)
                    {
                        $uniqueId = md5(uniqid());
                        $modelePhotoFileDestination = "uploads/".$uniqueId.".".$modelePhotoFileActualExt;
                        $uniqueId = md5(uniqid());
                        $tissuPhotoFileDestination = "uploads/".$uniqueId.".".$tissuPhotoFileActualExt;

                        move_uploaded_file($modelePhotoFileTmpName, $modelePhotoFileDestination);
                        move_uploaded_file($tissuPhotoFileTmpName, $tissuPhotoFileDestination);

                        $modeleId = createModele($modeleLibelle, $modelePhotoFileDestination);
                        $tissuId = createTissu($tissuLibelle, $tissuPhotoFileDestination);

                        if($clientId === null || $modeleId === null || $tissuId === null)
                        {
                            sendMessage("Une erreur s'est produite lors de la création de votre commande. Veuillez réessayer.",
                                "error", "formcommande.php");
                        }

                        if(createCommande($commandeLibelle, $commandeAge, $clientId, $modeleId, $tissuId) != null)
                        {
                            sendMessage("Votre commande a été soumise avec succès.",
                                "success", "formcommande.php");
                        }
                        else
                        {
                            sendMessage("Une erreur s'est produite lors de la soumission de votre commande. Veuillez réessayer.",
                                "error", "formcommande.php");
                        }
                    }
                    else
                    {
                        if(checkIfContactExists($clientContact))
                        {
                            sendMessage("Un compte existe déjà avec ce numéro de téléphone. Veuillez réessayer.",
                                "error", "formcommande.php");
                        }
                        else if(checkIfEmailExists($clientEmail))
                        {
                            sendMessage("Un compte existe déjà avec cet email. Veuillez réessayer.",
                                "error", "formcommande.php");
                        }
                        else
                        {
                            sendMessage("Une erreur s'est produite lors de la création de votre compte. Veuillez réessayer.",
                                "error", "formcommande.php");
                        }
                    }
                }
                else
                {
                    sendMessage("Chaque fichier ne doit pas faire plus de 10 Mo.", "error", "formcommande.php");
                }
            }
            else
            {
                sendMessage("Une erreur s'est produite lors du téléchargement de votre fichier. Veuillez réessayer",
                    "error", "formcommande.php");
            }
        }
        else
        {
            sendMessage("Seuls les fichiers de type JPG, JPEG et PNG sont autorisés.", "error",
                "formcommande.php");
        }
    }

?>