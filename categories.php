<?php
require_once 'config.php';
require_once 'functions.php';

requireLogin();

$categories = getAllCategories();
$error = '';
$success = '';

// Handle add category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $categoryName = trim($_POST['category_name'] ?? '');
    $color = $_POST['color'] ?? '#3498db';
    
    if (empty($categoryName)) {
        $error = 'Category name is required';
    } else {
        if (addCategory($categoryName, $color)) {
            $success = 'Category added successfully!';
            $categories = getAllCategories();
        } else {
            $error = 'Failed to add category';
        }
    }
}

// Handle delete category
if (isset($_GET['delete'])) {
    $categoryId = (int)$_GET['delete'];
    if (deleteCategory($categoryId)) {
        $success = 'Category deleted successfully!';
        $categories = getAllCategories();
    } else {
        $error = 'Failed to delete category';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Navigation Bar -->
        <div class="navbar">
            <div class="nav-brand">📝 Task Manager</div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="categories.php" class="active">Categories</a>
                <a href="stats.php">Stats</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php" class="nav-logout">Logout</a>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <h1>🏷️ Manage Categories</h1>
            
            <div class="form-grid" style="margin-bottom: 30px;">
                <h3>Add New Category</h3>
                <form action="categories.php" method="POST" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group" style="flex: 1; min-width: 200px;">
                        <input type="text" name="category_name" placeholder="Category name" required>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center;">
                        <input type="color" name="color" value="#3498db" style="width: 50px; height: 40px; cursor: pointer;">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>

            <h3>Your Categories</h3>
            <?php if (empty($categories)): ?>
                <p class="empty-message">No categories yet. Create your first one above!</p>
            <?php else: ?>
                <div class="categories-grid">
                    <?php foreach ($categories as $cat): ?>
                        <div class="category-card" style="border-left: 4px solid <?php echo htmlspecialchars($cat['color']); ?>">
                            <div class="category-header">
                                <h4 style="color: <?php echo htmlspecialchars($cat['color']); ?>; margin: 0;">
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </h4>
                                <div class="color-preview" style="background-color: <?php echo htmlspecialchars($cat['color']); ?>;"></div>
                            </div>
                            <div class="category-actions">
                                <a href="categories.php?delete=<?php echo $cat['id']; ?>" 
                                   class="btn btn-small btn-danger"
                                   onclick="return confirm('Delete this category? Tasks will not be deleted.')">
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
