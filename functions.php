<?php

    function getDatabaseConnection()
    {
        $servername = getConfigParameter("servername");
        $username = getConfigParameter("username");
        $password = getConfigParameter("password");
        $dbname = getConfigParameter("dbname");
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $conn;
    }

    function getRequestParameter($key, $default = false)
    {
        if(isset($_REQUEST[$key])){
            return $_REQUEST[$key];
        }
        return $default;
    }

    function getAzubiSkillsByType($connection, $azubiId, $type){
        $query = "SELECT skill FROM azubi_skills WHERE azubi_id =". $azubiId ." AND type = '$type'";
        $result = mysqli_query($connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function addUserToAzubiDatabase($name, $birthday, $email, $github, $employmentstart, $pictureurl, $password, $conn){
        $password = encrypt($password);

        $sql = "INSERT INTO azubi (name, birthday, email, githubuser, employmentstart, pictureurl, password) 
                VALUES ('$name', '$birthday', '$email', '$github', '$employmentstart', '$pictureurl', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "Neuer Eintrag erfolgreich erstellt.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        return mysqli_insert_id($conn);
    }

    function addSkillsToDatabase($id,$preSkills, $newSkills, $conn){
        $sql = "SELECT skill FROM azubi_skills WHERE id=".$id;
        $result = executeMysqlQuery($conn, $sql);

        foreach ($preSkills as $skill){
            $res = $result;
            $isDuplicate = false;

            while($row = mysqli_fetch_row($res)){
                if($row["skill"] == $skill){
                    $isDuplicate = true;
                }
            }

            if(!$isDuplicate){
                $sql = "INSERT INTO azubi_skills (azubi_id, type, skill) VALUES (".$id.", 'pre', '$skill')";
                executeMysqlQuery($conn, $sql);
            }
        }

        foreach ($newSkills as $skill){
            $res = $result;
            $isDuplicate = false;

            while($row = mysqli_fetch_row($res)){
                if($row["skill"] == $skill){
                    $isDuplicate = true;
                }
            }

            if(!$isDuplicate){
                $sql = "INSERT INTO azubi_skills (azubi_id, type, skill) VALUES (".$id.", 'new', '$skill')";
                executeMysqlQuery($conn, $sql);
            }
        }
        mysqli_close($conn);
    }

    function executeMysqlQuery($connection, $query){
        $result = mysqli_query($connection, $query);
        $error = mysqli_error($connection);
        if(!empty($error)){
            echo "<h1>Error with Query:".$query." ".$error."</h1>";
        }
        return $result;
    }

    function isDataComplete($azubiData, $preSkills, $newSkills){
        if ($azubiData["name"] == "" ||
            $azubiData["birthday"] == "" ||
            $azubiData["email"] == "" ||
            $azubiData["githubuser"] == "" ||
            $azubiData["employmentstart"] == "" ||
            $azubiData["pictureurl"] == "" ||
            $azubiData["password"] == "" ||
            $preSkills == "" ||
            $newSkills == ""
        ) {
            return false;
        }
        if($azubiData["password"] != trim(encrypt(getRequestParameter("repeatPassword")))){
            echo "Passwort falsch wiederholt";
            return false;
        }
        return true;
    }

    function loadUser($inputId, $conn){
        $sql = "SELECT * FROM azubi WHERE id =" . $inputId;
        $result = executeMysqlQuery($conn, $sql);
        if ($answer = mysqli_fetch_assoc($result)) {
            return $answer;
        }
        return array("name" => "", "birthday" => "", "email" => "", "githubuser" => "", "employmentstart" => "", "pictureurl" => "", "password" => "");
    }

    function insertData($azubiData, $azubiPreSkills, $azubiNewSkills, $conn){
        if(isDataComplete($azubiData, $azubiPreSkills, $azubiNewSkills)){
            $id = addUserToAzubiDatabase(
                $azubiData["name"],
                $azubiData["birthday"],
                $azubiData["email"],
                $azubiData["githubuser"],
                $azubiData["employmentstart"],
                $azubiData["pictureurl"],
                $azubiData["password"],
                $conn
            );

            addSkillsToDatabase(
                $id,
                $azubiPreSkills,
                $azubiNewSkills,
                $conn
            );
        }
    }

    function updateData($inputId, $data, $preSkills, $newSkills, $conn){
        $sql = "UPDATE azubi  SET name='".$data['name']."',birthday='".$data['birthday']."',email='".$data['email']."',
                    githubuser='".$data['githubuser']."',employmentstart='".$data['employmentstart']."',pictureurl='".$data['pictureurl']."',password='".encrypt($data['password'])."' 
                    WHERE id =".$inputId;
        executeMysqlQuery($conn, $sql);

        addSkillsToDatabase($inputId, $preSkills, $newSkills, $conn);
    }

    function deleteData($inputId, $conn){
        $sql = "DELETE FROM azubi  
                    WHERE id =".$inputId;
        executeMysqlQuery($conn, $sql);
        $sql = "DELETE FROM azubi_skills  
                    WHERE azubi_id =".$inputId;
        executeMysqlQuery($conn, $sql);
    }

    function loadSkills($inputId, $type, $conn){
        $sql = "SELECT skill FROM azubi_skills WHERE azubi_id = ".$inputId. " AND type ='" . $type."'";
        $result = executeMysqlQuery($conn, $sql);
        $answer = "";
        while ($row = mysqli_fetch_row($result)) {
            $answer .= implode($row) . ", ";
        }
        return rtrim($answer, ", ");
    }

    function getAzubiData($filter, $listSize, $startpoint, $conn){
        $filter = trim($filter);
        $sql = "SELECT * FROM azubi";
        if($filter != ""){
            $sql .= " WHERE name OR email LIKE '%".$filter."%'";
        }
        $sql .= " LIMIT ".$listSize." OFFSET ".$startpoint;
        $result = executeMysqlQuery($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function getAllIds($conn){
        $sql = "SELECT id FROM azubi";
        $result = executeMysqlQuery($conn, $sql);
        $array= [];
        while($row = mysqli_fetch_row($result)){
            $array[] = $row[0];
        }
        return $array;
    }

    function redirect($location){
        header("Location: ".$location);
        exit();
    }

    function isValid($entry, $column, $conn){
        $sql = "SELECT ".$column." FROM azubi";
        $result = executeMysqlQuery($conn, $sql);
        while($row = mysqli_fetch_row($result)){
            if($row[0] == $entry){
                return true;
            }
        }
        return false;
    }

    function encrypt($password){
        return md5($password.getConfigParameter("salt"));
    }

    function getUrl($data){
        return getConfigParameter("path").$data;
    }

    function getConfigParameter($name){
        if (file_exists("config.php")){
            include "config.php";
            if(isset($data[$name])){
                return $data[$name];
            }
            return false;
        }
        die("Config Data is missing.");
    }
