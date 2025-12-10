<?php
require_once 'config.php';
require_once 'functions.php';

requireLogin();

if (isset($_GET['id'])) {
    $taskId = intval($_GET['id']);
    $task = getTaskById($taskId);
    
    if (!$task) {
        header('Location: index.php?error=Task not found');
        exit();
    }
    
    if (uncompleteTask($taskId)) {
        header('Location: index.php?success=1');
    } else {
        header('Location: index.php?error=Failed to uncomplete task');
    }
} else {
    header('Location: index.php');
}
exit();
?>