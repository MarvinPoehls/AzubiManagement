<?php

include "DatabaseConnection.php";

class Azubi
{

    protected $id ="";
    protected $name ="";
    protected $birthday ="";
    protected $email ="";
    protected $githubuser ="";
    protected $employmentstart ="";
    protected $pictureurl ="";
    protected $password ="";
    protected $preSkills = [];
    protected $newSkills = [];

    public function __construct ($id = false)
    {
        if ($id !== false) {
            $this->load($id);
        }
    }

    protected function load($id)
    {
        $this->id = $id;

        $sql = "SELECT * FROM azubi WHERE id = ".$id;
        $result = executeMysqlQuery(DatabaseConnection::getConnection(), $sql);
        $data = mysqli_fetch_assoc($result);

        $this->name = $data["name"];
        $this->birthday = $data["birthday"];
        $this->email = $data["email"];
        $this->githubuser = $data["githubuser"];
        $this->employmentstart = $data["employmentstart"];
        $this->pictureurl = $data["pictureurl"];
        $this->password = $data["password"];

        $sql = "SELECT skill FROM azubi_skills WHERE azubi_id= ".$id." AND type = 'pre'";
        $result = executeMysqlQuery(DatabaseConnection::getConnection(), $sql);
        while ($row = mysqli_fetch_row($result)) {
            $this->preSkills[] = $row[0];
        }

        $sql = "SELECT skill FROM azubi_skills WHERE azubi_id= ".$id." AND type = 'new'";
        $result = executeMysqlQuery(DatabaseConnection::getConnection(), $sql);
        while ($row = mysqli_fetch_row($result)) {
            $this->newSkills[] = $row[0];
        }
    }

    public function save()
    {
        if($this->id == ""){
            $this->createAzubi();
        } else {
            $this->updateAzubi();
        }
    }

    protected function updateAzubi()
    {
        $sql = "UPDATE azubi  SET name='".$this->name."',birthday='".$this->birthday."',email='".$this->email."',
                    githubuser='".$this->githubuser."',employmentstart='".$this->employmentstart."',pictureurl='".$this->pictureurl."',
                    password='".encrypt($this->password)."' 
                    WHERE id =".$this->id;
        executeMysqlQuery(DatabaseConnection::getConnection(), $sql);

        $this->insertSkills($this->preSkills, "pre");
        $this->insertSkills($this->newSkills, "new");
    }

    protected function createAzubi()
    {
        $this->password = encrypt($this->password);

        $sql = "INSERT INTO azubi (name, birthday, email, githubuser, employmentstart, pictureurl, password) 
                VALUES ('$this->name', '$this->birthday', '$this->email', '$this->github', '$this->employmentstart', '$this->pictureurl', '$this->password')";

        if (mysqli_query(DatabaseConnection::getConnection(), $sql)) {
            echo "Neuer Eintrag erfolgreich erstellt.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error(DatabaseConnection::getConnection());
        }
        $this->id = mysqli_insert_id(DatabaseConnection::getConnection());

        $this->insertSkills($this->preSkills, "pre");
        $this->insertSkills($this->newSkills, "new");
        mysqli_close(DatabaseConnection::getConnection());
    }

    protected function insertSkills($skills, $type)
    {
        $sql = "SELECT skill FROM azubi_skills WHERE id=".$this->id;
        $result = executeMysqlQuery(DatabaseConnection::getConnection(), $sql);

        foreach ($skills as $skill) {
            $isDuplicate = false;

            while ($row = mysqli_fetch_row($result)) {
                if ($row[0] == $skill) {
                    $isDuplicate = true;
                }
            }

            if (!$isDuplicate) {
                $sql = "INSERT INTO azubi_skills (azubi_id, type, skill) VALUES (".$this->id.", '".$type."', '$skill')";
                executeMysqlQuery(DatabaseConnection::getConnection(), $sql);
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getGithubuser()
    {
        return $this->githubuser;
    }

    public function setGithubuser($githubuser)
    {
        $this->githubuser = $githubuser;
    }

    public function getEmploymentstart()
    {
        return $this->employmentstart;
    }

    public function setEmploymentstart($employmentstart)
    {
        $this->employmentstart = $employmentstart;
    }

    public function getPictureurl()
    {
        return $this->pictureurl;
    }

    public function setPictureurl($pictureurl)
    {
        $this->pictureurl = $pictureurl;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPreSkills()
    {
        return $this->preSkills;
    }

    public function setPreSkills($preSkills)
    {
        $this->preSkills = $preSkills;
    }

    public function getNewSkills()
    {
        return $this->newSkills;
    }

    public function setNewSkills($newSkills)
    {
        $this->newSkills = $newSkills;
    }
}