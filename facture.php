<?php
    include_once ("utils.php");

    function createFacture($libelle, $mode, $prix, $dateLiv, $idClit, $idEmp)
    {
        global $bd;
        $create = $bd->prepare("INSERT INTO facture (LibFact, ModePaieFact, PrixFact, DateLivrFact, IdClit, IdEmp) VALUES(?, ?, ?, ?, ?, ?)");
        $sql = $create->execute([$libelle, $mode, $prix, $dateLiv, $idClit, $idEmp]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editFacture($id, $libelle, $mode, $prix, $dateLiv, $idClit, $idEmp)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE facture SET LibFact = ?, ModePaieFact = ?, PrixFact = ?, DateLivrFact = ?, IdClit = ?, IdEmp = ? WHERE IdFact = ?");
        $sql = $edit->execute([$libelle, $mode, $prix, $dateLiv, $idClit, $idEmp, $id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function deleteFacture($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM facture WHERE IdFact = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getFactures()
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM facture");
        $req->execute();
        $result = $req->fetchAll();
        if($result)
            return $result;
        else
            return null;
    }

    function getFactureById($id)
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM facture WHERE IdFact = ?");
        $req->execute([$id]);
        $result = $req->fetch();
        if($result)
            return $result;
        else
            return null;
    }

    function getFactureByClient($idClit)
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM facture WHERE IdClit = ?");
        $req->execute([$idClit]);
        $result = $req->fetchAll();
        if($result)
            return $result;
        else
            return null;
    }
?>