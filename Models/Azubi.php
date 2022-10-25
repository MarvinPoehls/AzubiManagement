<?php

class Azubi extends BaseModel
{
    protected $table = "azubi";
    protected $columns = ['id', 'name', 'birthday', 'email', 'githubuser', 'employmentstart', 'pictureurl', 'password'];
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
            $this->loadSkills();
        }
    }

    protected function create()
    {
        parent::create();
        $this->insertSkills($this->preSkills, "pre");
        $this->insertSkills($this->newSkills, "new");
    }

    protected function update()
    {
        parent::update();
        $this->insertSkills($this->preSkills, "pre");
        $this->insertSkills($this->newSkills, "new");
    }

    protected function delete()
    {
        parent::delete();
        $sqlSkills = "DELETE FROM azubi_skills WHERE azubi_id =" . $this->id;
        DatabaseConnection::executeMysqlQuery($sqlSkills);
    }

    protected function loadSkills()
    {
        $id = $this->id;
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
        $this->password = self::encrypt($password);
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