<?php
    include_once ("utils.php");

    function createRdv($libelle, $date, $idEmp, $idClit)
    {
        global $bd;
        $create = $bd->prepare("INSERT INTO rendezvous (LibRdv, DateHeureRdv, IdEmp, IdClit) VALUES(?, ?, ?, ?)");
        $sql = $create->execute([$libelle, $date, $idEmp, $idClit]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editRdv($id, $libelle, $date, $idEmp, $idClit)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE rendezvous SET LibRdv = ?, DateHeureRdv = ?, IdEmp = ?, IdClit = ? WHERE IdRdv = ?");
        $sql = $edit->execute([$libelle, $date, $idEmp, $idClit, $id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function deleteRdv($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM rendezvous WHERE IdRdv = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getRdvById($id)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM rendezvous WHERE IdRdv = ?");
        $query->execute([$id]);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return null;
    }

    function getRendezvous()
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM rendezvous");
        $query->execute();
        $result = $query->fetchAll();
        if($result)
        {
            return $result;
        }
        return null;
    }
?>