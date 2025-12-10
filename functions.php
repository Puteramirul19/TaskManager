<?php
require_once 'config.php';

// ============ AUTHENTICATION FUNCTIONS ============

// Register a new user
function registerUser($username, $email, $password) {
    $conn = getDBConnection();
    
    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'All fields are required'];
    }
    
    if (strlen($password) < 6) {
        return ['success' => false, 'message' => 'Password must be at least 6 characters'];
    }
    
    // Check if username/email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows > 0) {
        return ['success' => false, 'message' => 'Username or email already exists'];
    }
    
    // Hash password and insert user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Registration successful! Please login.'];
    }
    
    return ['success' => false, 'message' => 'Registration failed'];
}

// Login user
function loginUser($username, $password) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return ['success' => false, 'message' => 'Invalid username or password'];
    }
    
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return ['success' => true, 'message' => 'Login successful'];
    }
    
    return ['success' => false, 'message' => 'Invalid username or password'];
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current user ID
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

// Logout user
function logoutUser() {
    session_destroy();
    return true;
}

// ============ TASK FUNCTIONS ============

// Get all tasks for current user
function getAllTasks() {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    if (!$userId) {
        return [];
    }
    
    $sql = "SELECT t.*, c.category_name, c.color 
            FROM tasks t 
            LEFT JOIN categories c ON t.category_id = c.id
            WHERE t.user_id = ? 
            ORDER BY t.completed ASC, t.priority DESC, t.due_date ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $tasks = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
    
    return $tasks;
}

// Get task by ID
function getTaskById($taskId) {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $taskId, $userId);
    $stmt->execute();
    
    return $stmt->get_result()->fetch_assoc();
}

// Add a new task
function addTask($taskName, $taskDescription = '', $categoryId = null, $priority = 'medium', $dueDate = null) {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    if (!$userId) {
        return false;
    }
    
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, category_id, task_name, task_description, priority, due_date) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $userId, $categoryId, $taskName, $taskDescription, $priority, $dueDate);
    
    return $stmt->execute();
}

// Update task
function updateTask($taskId, $taskName, $taskDescription, $categoryId, $priority, $dueDate) {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("UPDATE tasks SET task_name = ?, task_description = ?, category_id = ?, priority = ?, due_date = ? 
                           WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssissi", $taskName, $taskDescription, $categoryId, $priority, $dueDate, $taskId, $userId);
    
    return $stmt->execute();
}

// Mark task as completed
function completeTask($taskId) {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("UPDATE tasks SET completed = 1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $taskId, $userId);
    
    return $stmt->execute();
}

// Uncomplete task
function uncompleteTask($taskId) {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("UPDATE tasks SET completed = 0 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $taskId, $userId);
    
    return $stmt->execute();
}

// Delete a task
function deleteTask($taskId) {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $taskId, $userId);
    
    return $stmt->execute();
}

// Get task count
function getTaskCount() {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'];
}

// Get completed task count
function getCompletedTaskCount() {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE user_id = ? AND completed = 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'];
}

// ============ CATEGORY FUNCTIONS ============

// Get all categories for current user
function getAllCategories() {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("SELECT * FROM categories WHERE user_id = ? ORDER BY category_name ASC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    $categories = [];
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    
    return $categories;
}

// Add new category
function addCategory($categoryName, $color = '#3498db') {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("INSERT INTO categories (user_id, category_name, color) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $categoryName, $color);
    
    return $stmt->execute();
}

// Delete category
function deleteCategory($categoryId) {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $categoryId, $userId);
    
    return $stmt->execute();
}

// ============ UTILITY FUNCTIONS ============

// Redirect to login if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Get task statistics
function getTaskStatistics() {
    $conn = getDBConnection();
    $userId = getCurrentUserId();
    
    $stats = [];
    
    // Total tasks
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stats['total'] = $stmt->get_result()->fetch_assoc()['total'];
    
    // Completed tasks
    $stmt = $conn->prepare("SELECT COUNT(*) as completed FROM tasks WHERE user_id = ? AND completed = 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stats['completed'] = $stmt->get_result()->fetch_assoc()['completed'];
    
    // Pending tasks
    $stats['pending'] = $stats['total'] - $stats['completed'];
    
    // High priority
    $stmt = $conn->prepare("SELECT COUNT(*) as high FROM tasks WHERE user_id = ? AND priority = 'high' AND completed = 0");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stats['high_priority'] = $stmt->get_result()->fetch_assoc()['high'];
    
    // Overdue tasks
    $stmt = $conn->prepare("SELECT COUNT(*) as overdue FROM tasks WHERE user_id = ? AND due_date < CURDATE() AND completed = 0");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stats['overdue'] = $stmt->get_result()->fetch_assoc()['overdue'];
    
    return $stats;
}

// Get completion percentage
function getCompletionPercentage() {
    $stats = getTaskStatistics();
    
    if ($stats['total'] == 0) {
        return 0;
    }
    
    return round(($stats['completed'] / $stats['total']) * 100);
}

// Format date for display
function formatDate($date) {
    if (empty($date)) {
        return 'No due date';
    }
    return date('M d, Y', strtotime($date));
}

// Get priority color
function getPriorityColor($priority) {
    $colors = [
        'low' => '#27ae60',
        'medium' => '#f39c12',
        'high' => '#e74c3c'
    ];
    
    return $colors[$priority] ?? '#3498db';
}

// Get days until due date
function getDaysUntilDue($dueDate) {
    if (empty($dueDate)) {
        return null;
    }
    
    $today = new DateTime();
    $due = new DateTime($dueDate);
    $interval = $today->diff($due);
    
    if ($interval->invert) {
        return -$interval->days;
    }
    
    return $interval->days;
}
?>