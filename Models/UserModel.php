<?php
namespace App\Models;

class UserModel extends Model
{
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $biography;
    protected $avatar;
    protected $authenticated;
    protected $role;
    protected $registeredAt;

    public function __construct()
    {
        $this->table = 'user';
    }

    /**
     * crée la session de l'utilisateur
     *
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'email' => $this->email,
            'role' => $this->role
        ];
    }

    /**
     * Récupérer un user à partir de son e-mail
     *
     * @param string $email
     * @return mixed
     */
    public function findOneByEmail(string $email)
    {
        return $this->request("SELECT * FROM user WHERE email = ?", [$email])->fetch();
    }

    public function findById(int $idUser)
    {
        return $this->request("SELECT * FROM user WHERE email = ?", [$idUser])->fetch();
    }
    
    /**
     * Fonction mise à jour colonne authenticated
     *
     * @param string $email
     */
    public function updateAuthUser(string $email)
    {
        return $this->request('UPDATE user SET authenticated = true WHERE email = ?', [$email]);
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of biography
     */ 
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set the value of biography
     *
     * @return  self
     */ 
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of authenticated
     */ 
    public function getAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * Set the value of authenticated
     *
     * @return  self
     */ 
    public function setAuthenticated($authenticated)
    {
        $this->authenticated = $authenticated;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of registeredAt
     */ 
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * Set the value of registeredAt
     *
     * @return  self
     */ 
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }
}