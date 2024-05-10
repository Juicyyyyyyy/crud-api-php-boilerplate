<?php

namespace App\Controllers;

use App\Models\Outing;
use TinyRouter\Render\View;


class OutingController
{
    public function index()
    {
        // Retrieve all outings from the database
        $outings = Outing::getAll();

        // Render the view to display all outings
        View::render('outing/index', ['outings' => $outings]);
    }

    public function create()
    {
        // Render the view to create a new outing
        View::render('outing/create');
    }

    public function store(Request $request)
    {
        // Retrieve data from the request
        $userData = $request->all();

        // Create a new outing
        $outing = new Outing($userData);
        $outing->calculateAverages();
        $outing->save();

        // Redirect to the outings index page
        header('Location: /outings');
        exit();
    }

    public function edit(Request $request, $id)
    {
        // Retrieve the outing by ID
        $outing = Outing::find($id);

        // Check if the outing exists
        if (!$outing) {
            echo "Outing not found.";
            exit;
        }
    }

    // Other methods...
}
