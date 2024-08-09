<?php
    include_once ("utils.php");

    function createMesure($libelle, $idClient)
    {
        global $bd;
        $req = $bd->prepare("INSERT INTO mesure (LibMes, IdClit) VALUES (?, ?)");
        $result = $req->execute(array($libelle, $idClient));
        if($result)
            return $bd->lastInsertId();
        else
            return null;
    }

    function editMesure($id, $libelle, $idClient)
    {
        global $bd;
        $req = $bd->prepare("UPDATE mesure SET LibMes = ?, IdClit = ? WHERE RefMes = ?");
        $result = $req->execute(array($libelle, $idClient, $id));
        if($result)
            return true;
        else
            return false;
    }

    function deleteMesure($id)
    {
        global $bd;
        $req = $bd->prepare("DELETE FROM mesure WHERE RefMes = ?");
        $result = $req->execute(array($id));
        if($result)
            return true;
        else
            return false;
    }

    function getMesures()
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM mesure");
        $req->execute();
        $result = $req->fetchAll();
        if($result)
            return $result;
        else
            return null;
    }

    function getMesureByClient($idClient)
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM mesure WHERE IdClit = ?");
        $req->execute(array($idClient));
        $result = $req->fetchAll();
        if($result)
            return $result;
        else
            return null;
    }

    function getMesureDefaultDict($age, $sexe)
    {
        $json = file_get_contents("./mesures.json", true);

        if(json_validate($json))
        {
            $result = json_decode($json, true);
            if($result)
            {
                if($age == "E")
                {
                    return $result["enfant"];
                }
                else
                {
                    if($sexe == "M")
                        return $result["homme"];
                    else
                        return $result["femme"];
                }
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }
?>