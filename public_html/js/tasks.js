window.onload = function() {
    var userName = window.prompt("Please enter your name", "John Smith");
    if (userName != null) {
        alert("Hello "+userName+" this is the task site. You can add tasks here, delete and edit them")

        
    }
  }
  
function fetchTasks() {
    fetch('get_tasks.php')
        .then(response => response.json())
        .then(tasks => displayTasks(tasks))
        .catch(error => console.error('Error fetching tasks:', error));
}
function displayTasks(tasks) {
    const tasksTableBody = document.querySelector('#tasks-table tbody');
    tasksTableBody.innerHTML = '';
    tasks.forEach(task => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td data-id="${task.id}" data-field="task_name">${task.task_name}</td>
            <td contenteditable="true" data-id="${task.id}" data-field="due_date">${task.due_date}</td>
            <td data-id="${task.id}" data-field="project_id">${task.project_name}</td>
            <td contenteditable="true" data-id="${task.id}" data-field="status">${task.status}</td>
            <td>
                <button class="delete-task" data-id="${task.id}">Delete</button>
            </td>
        `;

        tasksTableBody.appendChild(row);
    });
}
fetchTasks();

document.getElementById('show-add-task-form-btn').addEventListener('click', function() {
    console.log("a");
    var form = document.getElementById('add-task-form');
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
});
document.querySelector('#tasks-table tbody').addEventListener('click', (event) => {
    const id = event.target.dataset.id;
    const field = event.target.dataset.field;
    const value = event.target.textContent;
    if (event.target.classList.contains('delete-task')) {
        fetch(`delete_task.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchTasks();
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
    }
    if (event.target.classList.contains('edit-task')) {
        document.getElementById('edit-task-form').style.display = 'block';
        document.getElementById('edit-task-id').value = id;
      }
    });


document.querySelector('#tasks-table tbody').addEventListener('blur', (event) => {
    const id = event.target.dataset.id;
    const field = event.target.dataset.field;
    const value = event.target.textContent;

    if (field === 'due_date' || field === 'status') {
        fetch(`edit_task.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, [field]: value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchTasks();
                alert('Task updated successfully');
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error editing task:', error));
    }
}, true);


document.getElementById('add-task-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_task.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            var response;
            try {
                response = JSON.parse(xhr.responseText);
            } catch (e) {
                console.error('Could not parse response as JSON');
                return;
            }
            if (response.success) {
                fetchTasks();
                alert('Task added successfully');
                location.reload();
            } else {
                console.error('Failed to add task: ' + response.message);
            }
        }
    };
    var data = {
        task_name: document.getElementById('task-name').value,
        due_date: document.getElementById('task-due-date').value,
        project_id: document.getElementById('task-project').value,
        status: document.getElementById('task-status').value,  
    };
    xhr.send(JSON.stringify(data));
});

document.getElementById('edit-task-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'edit_task.php', true);
    xhr.setRequestHeader('Content-Type','application/json');

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);  // log the server response for debugging
            var response;
            try {
                response = JSON.parse(xhr.responseText);
            } catch (e) {
                console.error('Could not parse response as JSON');
                return;
            }
            if (response.success) {
                fetchTasks(); // reload tasks
                alert('Task updated successfully');
                location.reload();
            } else {
                console.error('Failed to update task: ' + response.message);
            }
        }
    };
      
    var data = {
        id: document.getElementById('edit-task-id').value,
        task_name: document.getElementById('edit-task-name').value,
        due_date: document.getElementById('edit-task-due-date').value,
        status: document.getElementById('edit-task-status').value
    };
  
    xhr.send(JSON.stringify(data));
});
document.querySelector('#tasks-table tbody').addEventListener('click', (event) => {
    const id = event.target.dataset.id;
    const field = event.target.dataset.field;
    const value = event.target.textContent;
    if (event.target.classList.contains('delete-task')) {
        fetch(`delete_task.php?id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchTasks();
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error deleting task:', error));
    }
});

document.getElementById('cancel-add-task-btn').addEventListener('click', function() {
    document.getElementById('add-task-form').style.display = "none";
});

document.getElementById('cancel-edit-task-btn').addEventListener('click', function() {
    document.getElementById('edit-task-form').style.display = "none";
});

document.querySelector('contact_form').addEventListener('submit', function(e) {
    var fields = [
      { id: '#first_name', name: 'Full Name' },
      { id: '#email_addr', name: 'Email Address' },
      { id: '#phone_input', name: 'Phone Number' },
      { id: '#message', name: 'Message' },
    ];
  
    for (var i = 0; i < fields.length; i++) {
      var field = fields[i];
      var value = document.querySelector(field.id).value;
  
      if (value === '') {
        e.preventDefault();
        window.alert(field.name + ' is required!');
        return;
      }
    }
  
    // Using innerHTML to set the content of a specific element
    var formStatus = document.getElementById('form_status');
    if (formStatus) {
      formStatus.innerHTML = 'Form is being submitted';
    }
  
    // Displaying a success message using window.alert
    window.alert('Form is being submitted');
  });
  