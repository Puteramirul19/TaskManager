# 🚀 Quick Start Guide

## Setup (First Time)

1. **Start Your Local Server**
   - Open Laragon
   - Click "Start All" button
   - MySQL and Apache will start

2. **Access the App**
   - Open browser: `http://localhost/my-first-project`
   - Or click the project link in Laragon

3. **Register Account**
   - Click "Register here"
   - Choose username, email, password
   - Submit registration

4. **Login**
   - Enter credentials
   - You'll see your dashboard

---

## Main Navigation

```
Dashboard (index.php)
├── Home - View all tasks
├── Categories - Manage task categories
├── Stats - View statistics and progress
├── Settings - Account settings
└── Logout - Exit account
```

---

## Common Tasks

### 📝 Add a Task
1. Click "+ Add New Task" button
2. Enter task name (required)
3. Add description (optional)
4. Select category (optional)
5. Choose priority (Low/Medium/High)
6. Set due date (optional)
7. Click "Add Task"

### ✏️ Edit a Task
1. On dashboard, click "✎ Edit" button
2. Modify task details
3. Click "Update Task"

### ✓ Complete a Task
1. Click "✓ Complete" button
2. Task moves to completed status
3. Task appears faded with strikethrough

### ⟲ Reopen a Task
1. Click "⟲ Uncomplete" button
2. Task returns to pending

### 🗑️ Delete a Task
1. Click "✗ Delete" button
2. Confirm deletion
3. Task is removed

---

## Categories

### Create Category
1. Go to "Categories" page
2. Enter category name
3. Choose color with color picker
4. Click "Add Category"

### Use Category
1. When adding/editing task
2. Select category from dropdown
3. Tasks will be color-coded

### Delete Category
1. Go to Categories page
2. Find category card
3. Click "✗ Delete"
4. Confirm deletion
5. Tasks keep their data, category is removed

---

## Statistics

### View Statistics
1. Click "Stats" in navigation
2. See your task overview:
   - **Total Tasks**: All tasks you've created
   - **Completed**: Tasks you finished
   - **Pending**: Tasks to do
   - **Overdue**: Tasks past due date

### Progress Tracking
- Progress bar shows completion percentage
- Priority distribution chart
- Overdue tasks list
- Summary with insights

---

## Settings

### Change Password
1. Go to "Settings"
2. Scroll to "🔐 Change Password"
3. Enter current password
4. Enter new password (min 6 characters)
5. Confirm new password
6. Click "Change Password"

### View Profile
- Username
- Email address
- Member since date

### Logout
- Click "Logout" button in navigation
- Or click "Logout" in Danger Zone
- You'll be redirected to login page

---

## Tips & Tricks

### Task Organization
- Use categories to group related tasks
- Set priorities to focus on important tasks
- Use due dates as deadlines
- Descriptions help remember details

### Best Practices
- Create tasks as soon as ideas come up
- Review tasks daily
- Set realistic due dates
- Use priority levels wisely
- Complete tasks to boost motivation

### Keyboard Shortcuts
- While on a task form: Enter submits
- Click task area to see more options
- Use tab to navigate between fields

---

## Understanding Your Dashboard

### Stats Cards (Quick Overview)
```
┌─────────────────────────────┐
│   Total   │  Pending │ Complete  │ Progress
│     15    │    7     │    8      │   53%
└─────────────────────────────┘
```

### Task Card Example
```
📝 Complete Project Report          [High Priority] [Work Category]
Finish the quarterly analysis and submit for review
Created: Dec 10, 2025
Due: Dec 15, 2025 (5 days left)
[✓ Complete] [✎ Edit] [✗ Delete]
```

### Status Indicators
- **✓ Strikethrough**: Task completed
- **⚠️ Red**: Overdue or high priority
- **⏰ Time remaining**: Days until due
- **Color bar**: Category color

---

## Troubleshooting

### Can't Login
- [ ] Check username/password
- [ ] Make sure you registered first
- [ ] Try clearing browser cache
- [ ] Check caps lock

### Tasks Not Showing
- [ ] Make sure you're logged in
- [ ] Check you created tasks in this account
- [ ] Verify browser JavaScript enabled

### Page Won't Load
- [ ] Check if server is running
- [ ] Refresh page (F5)
- [ ] Check URL: http://localhost/my-first-project

### Forgot Password
- [ ] You must register a new account
- [ ] Or manually reset in database
- [ ] See README.md for database info

---

## File Structure Explained

```
📁 my-first-project
├── 🏠 index.php          ← Your dashboard (start here)
├── 📝 add_task.php       ← Create new task form
├── ✏️  edit_task.php     ← Edit task form
├── ✓  complete_task.php  ← Mark complete
├── 🏷️  categories.php    ← Manage categories
├── 📊 stats.php          ← View statistics
├── ⚙️  settings.php      ← User settings
├── 🔐 login.php          ← Login page
├── 📝 register.php       ← Registration page
├── 🔧 config.php         ← Database setup
├── 📚 functions.php      ← PHP functions (150+ lines)
├── 🎨 style.css          ← Styling (responsive)
├── 📄 README.md          ← Full documentation
└── 📖 FUNCTIONS.md       ← Function reference
```

---

## What to Learn

This project teaches:
- ✅ PHP basics (variables, functions, arrays)
- ✅ Database design (tables, relationships)
- ✅ User authentication (hashing, sessions)
- ✅ Form handling (GET, POST, validation)
- ✅ Security (prepared statements, encoding)
- ✅ HTML/CSS basics (forms, layout, responsive)

---

## Next Steps

1. **Explore the code**
   - Open `functions.php` to see how everything works
   - Read comments in each file

2. **Modify and experiment**
   - Try adding new fields to tasks
   - Create new category colors
   - Add more statistics

3. **Learn more**
   - Study SQL queries in functions
   - Understand prepared statements
   - Learn password hashing

4. **Build more features**
   - Add task search
   - Implement task filtering
   - Create task templates

---

**Happy learning! 🎉**

Start with the dashboard and explore. Each button teaches something new!
