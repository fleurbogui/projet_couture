<?php
    include_once("utils.php");

    function createCompte($username, $password, $role, $idEmploye)
    {
        if(checkIfUsernameExists($username))
        {
            return null;
        }
        global $bd;
        $create = $bd->prepare("INSERT INTO compte (NomUtilCompte, MdpCompte, RoleCompte, IdEmp) VALUES(?, ?, ?, ?)");
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = $create->execute([$username, $hash, $role, $idEmploye]);
        if($sql)
        {
            return $bd->lastInsertId();
        }
        return null;
    }

    function editCompte($id, $username, $role, $idEmploye)
    {
        global $bd;
        $edit = $bd->prepare("UPDATE compte SET NomUtilCompte = ?, RoleCompte = ?, IdEmp = ? WHERE IdCompte = ?");
        $sql = $edit->execute([$username, $role, $idEmploye, $id]);
        if($sql)
        {
            return true;
        }
    }
    
    function deleteCompte($id)
    {
        global $bd;
        $delete = $bd->prepare("DELETE FROM compte WHERE IdCompte = ?");
        $sql = $delete->execute([$id]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function checkIfUserExists($username, $password)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM compte WHERE NomUtilCompte = ?");
        $query->execute([$username]);
        $result = $query->fetch();
        if($result)
        {
            if(password_verify($password, $result["MdpCompte"]))
            {
                if(password_needs_rehash($result["MdpCompte"], PASSWORD_DEFAULT))
                {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $update = $bd->prepare("UPDATE compte SET MdpCompte = ? WHERE NomUtilCompte = ?");
                    $update->execute([$hash, $username]);
                }
                return [true, "Bienvenue, " . $username . " !"];
            }
            else
            {
                return [false, "Mot de passe incorrect"];
            }
        }
        return [false, "Nom d'utilisateur incorrect"];
    }

    function checkIfUsernameExists($username)
    {
        global $bd;
        $query = $bd->prepare("SELECT * FROM compte WHERE NomUtilCompte = ?");
        $query->execute([$username]);
        $result = $query->fetch();
        if($result)
        {
            return true;
        }
        return false;
    }

    function changePassword($username, $password)
    {
        global $bd;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $update = $bd->prepare("UPDATE compte SET MdpCompte = ? WHERE NomUtilCompte = ?");
        $sql = $update->execute([$hash, $username]);
        if($sql)
        {
            return true;
        }
        return false;
    }

    function getComptes()
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM compte");
        $req->execute();
        $result = $req->fetchAll();
        if($result)
            return $result;
        else
            return null;
    }

    function getCompteById($id)
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM compte WHERE IdCompte = ?");
        $req->execute([$id]);
        $result = $req->fetch();
        if($result)
            return $result;
        else
            return null;
    }

    function getCompteByUsername($username)
    {
        global $bd;
        $req = $bd->prepare("SELECT * FROM compte WHERE NomUtilCompte = ?");
        $req->execute([$username]);
        $result = $req->fetch();
        if($result)
            return $result;
        else
            return null;
    }
?>