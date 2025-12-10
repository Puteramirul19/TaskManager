<?php
require_once 'config.php';
require_once 'functions.php';

requireLogin();

$error = '';
$success = '';
$task = null;

if (isset($_GET['id'])) {
    $taskId = (int)$_GET['id'];
    $task = getTaskById($taskId);
    
    if (!$task) {
        header('Location: index.php?error=Task not found');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskName = trim($_POST['task_name'] ?? '');
    $taskDescription = trim($_POST['task_description'] ?? '');
    $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $priority = $_POST['priority'] ?? 'medium';
    $dueDate = !empty($_POST['due_date']) ? $_POST['due_date'] : null;
    
    if (empty($taskName)) {
        $error = 'Task name is required';
    } else {
        if (updateTask($taskId, $taskName, $taskDescription, $categoryId, $priority, $dueDate)) {
            header('Location: index.php?success=1');
            exit();
        } else {
            $error = 'Failed to update task';
        }
    }
}

$categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task - Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="nav-brand">📝 Task Manager</div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="categories.php">Categories</a>
                <a href="stats.php">Stats</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php" class="nav-logout">Logout</a>
            </div>
        </div>

        <div class="card">
            <h1>✎ Edit Task</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form action="edit_task.php?id=<?php echo $task['id']; ?>" method="POST" class="form-grid">
                <div class="form-group">
                    <label for="task_name">Task Name *</label>
                    <input type="text" id="task_name" name="task_name" 
                           value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="task_description">Description</label>
                    <textarea id="task_description" name="task_description" rows="4"><?php echo htmlspecialchars($task['task_description']); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id">
                            <option value="">No Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" 
                                        <?php echo $cat['id'] == $task['category_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority">
                            <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" id="due_date" name="due_date" 
                               value="<?php echo htmlspecialchars($task['due_date'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
