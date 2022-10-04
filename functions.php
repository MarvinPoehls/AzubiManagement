<?php

    include "constants.php";

    function getDatabaseConnection()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";
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

    function addUserToAzubiDatabase($name, $birthday, $email, $github, $employmentstart, $pictureurl, $password){
        $conn = getDatabaseConnection();
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

    function addSkillsToDatabase($id,$preSkills, $newSkills){
        $conn = getDatabaseConnection();
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

    function loadUser($inputId){
        $conn = getDatabaseConnection();
        $sql = "SELECT * FROM azubi WHERE id =" . $inputId;
        $result = executeMysqlQuery($conn, $sql);
        if ($answer = mysqli_fetch_assoc($result)) {
            return $answer;
        }
        return array("name" => "", "birthday" => "", "email" => "", "githubuser" => "", "employmentstart" => "", "pictureurl" => "", "password" => "");
    }

    function insertData($azubiData, $azubiPreSkills, $azubiNewSkills){
        if(isDataComplete($azubiData, $azubiPreSkills, $azubiNewSkills)){
            $id = addUserToAzubiDatabase(
                $azubiData["name"],
                $azubiData["birthday"],
                $azubiData["email"],
                $azubiData["githubuser"],
                $azubiData["employmentstart"],
                $azubiData["pictureurl"],
                $azubiData["password"]
            );

            addSkillsToDatabase(
                $id,
                $azubiPreSkills,
                $azubiNewSkills
            );
        }
    }

    function updateData($inputId, $data, $preSkills, $newSkills){
        $conn = getDatabaseConnection();
        $sql = "UPDATE azubi  SET name='".$data['name']."',birthday='".$data['birthday']."',email='".$data['email']."',
                    githubuser='".$data['githubuser']."',employmentstart='".$data['employmentstart']."',pictureurl='".$data['pictureurl']."',password='".encrypt($data['password'])."' 
                    WHERE id =".$inputId;
        executeMysqlQuery($conn, $sql);

        addSkillsToDatabase($inputId, $preSkills, $newSkills);
    }

    function deleteData($inputId){
        $conn = getDatabaseConnection();
        $sql = "DELETE FROM azubi  
                    WHERE id =".$inputId;
        executeMysqlQuery($conn, $sql);
        $sql = "DELETE FROM azubi_skills  
                    WHERE azubi_id =".$inputId;
        executeMysqlQuery($conn, $sql);
    }

    function loadSkills($inputId, $type){
        $conn = getDatabaseConnection();
        $sql = "SELECT skill FROM azubi_skills WHERE azubi_id = ".$inputId. " AND type ='" . $type."'";
        $result = executeMysqlQuery($conn, $sql);
        $answer = "";
        while ($row = mysqli_fetch_row($result)) {
            $answer .= implode($row) . ", ";
        }
        return rtrim($answer, ", ");
    }

    function getAzubiData($filter, $listSize, $startpoint){
        $filter = trim($filter);
        $sql = "SELECT * FROM azubi";
        if($filter != ""){
            $sql .= " WHERE name OR email LIKE '%".$filter."%'";
        }
        $sql .= " LIMIT ".$listSize." OFFSET ".$startpoint;

        $conn = getDatabaseConnection();
        $result = executeMysqlQuery($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function getAllIds(){
        $sql = "SELECT id FROM azubi";
        $conn = getDatabaseConnection();
        $result = executeMysqlQuery($conn, $sql);
        $array= [];
        while($row = mysqli_fetch_row($result)){
            $array[] = $row[0];
        }
        mysqli_close($conn);
        return $array;
    }

    function redirect($location){
        header("Location: ".$location);
        exit();
    }

    function isValid($entry, $column){
        $sql = "SELECT ".$column." FROM azubi";
        $conn = getDatabaseConnection();
        $result = executeMysqlQuery($conn, $sql);
        while($row = mysqli_fetch_row($result)){
            if($row[0] == $entry){
                return true;
            }
        }
        return false;
    }

    function encrypt($password){
        return md5($password.SALT);
    }

    function getUrl($data){
        return "http://localhost/azubiManagement/".$data;
    }
