<?php
    include_once("utils.php");

    function createModele($libelle, $photo)
    {
        global $bd;
        $create = $bd->prepare("INSERT INTO modele (LibModel, PhotoModel) VALUES(?, ?)");
        $sql = $create->execute([$libelle, $photo]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editModele($id, $libelle, $photo)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE modele SET LibModel = ?, PhotoModel = ? WHERE RefModel = ?");
        $sql = $edit->execute([$libelle, $photo, $id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function deleteModele($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM modele WHERE RefModel = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getModeleIdByPhoto($photo)
    {
        global $bd;
        $query = $bd->prepare("SELECT RefModel FROM modele WHERE PhotoModel = ?");
        $query->execute([$photo]);
        $result = $query->fetch();
        if($result)
        {
            return $result["RefModel"];
        }
        return null;        
    }

    function getModeles()
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM modele");
        $query->execute();
        $result = $query->fetchAll();
        if($result)
        {
            return $result;
        }
        return null;
    }

    function getModeleById($id)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM modele WHERE RefModel = ?");
        $query->execute([$id]);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return null;
    }
?>