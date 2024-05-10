<?php
use App\Models\Outing;

$outings = Outing::getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outings List</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Outings List</h1>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Type</th>
                <th>Date</th>
                <th>Duration</th>
                <th>Distance</th>
                <th>Comment</th>
                <th>Average Speed (km/h)</th>
                <th>Average Pace (min/km)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($outings as $outing): ?>
            <tr>
                <td><?= $outing->type ?></td>
                <td><?= $outing->start_date ?></td>
                <td><?= $outing->duration ?></td>
                <td><?= $outing->distance ?></td>
                <td><?= $outing->comment ?></td>
                <td><?= $outing->average_speed ?></td>
                <td><?= $outing->average_pace ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
