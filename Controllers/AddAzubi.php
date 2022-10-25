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

        if ($this->getRequestParameter("name") == false){
            throw new Exception("You have to input a name");
        }
        if (!$this->isEmailValid()) {
            throw new Exception("Wrong email pattern. Write your email like: 'example@email.abc'");
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
        $azubi->setPreSkills(explode(",", $this->getRequestParameter("pre")));
        $azubi->setNewSkills(explode(",", $this->getRequestParameter("new")));
        $azubi->setPassword($this->getRequestParameter("password"));
        $azubi->save();
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
}