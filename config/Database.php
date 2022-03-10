<?php
class Database{
    // Connexion à la base de données
    private $host = "localhost";
    private $db_name = "api_rest";
    private $username = "root";
    private $password = "";
    public $connexion;

    // getter pour la connexion
    public function getConnection(){

        $this->connexion = null;
       //Instancier un obhjet PDO pour se connecter a la base de données 
        try{
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->connexion;
    }   
}