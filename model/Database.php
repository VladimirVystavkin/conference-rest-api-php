<?php
require_once PROJECT_ROOT_PATH . "/inc/config.php";

class Database{
    protected $connection = null;

    public function __construct(){
        try{
            $this->connection = new mysqli(DB_HOST , DB_USERNAME , DB_PASSWORD, DB_DATABASE_NAME);
            if(mysqli_connect_errno()){
                throw new Exception("Could not connect to database.");
            }
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

    public function select($query = "" , $params = [])
    {
        try {


            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }

            if( $params ) {
                $stmt->bind_param($params[0], $params[1]);
            }

            $stmt->execute();

            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }

    public function delete($id){
        try{
            mysqli_query($this->connection , " DELETE FROM conference WHERE `conference`.`id` = {$id}");

        }catch (Exception $e){
        }

    }

    public function create($conference){
        try{

            $title = $conference->title;
            $address = $conference->address;
            $country = $conference->country;
            $date = $conference->date;
            $longitude = $conference->geoCoordinate->longitude;
            $latitude = $conference->geoCoordinate->latitude;
            mysqli_query($this->connection , " INSERT INTO `conference` (`id`, `title`, `address`, `date`, `country`, `latitude`, `longitude`) VALUES (NULL, '{$title}','{$address}' , '{$date}', '{$country}', '{$longitude}', '{$latitude}')");


        }catch (Exception $e){
        }
    }

    public function update($conference){
        $id = $conference->id;
        $title = $conference->title;
        $address = $conference->address;
        $country = $conference->country;
        $date = $conference->date;
        $longitude = $conference->geoCoordinate->longitude;
        $latitude = $conference->geoCoordinate->latitude;
        mysqli_query($this->connection , "UPDATE `conference` SET `title` = '{$title}', `address` = '{$address}', `date` = '{$date}', `country` = '{$country}', `latitude` = '{$latitude}', `longitude` = '{$longitude}' WHERE `conference`.`id` = {$id}");
    }


}