<?php
require_once 'config.php';

class Contact
{
    private $id;
    private $name;
    private $phone;
    private $email;
    private $note;

    public function __construct($name, $phone, $email, $note, $id = -1)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->note = $note;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function saveUpdate(PDO $PDO)
    {
        try {
            if ($this->id == -1) {
                $query = $PDO->prepare("INSERT INTO users SET name=?, phone=?, email=?, note=?");
                $query->execute([$this->name, $this->phone, $this->email, $this->note]);
                $this->id = $PDO->lastInsertId();
            } else {
                $query = $PDO->prepare("UPDATE users SET name=?, phone=?, email=?, note=? WHERE id=?");
                $query->execute([$this->name, $this->phone, $this->email, $this->note, $this->id]);

            }
        } catch (Exception $e) {
            echo $e;
        }

    }


    public static function loadAll(PDO $PDO)
    {
        $query = $PDO->prepare("SELECT * FROM users");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();
        $contacts = array();

        foreach ($result as $user) {
            array_push($contacts, new Contact($user['name'], $user['phone'], $user['email'], $user['note'], $user['id']));
        }

        return $contacts;
    }


    public function delete($PDO)
    {
        $query = $PDO->prepare("DELETE FROM users WHERE id=?");
        $query->execute([$this->id]);

        header("location: index.php");
    }

    public static function getRecord($PDO, $id)
    {
        try {
            $query = $PDO->prepare('SELECT * FROM users WHERE id=?');
            $query->execute([$id]);
            $query->setFetchMode(PDO::FETCH_ASSOC);

            $result = $query->fetch();

            return new Contact($result['name'], $result['phone'], $result['email'], $result['note'], $result['id']);

        } catch (Exception $e) {
            echo $e;
        }


    }
}
