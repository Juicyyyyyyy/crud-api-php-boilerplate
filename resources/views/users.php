<?php
use App\Models\User;

// Fetch all users from the database
$users = User::getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="py-3 px-6">Name</th>
                    <th scope="col" class="py-3 px-6">Email Address</th>
                    <th scope="col" class="py-3 px-6">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6"><?= htmlspecialchars($user->name) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($user->email) ?></td>
                        <td class="py-4 px-6">
                            <a href="edit_user.php?id=<?= $user->id ?>" class="font-medium text-blue-600 hover:underline">Edit</a>
                            <a href="delete_user.php?id=<?= $user->id ?>" class="font-medium text-red-600 hover:underline">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
