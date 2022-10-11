<?php

class AddAzubi extends SecureWebsite
{
    public function getTitle()
    {
        $id = $this->getRequestParameter("azubiId");
        if(!$id){
            return "Azubi Hinzufügen";
        }
        return "Azubi Bearbeiten";
    }

    public function handleFormData()
    {
        $id = $this->getRequestParameter("azubiId");
        $azubi = new Azubi($id);
        if ($this->getRequestParameter("deleteId") !== false) {
            $azubi->delete($this->getRequestParameter("deleteId"));
        } elseif ($this->getRequestParameter("name")) {
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
        return $azubi;
    }
}