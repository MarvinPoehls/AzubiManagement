<?php

class Azubi
{
    protected $id = "";
    protected $name = "";
    protected $birthday = "";
    protected $email = "";
    protected $githubuser = "";
    protected $employmentstart = "";
    protected $pictureurl = "";
    protected $password = "";
    protected $preSkills = [];
    protected $newSkills = [];

    public function __construct($id = false)
    {
        if ($id) {
            $this->load($id);
        }
    }

    protected function load($id)
    {
        $this->id = $id;
        $sql = "SELECT * FROM azubi WHERE id = " . $id;
        $result = DatabaseConnection::executeMysqlQuery($sql);
        if (mysqli_num_rows($result) == 0) {
            return false;
        }

        $data = mysqli_fetch_assoc($result);
        $this->name = $data["name"];
        $this->birthday = $data["birthday"];
        $this->email = $data["email"];
        $this->githubuser = $data["githubuser"];
        $this->employmentstart = $data["employmentstart"];
        $this->pictureurl = $data["pictureurl"];
        $this->password = $data["password"];

        $sql = "SELECT skill FROM azubi_skills WHERE azubi_id= " . $id . " AND type = 'pre'";
        $result = DatabaseConnection::executeMysqlQuery($sql);
        while ($row = mysqli_fetch_row($result)) {
            $this->preSkills[] = $row[0];
        }

        $sql = "SELECT skill FROM azubi_skills WHERE azubi_id= " . $id . " AND type = 'new'";
        $result = DatabaseConnection::executeMysqlQuery($sql);
        while ($row = mysqli_fetch_row($result)) {
            $this->newSkills[] = $row[0];
        }
    }

    public function save()
    {
        if ($this->id == false) {
            $this->createAzubi();
        } else {
            $this->updateAzubi();
        }
    }

    public function delete($id = false)
    {
        if ($id === false) {
            $id = $this->id;
        }
        $sqlAzubi = "DELETE FROM azubi WHERE id =" . $id;
        $sqlSkills = "DELETE FROM azubi_skills WHERE azubi_id =" . $id;

        DatabaseConnection::executeMysqlQuery($sqlAzubi);
        DatabaseConnection::executeMysqlQuery($sqlSkills);
    }

    protected function updateAzubi()
    {
        $sql = "UPDATE azubi  SET name='" . $this->name . "',birthday='" . $this->birthday . "',email='" . $this->email . "',
                githubuser='" . $this->githubuser . "',employmentstart='" . $this->employmentstart . "',pictureurl='" . $this->pictureurl . "',
                password='" . self::encrypt($this->password) . "' WHERE id =" . $this->id;
        DatabaseConnection::executeMysqlQuery($sql);

        $this->insertSkills($this->preSkills, "pre");
        $this->insertSkills($this->newSkills, "new");
    }

    protected function createAzubi()
    {
        $this->password = self::encrypt($this->password);

        $sql = "INSERT INTO azubi (name, birthday, email, githubuser, employmentstart, pictureurl, password) 
                VALUES ('$this->name', '$this->birthday', '$this->email', '$this->githubuser', '$this->employmentstart', '$this->pictureurl', '$this->password')";
        DatabaseConnection::executeMysqlQuery($sql);
        $this->id = mysqli_insert_id(DatabaseConnection::getConnection());

        $this->insertSkills($this->preSkills, "pre");
        $this->insertSkills($this->newSkills, "new");
    }

    protected function insertSkills($skills, $type)
    {
        foreach ($skills as $skill) {
            if ($this->isDuplicate($skill, $type) === false && $skill != "") {
                $sql = "INSERT INTO azubi_skills (azubi_id, type, skill) VALUES (" . $this->id . ", '" . $type . "', '$skill')";
                DatabaseConnection::executeMysqlQuery($sql);
            }
        }

        $sql = "DELETE FROM azubi_skills WHERE azubi_id = " . $this->id . " AND type ='" . $type . "' AND skill NOT IN('" . implode(
                "','",
                $skills
            ) . "');";
        DatabaseConnection::executeMysqlQuery($sql);
    }

    protected function isDuplicate($skill, $type)
    {
        $sql = "SELECT skill FROM azubi_skills WHERE type='" . $type . "' AND azubi_id=" . $this->id . " AND skill='" . $skill . "'";
        $result = DatabaseConnection::executeMysqlQuery($sql);
        $row = mysqli_fetch_row($result);
        if (isset($row[0])) {
            return true;
        }
        return false;
    }

    public static function encrypt($password)
    {
        return md5($password . Configuration::getConfigParameter("salt"));
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

    public function getPreSkills($implode = false)
    {
        if ($implode) {
            return implode(",", $this->preSkills);
        }
        return $this->preSkills;
    }

    public function setPreSkills($preSkills)
    {
        $this->preSkills = $preSkills;
    }

    public function getNewSkills($implode = false)
    {
        if ($implode) {
            return implode(",", $this->newSkills);
        }
        return $this->newSkills;
    }

    public function setNewSkills($newSkills)
    {
        $this->newSkills = $newSkills;
    }
}