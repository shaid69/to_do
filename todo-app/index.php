<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>To-Do List</h2>

        <!-- Task Form -->
        <form id="taskForm">
            <input type="text" id="taskInput" placeholder="Enter a task" required>
            <button type="submit">Add</button>
        </form>

        <!-- Task List -->
        <ul id="tasks"></ul>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('taskForm');
    const input = document.getElementById('taskInput');
    const tasksUl = document.getElementById('tasks');

    // Load tasks from DB
    function loadTasks() {
        tasksUl.innerHTML = '';
        fetch('fetch_tasks.php')
            .then(res => res.json())
            .then(data => {
                data.forEach(task => {
                    let li = document.createElement('li');
                    li.innerHTML = `
                        <span class="${task.is_completed == 1 ? 'completed' : ''}" data-id="${task.id}">
                            ${task.task}
                        </span>
                        <div class="actions">
                            <button onclick="toggleComplete(${task.id})">${task.is_completed == 1 ? 'Undo' : 'Complete'}</button>
                            <button onclick="editTask(${task.id}, '${task.task.replace(/'/g, "\\'")}')">Edit</button>
                            <button onclick="deleteTask(${task.id})" class="delete">Delete</button>
                        </div>
                    `;
                    tasksUl.appendChild(li);
                });
            });
    }

    loadTasks();

    // Add task
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        let taskText = input.value.trim();
        if (!taskText) return;

        fetch('add_task.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'task=' + encodeURIComponent(taskText)
        }).then(() => {
            input.value = '';
            loadTasks();
        });
    });

    // Delete task
    window.deleteTask = function(id) {
        fetch('delete_task.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + id
        }).then(() => loadTasks());
    };

    // Toggle complete
    window.toggleComplete = function(id) {
        fetch('update_task.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + id
        }).then(() => loadTasks());
    };

    // Edit task
    window.editTask = function(id, oldTask) {
        const newTask = prompt("Edit your task:", oldTask);
        if (newTask && newTask.trim() !== "") {
            fetch('edit_task.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id=' + id + '&task=' + encodeURIComponent(newTask)
            }).then(() => loadTasks());
        }
    };
});
</script>
</body>
</html>
