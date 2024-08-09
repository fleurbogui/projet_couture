<?php
    include_once("utils.php");

    function createEmploye($nom, $prenom, $email, $tel, $adresse, $poste)
    {
        global $bd;
        $create = $bd->prepare("INSERT INTO employe (NomEmp, PrenEmp, EmailEmp, ContEmp, AdressEmp, PosteEmp) VALUES(?, ?, ?, ?, ?, ?)");
        $sql = $create->execute([$nom, $prenom, $email, $tel, $adresse, $poste]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editEmploye($id, $nom, $prenom, $email, $tel, $adresse, $poste)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE employe SET NomEmp = ?, PrenEmp = ?, EmailEmp = ?, ContEmp = ?, AdressEmp = ?, PosteEmp = ? WHERE IdEmp = ?");
        $sql = $edit->execute([$nom, $prenom, $email, $tel, $adresse, $poste, $id]);
        if($sql)
        {
            return true;
        }
    }

    function deleteEmploye($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM employe WHERE IdEmp = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getEmployes()
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM employe");
        $req->execute();
        $result = $req->fetchAll();
        if($result)
            return $result;
        else
            return null;
    }

    function getEmployeById($id)
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM employe WHERE IdEmp = ?");
        $req->execute([$id]);
        $result = $req->fetch();
        if($result)
            return $result;
        else
            return null;
    }
?>