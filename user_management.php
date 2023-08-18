<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    session_start();
    include 'connectdb.php';

    // Function to fetch user data from the database
    function getUsers() {
        global $conn;
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        return $result;
    }

    // Display users in a table
    $users = getUsers();
    ?>

    <div class="container mt-5">
        <h1 class="mb-4">User Management</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['user_name'] . ' ' . $row['user_last_name']; ?></td>
                    <td><?php echo $row['user_email']; ?></td>
                    <td><?php echo $row['user_type']; ?></td>
                    <td>
                        <a href="edit_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <a href="add_user.php" class="btn btn-success">Add User</a>
    </div>
</body>
</html>
