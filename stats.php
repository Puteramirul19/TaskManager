<?php
require_once 'config.php';
require_once 'functions.php';

requireLogin();

$stats = getTaskStatistics();
$completionPercentage = getCompletionPercentage();
$tasks = getAllTasks();

// Calculate stats by priority
$priorityStats = ['low' => 0, 'medium' => 0, 'high' => 0];
$overdueTasks = [];

foreach ($tasks as $task) {
    if (!$task['completed']) {
        $priorityStats[$task['priority']]++;
        
        if ($task['due_date'] && strtotime($task['due_date']) < time()) {
            $overdueTasks[] = $task;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics - Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Navigation Bar -->
        <div class="navbar">
            <div class="nav-brand">📝 Task Manager</div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="categories.php">Categories</a>
                <a href="stats.php" class="active">Stats</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php" class="nav-logout">Logout</a>
            </div>
        </div>

        <div class="dashboard-header">
            <h1>📊 Your Task Statistics</h1>
            <p>Track your productivity and progress</p>
        </div>

        <!-- Main Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number" style="color: #3498db;"><?php echo $stats['total']; ?></div>
                <div class="stat-label">Total Tasks</div>
                <div class="stat-description">All tasks created</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #27ae60;"><?php echo $stats['completed']; ?></div>
                <div class="stat-label">Completed</div>
                <div class="stat-description">Tasks finished</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #f39c12;"><?php echo $stats['pending']; ?></div>
                <div class="stat-label">Pending</div>
                <div class="stat-description">Tasks to do</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #e74c3c;"><?php echo $stats['overdue']; ?></div>
                <div class="stat-label">Overdue</div>
                <div class="stat-description">Past due date</div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="card">
            <h2>Overall Progress</h2>
            <div class="progress-container">
                <div style="margin-bottom: 10px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>Completion Rate</span>
                        <strong><?php echo $completionPercentage; ?>%</strong>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $completionPercentage; ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Priority Distribution -->
        <div class="stats-columns">
            <div class="card" style="flex: 1;">
                <h2>Tasks by Priority</h2>
                <div class="priority-stats">
                    <div class="priority-stat">
                        <div class="priority-bar priority-high"></div>
                        <div class="priority-info">
                            <span class="priority-label">High Priority</span>
                            <span class="priority-count"><?php echo $priorityStats['high']; ?> tasks</span>
                        </div>
                    </div>
                    <div class="priority-stat">
                        <div class="priority-bar priority-medium"></div>
                        <div class="priority-info">
                            <span class="priority-label">Medium Priority</span>
                            <span class="priority-count"><?php echo $priorityStats['medium']; ?> tasks</span>
                        </div>
                    </div>
                    <div class="priority-stat">
                        <div class="priority-bar priority-low"></div>
                        <div class="priority-info">
                            <span class="priority-label">Low Priority</span>
                            <span class="priority-count"><?php echo $priorityStats['low']; ?> tasks</span>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($overdueTasks)): ?>
            <div class="card" style="flex: 1;">
                <h2>⚠️ Overdue Tasks</h2>
                <div class="overdue-list">
                    <?php foreach ($overdueTasks as $task): ?>
                        <div class="overdue-item">
                            <div>
                                <strong><?php echo htmlspecialchars($task['task_name']); ?></strong>
                                <br>
                                <small>Due: <?php echo formatDate($task['due_date']); ?></small>
                            </div>
                            <span class="overdue-badge">
                                <?php echo abs(getDaysUntilDue($task['due_date'])); ?> days ago
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Summary Card -->
        <div class="card">
            <h2>Summary</h2>
            <div class="summary-text">
                <p>
                    You have completed <strong><?php echo $stats['completed']; ?> out of <?php echo $stats['total']; ?></strong> tasks.
                </p>
                <p>
                    <?php if ($stats['total'] == 0): ?>
                        Start by creating your first task!
                    <?php elseif ($completionPercentage == 100): ?>
                        🎉 Congratulations! You've completed all your tasks!
                    <?php elseif ($stats['pending'] == 0): ?>
                        Great job! Keep it up!
                    <?php else: ?>
                        You have <strong><?php echo $stats['pending']; ?> task<?php echo $stats['pending'] > 1 ? 's' : ''; ?></strong> left to complete.
                    <?php endif; ?>
                </p>
                <p>
                    <?php if ($stats['high_priority'] > 0): ?>
                        ⚠️ You have <strong><?php echo $stats['high_priority']; ?> high-priority task<?php echo $stats['high_priority'] > 1 ? 's' : ''; ?></strong> to focus on.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
