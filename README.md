# 📝 Task Manager Application - Complete PHP Project

A fully-featured task management application built with PHP and MySQL. Perfect for learning core PHP concepts including user authentication, database relationships, form handling, and session management.

## ✨ Features

### 🔐 User Authentication
- User registration with password hashing (bcrypt)
- Login/logout system with session management
- Secure password reset functionality
- User profile management

### 📋 Task Management
- Create, read, update, and delete (CRUD) tasks
- Mark tasks as complete/incomplete
- Task descriptions for detailed information
- Due date tracking with overdue alerts
- Task priority levels (Low, Medium, High)
- Color-coded task organization

### 🏷️ Categories
- Create custom task categories
- Assign tasks to categories
- Color-coded categories for visual organization
- Delete categories (tasks retain data)

### 📊 Statistics & Analytics
- Total task count
- Completed vs pending tasks
- Completion percentage with progress bar
- Tasks by priority breakdown
- Overdue task tracking
- Task summary and insights

### ⚙️ User Settings
- View user profile information
- Change password securely
- Account management

## 📁 Project Structure

```
my-first-project/
├── index.php              # Dashboard/home page
├── register.php           # User registration
├── login.php              # User login
├── logout.php             # User logout
├── add_task.php           # Add new task form
├── edit_task.php          # Edit existing task
├── complete_task.php      # Mark task as complete
├── uncomplete_task.php    # Mark task as incomplete
├── delete_task.php        # Delete task
├── categories.php         # Manage categories
├── stats.php              # View statistics
├── settings.php           # User settings
├── config.php             # Database configuration
├── functions.php          # Helper functions
├── style.css              # Styling
└── README.md              # This file
```

## 🗄️ Database Schema

### Users Table
```sql
- id (Primary Key)
- username (UNIQUE)
- email (UNIQUE)
- password (hashed)
- created_at (timestamp)
- updated_at (timestamp)
```

### Tasks Table
```sql
- id (Primary Key)
- user_id (Foreign Key)
- category_id (Foreign Key)
- task_name
- task_description
- priority (low, medium, high)
- due_date
- completed (boolean)
- created_at (timestamp)
- updated_at (timestamp)
```

### Categories Table
```sql
- id (Primary Key)
- user_id (Foreign Key)
- category_name
- color (hex code)
- created_at (timestamp)
```

## 🚀 Getting Started

### Prerequisites
- PHP 7.0+ installed
- MySQL server running
- Laragon or similar local development environment

### Installation

1. **Navigate to project directory:**
   ```
   cd c:\laragon\www\my-first-project
   ```

2. **Access the application:**
   - Open your browser and go to: `http://localhost/my-first-project`
   - Or use Laragon's built-in server

3. **Create an account:**
   - Click on "Register here" link
   - Fill in username, email, and password
   - Click Register

4. **Login:**
   - Enter your credentials
   - You'll be redirected to the dashboard

## 📚 Key Learning Concepts

### 1. **User Authentication**
   - Password hashing with `password_hash()` and `password_verify()`
   - Session management with `$_SESSION`
   - Form validation and sanitization
   - SQL prepared statements for security

### 2. **Database Operations**
   - Database connection pooling (static connection)
   - Prepared statements to prevent SQL injection
   - FOREIGN KEY relationships
   - Table joins (LEFT JOIN for categories)

### 3. **Form Handling**
   - GET and POST requests
   - Form data validation
   - Error messages and user feedback
   - Redirect after successful operations

### 4. **Security**
   - Password hashing (bcrypt)
   - Prepared statements
   - Session-based authentication
   - Input validation and sanitization
   - HTML entity encoding with `htmlspecialchars()`

### 5. **Functions & Organization**
   - Helper functions for database operations
   - Utility functions for calculations (getDaysUntilDue, etc.)
   - Code reusability
   - Separation of concerns

## 🔧 Configuration

Edit `config.php` to change database settings:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Update if needed
define('DB_NAME', 'task_manager');
```

## 📖 Usage Guide

### Adding a Task
1. Click "+ Add New Task" button
2. Fill in task details:
   - Task name (required)
   - Description (optional)
   - Category (optional)
   - Priority level
   - Due date (optional)
3. Click "Add Task"

### Managing Tasks
- **Complete**: Click "✓ Complete" to mark task as done
- **Uncomplete**: Click "⟲ Uncomplete" to reopen
- **Edit**: Click "✎ Edit" to modify task details
- **Delete**: Click "✗ Delete" to remove task

### Categories
1. Go to Categories page
2. Enter category name and choose color
3. Click "Add Category"
4. View and delete existing categories

### Viewing Statistics
- Go to Stats page
- See completion progress
- View task distribution by priority
- Check overdue tasks
- View overall summary

## 💡 PHP Learning Topics Covered

- ✅ Object-oriented vs procedural PHP
- ✅ Database connection and queries
- ✅ Prepared statements
- ✅ Session management
- ✅ Password security
- ✅ Form validation
- ✅ Error handling
- ✅ HTML entity encoding
- ✅ DateTime manipulation
- ✅ Array functions
- ✅ String functions
- ✅ Conditional logic
- ✅ Loops and iterations

## 🎯 Next Steps / Enhancements

Consider adding:
- Task labels/tags
- Task filtering and search
- Task sharing with other users
- Email notifications
- Task recurring/recurring tasks
- File attachments
- Task comments
- User roles and permissions
- Data export (CSV/PDF)
- Dark mode toggle

## 🐛 Troubleshooting

### Database Connection Error
- Check MySQL server is running
- Verify credentials in `config.php`
- Ensure `task_manager` database can be created

### Login Issues
- Verify username is correct
- Check password matches
- Ensure cookies are enabled in browser
- Clear browser cache if needed

### Tasks Not Showing
- Make sure you're logged in
- Check that tasks are created in your account
- Verify database tables exist

## 📝 Notes

- Database is created automatically on first page load
- All tables are created if they don't exist
- User data is isolated (each user sees only their tasks)
- Passwords are securely hashed with bcrypt

## 🔒 Security Features

- Passwords hashed with `PASSWORD_DEFAULT` algorithm
- SQL injection prevention via prepared statements
- Cross-site scripting (XSS) prevention with `htmlspecialchars()`
- Session-based authentication
- User ownership verification on operations

## 📄 License

This project is open source and available for educational purposes.

---

**Happy coding! 🎉**

For questions or issues, review the code comments or modify the functions in `functions.php` to understand how each feature works.
