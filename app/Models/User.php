<?php

namespace App\Models;

use App\Config\Database;
use PDOException;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;
    private $conn; // Database connection

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;

        // Get database connection
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public static function getAll(): array
    {
        $db = new Database();
        $conn = $db->getConnection();

        $users = [];

        try {
            $query = "SELECT id, name, email, created_at, updated_at FROM users";
            $stmt = $conn->query($query);

            while ($row = $stmt->fetch()) {
                // Do not include password in the list
                $users[] = new User($row);
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }

        return $users;
    }

    public static function find(int $id)
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $query = "SELECT id, name, email, created_at, updated_at FROM users WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch();
            if ($row) {
                return new User($row);
            } else {
                return null;
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function save(): void
    {
        try {
            if ($this->id) {
                // Update user details (without updating the password)
                $query = "UPDATE users SET name = :name, email = :email, updated_at = NOW() WHERE id = :id";
            } else {
                // Hash password for new user
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (name, email, password, created_at, updated_at) VALUES (:name, :email, :password, NOW(), NOW())";
            }

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);

            if (!$this->id) {
                // Only bind the password if we're inserting a new user
                $stmt->bindParam(':password', $this->password);
            }

            if ($this->id) {
                $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
            }

            $stmt->execute();
            // Set the ID for new records
            if (!$this->id) {
                $this->id = $this->conn->lastInsertId();
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public static function delete(int $id): void
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}
