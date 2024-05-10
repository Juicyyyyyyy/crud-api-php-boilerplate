<?php

namespace App\Controllers;

use App\Models\User;
use PDOException;
use TinyRouter\Render\View;

class UserController
{
    // Show all users
    public function index()
    {
        try {
            $users = User::getAll();
            return View::render('users', ['users' => $users]);
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    // Show a form to create a new user (if you have a view for this)
    public function create()
    {
        require 'views/users/create.php';
    }

    // Store a new user
    public function store()
    {
        try {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
            ];

            $user = new User($data);
            $user->save();

            // Redirect to the list of users after saving
            header('Location: /users');
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    // Show a form to edit an existing user (if you have a view for this)
    public function edit($id)
    {
        try {
            $user = User::find($id);

            if ($user) {
                // Assuming you have a view named 'users/edit.php' to display the edit form
                require 'views/users/edit.php';
            } else {
                // Handle the case where the user is not found
                echo "User not found";
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    // Update an existing user
    public function update($id)
    {
        try {
            $user = User::find($id);

            if ($user) {
                $user->name = $_POST['name'] ?? $user->name;
                $user->email = $_POST['email'] ?? $user->email;
                // Update only if password is provided
                if (!empty($_POST['password'])) {
                    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                $user->save();

                // Redirect to the list of users after updating
                header('Location: /users');
            } else {
                // Handle the case where the user is not found
                echo "User not found";
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    // Delete a user
    public function destroy($id)
    {
        try {
            User::delete($id);

            // Redirect to the list of users after deleting
            header('Location: /users');
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}
