<?php


class Users
{

    /***
     * id_usuari, nombre,password, num_acciones
     */

    public $pdo;

    private $errors = array();

    function __construct(){

        $host = 'localhost';
        $database = 'desarrollo';
        $user = 'root';
        $password = '';

        $this->pdo = new \PDO('mysql:host='.$host.';dbname='.$database, $user,$password);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }


    public function newUser()
    {
        if ( !empty( $_GET['user_name'] ) && !empty( $_GET['password'] ) )
        {
            $this->insertUser( $_GET['user_name'], $_GET['password'] );
        }
        else
        {
            if ( empty( $_GET['user_name'] ) )
            {
                $this->errors[] = 'Invalid User name';
            }

            if ( empty( $_GET['password'] ) )
            {
                $this->errors[] = 'Invalid Password';
            }
        }
    }


    /**
     * Retorna la información de un usuario guardado en la base de datos. Si no existe lanza una excepción.
     * @param $id_user
     */
    public function getUserData( $id_user )
    {

    }

    /**
     * Inserta un usuario en la base de datos.
     * @param $name
     * @param $password
     */
    public function insertUser($name, $password )
    {

    $statement = "INSERT INTO user (user_name,password) VALUES (:name,:password)";

    $db = $this->pdo->prepare($statement);

    $result = $db->execute(array(
        ':name'=>$name,
        ':password'=>$password
    ));

    return $result;
    }



    /**
     * Inserta una acción en base de datos.
     * @param $id,$action
     */
    public function insertUserAction( $id, $action )
    {

        $statement = "UPDATE user SET num_actions = num_actions + :n_action WHERE id = :id";
        $db = $this->pdo->prepare($statement);
        $result = $db->execute(array(
                ':id'=>$id,
                ':n_action'=>$action
            )
        );

        return $result;
    }

    /**
     * Retorna un array de acciones. Si el usuario no tiene acciones retorna vacío.
     * @param $id
     */
    public function getUserActions( $id )
    {
        $statement = "SELECT num_actions FROM  user WHERE  id = $id";
        $db = $this->pdo->prepare($statement);
        $db->execute(array());
        $result = $db->fetchAll();

        return $result;

    }

    /**
     * Nos devuelve el karma del usuario en función del número de acciones realizadas.
     * - Entre 0 y 10 -> devuelve 1
     * - Mayor que 10 y menor 100 -> devuelve 2
     * - Mayor de 100 y menor de 500 -> devuelve 3
     * - Mayor de 500 -> devuelve número de acciones entre 100
     * @param $id_user
     */
    public function getUserKarma( $id_user )
    {
        $statement = "SELECT num_actions FROM  user WHERE  id = $id_user";
    }
}

