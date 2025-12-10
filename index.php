<?php
require_once 'config.php';
require_once 'functions.php';

requireLogin();

$tasks = getAllTasks();
$stats = getTaskStatistics();
$completionPercentage = getCompletionPercentage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Navigation Bar -->
        <div class="navbar">
            <div class="nav-brand">📝 Task Manager</div>
            <div class="nav-links">
                <a href="index.php" class="active">Home</a>
                <a href="categories.php">Categories</a>
                <a href="stats.php">Stats</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php" class="nav-logout">Logout</a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">✓ Task updated successfully!</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">✗ <?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <!-- Header with User Greeting -->
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 👋</h1>
            <p>Track and manage your tasks efficiently</p>
        </div>

        <!-- Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total']; ?></div>
                <div class="stat-label">Total Tasks</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['pending']; ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['completed']; ?></div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $completionPercentage; ?>%</div>
                <div class="stat-label">Progress</div>
            </div>
        </div>

        <!-- Add New Task Button -->
        <div style="margin: 20px 0;">
            <a href="add_task.php" class="btn btn-primary btn-large">+ Add New Task</a>
        </div>

        <!-- Task List Section -->
        <div class="card">
            <h2>📋 Your Tasks</h2>
            
            <?php if (empty($tasks)): ?>
                <p class="empty-message">No tasks yet. Create your first task to get started!</p>
            <?php else: ?>
                <div class="task-list">
                    <?php foreach ($tasks as $task): 
                        $daysLeft = getDaysUntilDue($task['due_date']);
                        $isOverdue = $daysLeft !== null && $daysLeft < 0 && !$task['completed'];
                    ?>
                        <div class="task-item <?php echo $task['completed'] ? 'completed' : ''; ?>" 
                             style="border-left: 4px solid <?php echo htmlspecialchars($task['color'] ?? getPriorityColor($task['priority'])); ?>">
                            
                            <div class="task-header">
                                <div class="task-title-group">
                                    <h3><?php echo htmlspecialchars($task['task_name']); ?></h3>
                                    <?php if ($task['category_name']): ?>
                                        <span class="task-category" style="background-color: <?php echo htmlspecialchars($task['color']); ?>">
                                            <?php echo htmlspecialchars($task['category_name']); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="task-priority priority-<?php echo htmlspecialchars($task['priority']); ?>">
                                        <?php echo ucfirst($task['priority']); ?>
                                    </span>
                                </div>
                            </div>

                            <?php if (!empty($task['task_description'])): ?>
                                <p class="task-description"><?php echo htmlspecialchars($task['task_description']); ?></p>
                            <?php endif; ?>

                            <div class="task-meta">
                                <small>Created: <?php echo date('M d, Y', strtotime($task['created_at'])); ?></small>
                                
                                <?php if ($task['due_date']): ?>
                                    <small class="<?php echo $isOverdue ? 'overdue' : ''; ?>">
                                        Due: <?php echo formatDate($task['due_date']); ?>
                                        <?php if ($daysLeft !== null && !$task['completed']): ?>
                                            (<?php 
                                                if ($daysLeft < 0) {
                                                    echo abs($daysLeft) . ' day(s) overdue';
                                                } elseif ($daysLeft == 0) {
                                                    echo 'Due today!';
                                                } else {
                                                    echo $daysLeft . ' day(s) left';
                                                }
                                            ?>)
                                        <?php endif; ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <div class="task-actions">
                                <?php if (!$task['completed']): ?>
                                    <a href="complete_task.php?id=<?php echo $task['id']; ?>" 
                                       class="btn btn-small btn-success" title="Mark as complete">
                                        ✓ Complete
                                    </a>
                                <?php else: ?>
                                    <a href="uncomplete_task.php?id=<?php echo $task['id']; ?>" 
                                       class="btn btn-small btn-info" title="Mark as incomplete">
                                        ⟲ Uncomplete
                                    </a>
                                <?php endif; ?>
                                <a href="edit_task.php?id=<?php echo $task['id']; ?>" 
                                   class="btn btn-small btn-secondary" title="Edit task">
                                    ✎ Edit
                                </a>
                                <a href="delete_task.php?id=<?php echo $task['id']; ?>" 
                                   class="btn btn-small btn-danger" 
                                   onclick="return confirm('Delete this task?')" title="Delete task">
                                    ✗ Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>