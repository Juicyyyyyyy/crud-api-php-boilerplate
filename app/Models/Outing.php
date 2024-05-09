<?php

namespace App\Models;

use App\Config\Database;
use PDOException;

class Outing
{
    public $id;
    private $user_id;
    public $type;
    public $start_date;
    public $duration;
    public $distance;
    public $comment;
    private $average_speed;
    private $average_pace;
    private $conn; // Database connection

    public function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->type = $data['type'];
        $this->start_date = $data['start_date'];
        $this->duration = $data['duration'];
        $this->distance = $data['distance'];
        $this->comment = $data['comment'];

        // Get database connection
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public static function getAll()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $outings = [];

        try {
            $query = "SELECT * FROM outings";
            $stmt = $conn->query($query);

            while ($row = $stmt->fetch()) {
                $outings[] = new Outing($row);
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }

        return $outings;
    }

    public static function find($id)
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $query = "SELECT * FROM outings WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            if ($row) {
                return new Outing($row);
            } else {
                return null;
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function save()
    {
        try {
            if ($this->id) {
                $query = "UPDATE outings SET user_id = :user_id, type = :type, start_date = :start_date, duration = :duration, distance = :distance, comment = :comment WHERE id = :id";
            } else {
                $query = "INSERT INTO outings (user_id, type, start_date, duration, distance, comment) VALUES (:user_id, :type, :start_date, :duration, :distance, :comment)";
            }

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':start_date', $this->start_date);
            $stmt->bindParam(':duration', $this->duration);
            $stmt->bindParam(':distance', $this->distance);
            $stmt->bindParam(':comment', $this->comment);

            if ($this->id) {
                $stmt->bindParam(':id', $this->id);
            }

            $stmt->execute();
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public static function delete($id)
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $query = "DELETE FROM outings WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function calculateAverages()
    {
        // Calculate average speed and pace
        $this->average_speed = $this->distance / ($this->duration / 60); // Distance divided by time in hours
        $this->average_pace = ($this->duration / 60) / $this->distance; // Time in minutes divided by distance in kilometers
    }
}