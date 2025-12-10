# 📚 Function Reference Guide

## Authentication Functions

### `registerUser($username, $email, $password)`
**Purpose:** Register a new user with validation
**Returns:** Array with `success` (bool) and `message` (string)
**Security:** Hashes password with bcrypt (PASSWORD_DEFAULT)

### `loginUser($username, $password)`
**Purpose:** Authenticate user and create session
**Returns:** Array with `success` (bool) and `message` (string)
**Security:** Uses `password_verify()` for secure comparison

### `isLoggedIn()`
**Purpose:** Check if user is currently logged in
**Returns:** Boolean

### `getCurrentUserId()`
**Purpose:** Get the ID of currently logged-in user
**Returns:** Integer (user ID) or null

### `logoutUser()`
**Purpose:** Destroy user session and log out
**Returns:** Boolean
**Action:** Calls `session_destroy()`

### `requireLogin()`
**Purpose:** Redirect to login if user not authenticated
**Returns:** Void (redirects if needed)
**Usage:** Place at start of protected pages

---

## Task Management Functions

### `getAllTasks()`
**Purpose:** Retrieve all tasks for current user with category info
**Returns:** Array of task arrays
**Sorting:** By completion status, then priority, then due date

### `getTaskById($taskId)`
**Purpose:** Get a single task by ID
**Returns:** Single task array or null
**Security:** Verifies user ownership

### `addTask($taskName, $taskDescription, $categoryId, $priority, $dueDate)`
**Purpose:** Create a new task
**Returns:** Boolean
**Parameters:**
- `$taskName`: Required, task title
- `$taskDescription`: Optional
- `$categoryId`: Optional, defaults to null
- `$priority`: 'low', 'medium', or 'high'
- `$dueDate`: Optional, format YYYY-MM-DD

### `updateTask($taskId, $taskName, $taskDescription, $categoryId, $priority, $dueDate)`
**Purpose:** Modify existing task
**Returns:** Boolean
**Security:** Verifies user ownership

### `completeTask($taskId)`
**Purpose:** Mark task as completed
**Returns:** Boolean

### `uncompleteTask($taskId)`
**Purpose:** Mark task as incomplete
**Returns:** Boolean

### `deleteTask($taskId)`
**Purpose:** Permanently remove task
**Returns:** Boolean
**Security:** Verifies user ownership

### `getTaskCount()`
**Purpose:** Get total number of tasks for user
**Returns:** Integer

### `getCompletedTaskCount()`
**Purpose:** Get number of completed tasks
**Returns:** Integer

---

## Category Functions

### `getAllCategories()`
**Purpose:** Retrieve all categories for current user
**Returns:** Array of category arrays
**Sorting:** Alphabetically by name

### `addCategory($categoryName, $color)`
**Purpose:** Create new category
**Returns:** Boolean
**Parameters:**
- `$categoryName`: Required
- `$color`: Hex color code (default: #3498db)

### `deleteCategory($categoryId)`
**Purpose:** Remove category
**Returns:** Boolean
**Note:** Tasks retain their data but category assignment is cleared

---

## Statistics Functions

### `getTaskStatistics()`
**Purpose:** Get comprehensive task statistics
**Returns:** Associative array with:
- `total`: Total tasks
- `completed`: Completed tasks
- `pending`: Pending tasks
- `high_priority`: High priority incomplete tasks
- `overdue`: Tasks past due date

### `getCompletionPercentage()`
**Purpose:** Calculate completion percentage
**Returns:** Integer (0-100)
**Calculation:** (completed / total) × 100

---

## Utility Functions

### `formatDate($date)`
**Purpose:** Format date for display
**Returns:** String formatted as "M dd, Y"
**Example Output:** "Dec 10, 2025"

### `getPriorityColor($priority)`
**Purpose:** Get hex color for priority level
**Returns:** Hex color string
**Mapping:**
- 'high': #e74c3c (red)
- 'medium': #f39c12 (orange)
- 'low': #27ae60 (green)

### `getDaysUntilDue($dueDate)`
**Purpose:** Calculate days remaining until due date
**Returns:** Integer (positive = days left, negative = days overdue, null = no due date)
**Example:** Returns 5 for 5 days left, -3 for 3 days overdue

---

## Database Functions

### `getDBConnection()`
**Purpose:** Get or create database connection
**Returns:** MySQLi connection object
**Features:**
- Singleton pattern (static connection)
- Auto-creates database if missing
- Auto-creates tables if missing

---

## Code Examples

### Example 1: Add Task with All Fields
```php
addTask(
    'Complete Project Report',
    'Finish the quarterly report and submit',
    3,  // category ID
    'high',
    '2025-12-15'  // due date
);
```

### Example 2: Update Task
```php
updateTask(
    5,  // task ID
    'Updated Project Report',
    'Revised quarterly report',
    3,
    'medium',
    '2025-12-20'
);
```

### Example 3: Get Statistics
```php
$stats = getTaskStatistics();
echo "Total: " . $stats['total'];
echo "Completed: " . $stats['completed'];
echo "Pending: " . $stats['pending'];
echo "Overdue: " . $stats['overdue'];
```

### Example 4: Calculate Days Until Due
```php
$daysLeft = getDaysUntilDue('2025-12-25');
if ($daysLeft > 0) {
    echo "$daysLeft days until due";
} elseif ($daysLeft < 0) {
    echo abs($daysLeft) . " days overdue";
} else {
    echo "Due today!";
}
```

---

## Common Patterns

### Checking User Ownership
```php
$task = getTaskById($taskId);
if (!$task) {
    // Task doesn't exist or user doesn't own it
    header('Location: index.php?error=Task not found');
}
```

### Redirecting After Success
```php
if (addTask($name, $desc, $catId, $priority, $date)) {
    header('Location: index.php?success=1');
    exit();
} else {
    $error = 'Failed to add task';
}
```

### Handling Form Data
```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if (empty($name)) {
        $error = 'Name required';
    } else {
        // Process form
    }
}
```

---

## Tips for Learning

1. **Prepared Statements:** All queries use prepared statements for security
2. **User Isolation:** Every query checks user_id to prevent data leakage
3. **Error Handling:** All functions return boolean or array with status
4. **Data Validation:** Trim input, check for empty values
5. **HTML Encoding:** Always use `htmlspecialchars()` for output

---

**Review `functions.php` to see the full implementation of each function!**
