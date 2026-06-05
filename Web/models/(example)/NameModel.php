<?php

namespace Models;

use PDO;
use App\Model;
use PDOException;

// DEFINE CLASS NAME = DB TABLE NAME = FILE NAME = MODEL NAME
class NameModel extends Model
{
    /**
     * User constructor.
     */
    // DEFINE DB TABLE NAME
    // IT IS POSSIBLE TO USE MULTIPLE TABLES IN A MODEL BUT IT IS RECOMMENDED NOT TO EXCEED 3 TABLES IN ONE MODEL 
    // THE CONSTRUCTOR MUST BE THE SAME FOR ALL MODELS 
    // THE LINE $this->getConnection(); MUST BE THE LAST LINE OF THE CONSTRUCTOR
    public function __construct()
    {
        $this->table = "users";

        $this->getConnection();
    }

    /**
     * Get user info by id
     * @param int $id
     * @return array|bool
     */
    // METHOD = FUNCTION = CORRESPONDS TO A SQL QUERY OR DATA RETRIEVAL ACTION
    // HERE WE RETRIEVE USER INFORMATION BY ID
    public function getUserInfo(int $id)
    {
        // DEFINE SQL QUERY
        $query = "SELECT id_users, email, name, surname, address, city, country, phone, zip_code, is_banned, sponsor_counter, id_access, creation_date,mail_verified FROM " . $this->table . " WHERE id_users = :id";

        // PREPARE SQL QUERY WITH PDO
        // THE $stmt VARIABLE IS A PDO OBJECT CONTAINING THE PREPARED SQL QUERY
        // THE PREPARE() FUNCTION TAKES THE SQL QUERY AS A PARAMETER
        $stmt = $this->_connexion->prepare($query);

        // DEFINE SQL QUERY PARAMETERS
        // THE bindParam() FUNCTION TAKES SQL PARAMETER NAME AND VALUE
        $stmt->bindParam(":id", $id);

        // EXECUTE SQL QUERY
        $stmt->execute();

        // RETRIEVE SQL QUERY RESULTS
        // THE fetch() FUNCTION RETURNS AN ASSOCIATIVE ARRAY OF THE RESULTS
        // THE fetch() FUNCTION RETURNS FALSE IF THERE ARE NO RESULTS
        // PDO::FETCH_ASSOC RETRIEVES AN ASSOCIATIVE ARRAY
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
