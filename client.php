<?php
    include_once("utils.php");
    
    function createClient($nom, $prenom, $sexe, $email, $contact, $adresse)
    {
        if(checkIfContactExists($contact))
        {
            return null;
        }
        if(checkIfEmailExists($email))
        {
            return null;
        }
        global $bd;
        $create = $bd->prepare("INSERT INTO client (NomClit, PrenClit, SexeClit, EmailClit, ContClit, AdressClit) 
        VALUES(?, ?, ?, ?, ?, ?)");
        $sql = $create->execute([$nom, $prenom, $sexe, $email, $contact, $adresse]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editClient($id, $nom, $prenom, $sexe, $email, $contact, $adresse)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE client SET NomClit = ?, PrenClit = ?, SexeClit = ?, 
        EmailClit = ?, ContClit = ?, AdressClit = ? WHERE IdClit = ?");
        $sql = $edit->execute([$nom, $prenom, $sexe, $email, $contact, $adresse, $id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function deleteClient($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM client WHERE IdClit = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getClientIdByEmail($email)
    {
        global $bd;
        $query = $bd->prepare("SELECT IdClit FROM client WHERE EmailClit = ?");
        $query->execute([$email]);
        $result = $query->fetch();
        if($result)
        {
            return $result["IdClit"];
        }
        return null;        
    }

    function getClients()
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM client");
        $query->execute();
        $result = $query->fetchAll();
        if($result)
        {
            return $result;
        }
        return null;
    }

    function getClientById($id)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM client WHERE IdClit = ?");
        $query->execute([$id]);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return null;
    }

    function checkIfContactExists($contact)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM client WHERE ContClit = ?");
        $query->execute([$contact]);
        $result = $query->fetch();
        if($result)
        {
            return true;
        }
        return false;
    }

    function checkIfEmailExists($email)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM client WHERE EmailClit = ?");
        $query->execute([$email]);
        $result = $query->fetch();
        if($result)
        {
            return true;
        }
        return false;
    }
?>