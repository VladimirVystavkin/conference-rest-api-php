<?php
require_once PROJECT_ROOT_PATH . "/model/Database.php";
class ConferenceModel extends Database{

    public function getConferences(){


        return $this->select("SELECT * FROM `conference`");
    }

    public function deleteConference($id){
        $this->delete(id);
    }
}