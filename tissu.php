<?php
    include_once("utils.php");
    
    function createTissu($libelle, $photo)
    {
        global $bd;
        $create = $bd->prepare("INSERT INTO tissu (LibTis, PhotoTis) VALUES(?, ?)");
        $sql = $create->execute([$libelle, $photo]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editTissu($id, $libelle, $photo)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE tissu SET LibTis = ?, PhotoTis = ? WHERE RefTis = ?");
        $sql = $edit->execute([$libelle, $photo, $id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function deleteTissu($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM tissu WHERE RefTis = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getTissuIdByPhoto($photo)
    {
        global $bd;
        $query = $bd->prepare("SELECT RefTis FROM tissu WHERE PhotoTis = ?");
        $query->execute([$photo]);
        $result = $query->fetch();
        if($result)
        {
            return $result["RefTis"];
        }
        return null;        
    }

    function getTissus()
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM tissu");
        $query->execute();
        $result = $query->fetchAll();
        if($result)
        {
            return $result;
        }
        return null;
    }

    function getTissuById($id)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM tissu WHERE RefTis = ?");
        $query->execute([$id]);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return null;
    }
?>