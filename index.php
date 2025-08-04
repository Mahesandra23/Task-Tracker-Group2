<?php
session_start();
include 'koneksi.php';

// Check if the user is logged in
$loggedIn = isset($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        // Check if the user is logged in
        if (!$loggedIn) {
            echo "<script>alert('Anda harus login terlebih dahulu untuk menambahkan tugas.'); window.location.href='login.php';</script>";
            exit;
        }

        $task_name = htmlspecialchars($_POST['task_name']);
        $progress = htmlspecialchars($_POST['progress']);
        $description = htmlspecialchars($_POST['description']);
        $date = date('Y-m-d H:i:s');

        $stmt = $connection->prepare("INSERT INTO tasks (task_name, progress, description, date, user_id, isdone) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("ssssi", $task_name, $progress, $description, $date, $_SESSION['user_id']);
        $stmt->execute();
    } elseif (isset($_POST['delete_task'])) {
        $task_id = $_POST['task_id'];
        $stmt = $connection->prepare("DELETE FROM tasks WHERE task_id = ?");
        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        die();
    } elseif (isset($_POST['update_task'])) {
        $task_id = $_POST['task_id'];
        $task_name = $_POST['task_name'];
        $progress = htmlspecialchars($_POST['progress']);
        $description = htmlspecialchars($_POST['description']);
        $is_done = isset($_POST['is_done']) ? 1 : 0;

        $stmt = $connection->prepare("UPDATE tasks SET task_name = ?, progress = ?, description = ?, isdone = ? WHERE task_id = ?");
        $stmt->bind_param("sssii", $task_name, $progress, $description, $is_done, $task_id);
        $stmt->execute();

        echo json_encode(array('success' => true, 'isdone' => $is_done));
        exit;
    }
}

$stmt = $connection->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Task List</span>
            <?php if ($loggedIn) : ?>
                <form action="logout.php" method="post">
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            <?php else : ?>
                <a href="login.php" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Task</th>
                    <th>Progress</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Done</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr data-aos="fade-up">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <td>
                                <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                                <input class="form-control" type="text" name="task_name" value="<?php echo htmlspecialchars($row['task_name']); ?>">
                            </td>
                            <td>
                                <select class="form-select" name="progress">
                                    <option value="Not Yet Started" <?php echo $row['progress'] === 'Not Yet Started' ? 'selected' : ''; ?>>Not Yet Started</option>
                                    <option value="In Progress" <?php echo $row['progress'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="Pending" <?php echo $row['progress'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Done" <?php echo $row['progress'] === 'Done' ? 'selected' : ''; ?>>Done</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="description" value="<?php echo htmlspecialchars($row['description']); ?>">
                            </td>
                            <td>
                                <?php
                                $date = new DateTime($row['date']);
                                $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                echo $date->format('Y-m-d H:i:s');
                                ?>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_done" <?php echo $row['isdone'] ? 'checked' : ''; ?>>
                                </div>
                            </td>
                            <td>
                                <button type="submit" name="delete_task" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-success update-task" data-task-id="<?php echo $row['task_id']; ?>">Update</button>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="task_name" placeholder="Task Name">
                <select class="form-select" name="progress">
                    <option value="Not Yet Started">Not Yet Started</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Pending">Pending</option>
                    <option value="Done">Done</option>
                </select>
                <input class="form-control" type="text" name="description" placeholder="Description">
                <button type="submit" name="add_task" class="btn btn-primary">Add Task</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
        
        // JavaScript for moving tasks when isdone is set to 1
        $(document).ready(function() {
    $('.update-task').click(function() {
        var taskID = $(this).data('task-id');
        var progressSelect = $(this).closest('tr').find('[name=progress]');
        var isDoneCheckbox = $(this).closest('tr').find('[name=is_done]');

        // Check if the selected option is "Done" and set the checkbox accordingly
        if (progressSelect.val() === "Done") {
            isDoneCheckbox.prop('checked', true);
        } else {
            isDoneCheckbox.prop('checked', false);
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $_SERVER['PHP_SELF']; ?>',
            data: {
                task_id: taskID,
                task_name: progressSelect.closest('tr').find('[name=task_name]').val(),
                progress: progressSelect.val(),
                description: progressSelect.closest('tr').find('[name=description]').val(),
                update_task: true
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert('Task updated successfully.');
                    if (data.isdone === 1) {
                        var row = progressSelect.closest('tr');
                        row.insertAfter(row.siblings(':last'));
                    }
                } else {
                    alert('Task update failed.');
                }
            }
        });
    });
});
    </script>
</body>
</html>
