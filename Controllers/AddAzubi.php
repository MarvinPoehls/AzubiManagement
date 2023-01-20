<?php

class AddAzubi extends SecureController
{
    protected $view = "addAzubi";

    public function getTitle()
    {
        $id = $this->getRequestParameter("azubiId");
        if(!$id){
            return "Azubi Hinzufügen";
        }
        return "Azubi Bearbeiten";
    }

    public function getAzubi()
    {
        $id = $this->getRequestParameter("azubiId");
        return new Azubi($id);
    }

    public function save()
    {
        $azubi = $this->getAzubi();

        if (!$this->getRequestParameter("name")){
            throw new Exception("You have to input a name");
        }
        if (!$this->isEmailValid()) {
            throw new Exception("Wrong email. Write your email like: 'example@email.abc'");
        }
        if (!$this->isBirthdayValid()) {
            throw new Exception("Wrong birthday pattern. Write your birthday like: 'dd.mm.yyyy'.");
        }
        if (!$this->isGithubValid()) {
            throw new Exception("This Github User doesnt exist.");
        }

        $azubi->setName($this->getRequestParameter("name"));
        $azubi->setBirthday($this->getRequestParameter("birthday"));
        $azubi->setEmail($this->getRequestParameter("email"));
        $azubi->setGithubuser($this->getRequestParameter("githubuser"));
        $azubi->setEmploymentstart($this->getRequestParameter("employmentstart"));
        $azubi->setPictureurl($this->getRequestParameter("pictureurl"));
        $azubi->setPreSkills($this->getRequestParameter("preSkills"));
        $azubi->setNewSkills($this->getRequestParameter("newSkills"));
        $azubi->setPassword($this->getRequestParameter("password"));
        $azubi->save();

        $this->redirect('index.php?controller=addAzubi&azubiId=' . $azubi->getId());
    }

    public function delete()
    {
        $deleteId = $this->getRequestParameter("deleteId");
        if ($deleteId) {
            $azubi = new Azubi($deleteId);
            $azubi->delete();
        }
    }

    public function isEmailValid()
    {
        $email = $this->getRequestParameter("email");
        if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i", $email)) {
            return true;
        }
        return false;
    }

    public function isBirthdayValid()
    {
        $birthday = $this->getRequestParameter("birthday");
        $dt = DateTime::createFromFormat("Y-m-d", $birthday);
        return $dt !== false && !array_sum($dt::getLastErrors());
    }

    public function isGithubValid()
    {
        $github = $this->getRequestParameter("githubuser");
        $url = "https://github.com/". $github;
        $headers = @get_headers($url);
        if($headers && $headers[0] != 'HTTP/1.1 404 Not Found' && isset($github)) {
            return true;
        }
        return false;
    }

    public function deleteSkill($name, $type)
    {
        if ($this->getRequestParameter("azubiId")) {
            $azubi = new Azubi($this->getRequestParameter("azubiId"));
            return $azubi->deleteSkill($name, $type);
        }
    }
}