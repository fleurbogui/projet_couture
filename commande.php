<?php
    include_once("utils.php");

    function createCommande($libelle, $age, $idClient, $idModele, $idTissu)
    {
        global $bd;
        $create = $bd->prepare("INSERT INTO commande (LibCom, AgeCom, IdClit, RefModel, RefTis) VALUES(?, ?, ?, ?, ?)");
        $sql = $create->execute([$libelle, $age, $idClient, $idModele, $idTissu]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editCommande($id, $libelle, $age, $idClient, $idModele, $idTissu)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE commande SET LibCom = ?, AgeCom = ?,IdClit = ?, RefModel = ?, RefTis = ? WHERE RefCom = ?");
        $sql = $edit->execute([$libelle, $age, $idClient, $idModele, $idTissu, $id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function deleteCommande($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM commande WHERE RefCom = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getCommandes()
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM commande");
        $query->execute();
        $result = $query->fetchAll();
        if($result)
        {
            return $result;
        }
        return null;
    }

    function getCommandeById($id)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM commande WHERE RefCom = ?");
        $query->execute([$id]);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return null;
    }

    function getCommandesByClient($idClient)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM commande WHERE IdClit = ?");
        $query->execute([$idClient]);
        $result = $query->fetchAll();
        if($result)
        {
            return $result;
        }
        return null;
    }
?>