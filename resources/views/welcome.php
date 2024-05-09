<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config\Database;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_POST['title'] ?? 'LocalHost' ?></title>
</head>
<body>
<?php

$database = new Database();
$conn = $database->getConnection();

if ($conn){
    echo "Database connected";
}
?>
</body>
</html>