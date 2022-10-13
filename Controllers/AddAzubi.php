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
        if ($this->getRequestParameter("name")) {
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
    }

    public function delete()
    {
        $deleteId = $this->getRequestParameter("deleteId");
        if ($deleteId) {
            $azubi = new Azubi($deleteId);
            $azubi->delete();
        }
    }
}