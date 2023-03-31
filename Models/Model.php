<?php
namespace App\Models;

use App\Core\Db;

class Model extends Db
{
    // Table de la base de données
    protected $table;

    // Instance de connexion
    private $db;

    public function findAll()
    {
        $query = $this->request('SELECT * FROM ' .$this->table);
        return $query->fetchAll();
    }

    public function findBy(array $arguments)
    {
        $fields = [];
        $values = [];

        //On boucle pour éclater le tableau
        foreach ($arguments as $field => $value) {
            // SELECT * FROM user WHERE role = ?
            // bindValue(admin, valeur)
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        //On transforme le tableau "fields" en une chaine de caractères
        $fields_list = implode(' AND ', $fields);
        var_dump($fields_list);

        //On exécute la requete 
        return $this->request(
            'SELECT * FROM ' . $this->table . ' WHERE ' . $fields_list, $values)->fetchAll();
    }

    public function find(int $id, string $columnDbTarget = "id")
    {
        return $this->request("SELECT * FROM $this->table WHERE $columnDbTarget = $id")->fetch();
    }

    public function create()
    {
        $fields = [];
        $QuestionMark = [];
        $values = [];


        //On boucle pour éclater le tableau
        foreach ($this as $field => $value) {
            // INSERT INTO * FROM user (firstName, lastName, email, biography, avatar, authenticated, role, registeredAt) VALUES (?,?,?,?,?,?,?,?)
            // bindValue(admin, valeur)

            if ($value != null && $field != 'db' && $field != 'table' && $field != 'id') {
                array_push($fields, $field);
                array_push($QuestionMark, "?");
                array_push($values, $value);
            }
        }

        //On transforme le tableau "fields" en une chaine de caractères
        $fields_list = implode(', ', $fields);
        $QuestionMark_list = implode(', ', $QuestionMark);
        

        //On exécute la requete 
        return $this->request('INSERT INTO ' . $this->table . ' (' . $fields_list . ') VALUES(' . $QuestionMark_list . ')', $values);
    }

    public function update(int $id, string $columnDbTarget = "id" )
    {
        $fields = [];
        $values = [];

        //On boucle pour éclater le tableau
        foreach ($this as $field => $value) {
            // UPDATE user SET (firstName = ?, lastName = ?, email = ?, biography = ?, avatar = ?, authenticated = ?, role = ?, registeredAt = ? WHERE id = ?)
            // bindValue(admin, valeur)

            if ($value !== null && $field != 'db' && $field != 'table') {
                array_push($fields, "$field = ?");
                array_push($values, $value);
            }
        }

        //array_push($values, $this->id);
        //$values[] = $this->id; // Erreur à regler
        $values[] = $id; 
        
        //On transforme le tableau "fields" en une chaine de caractères
        $fields_list = implode(', ', $fields);

        //On exécute la requete 
        return $this->request('UPDATE ' . $this->table . ' SET ' . $fields_list . ' WHERE '.$columnDbTarget.' = ?', $values);
    }

    public function delete(int $id, string $columnDbTarget = "id")
    {
        return $this->request("DELETE FROM $this->table WHERE $columnDbTarget = ?", [$id]);
    }

    public function request(string $sql, array $attributs = null)
    {
        // On récupère l'instance de Db
        $this->db = Db::getInstance();

        // On vérifie si on a des attributs
        if ($attributs !== null) {
            // Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            //On recupere le nom du setter correspondant à la clé (key)
            // exemple firstName -> setFirstNanme
            $setter = 'set' . ucfirst($key);

            //On verifie si le setter existe
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
        return $this;
    }
}