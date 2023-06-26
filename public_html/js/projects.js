window.onload = function() {
  var userName = window.prompt("Please enter your name", "John Smith");
  if (userName != null) {
    alert("Hello "+userName+" this is the projects site.You can create, edit, and delete new projects")

  }
}

document.querySelectorAll('.edit-btn').forEach(function(button) {
    button.addEventListener('click', function(event) {
      let projectId = event.target.getAttribute('data-projectid');

      document.getElementById('edit-project-form').addEventListener('submit', function(event) {
        event.preventDefault();
  
        let projectName = document.getElementById('edit-project-name').value;
        let projectDescription = document.getElementById('edit-project-description').value;
        let projectStatus = document.getElementById('edit-project-status').value;
  
        fetch('edit_project.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            'project_id': projectId,
            'project-name': projectName,
            'project-description': projectDescription,
            'project-status': projectStatus,
          }),
        })
        .then(response => response.text())
        .then(data => {
          alert('Project updated successfully');
                location.reload();
        })
        .catch((error) => {
          console.error('Error:', error);
        });
      });
    });
  });
  
  document.querySelectorAll('.delete-btn').forEach(function(button) {
    button.addEventListener('click', function(event) {
      let projectId = event.target.getAttribute('data-projectid');
        if (confirm('Are you sure you want to delete this project?')) {
        fetch('delete_project.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            'project_id': projectId,
          }),
        })
        .then(response => response.text())
        .then(data => {
          alert('Project deleted successfully');
                location.reload();
        })
        .catch((error) => {
          console.error('Error:', error);
        });
      }
    });
  });

  document.querySelectorAll('.status-select').forEach(function(select) {
    select.addEventListener('change', function(e) {
      const projectId = this.dataset.projectid;
      const status = this.value;
      fetch('update_status.php', {
        method: 'POST',
        body: JSON.stringify({
          project_id: projectId,
          status: status
        }),
        headers: {
          'Content-Type': 'application/json'
        }
      }).then(function(response) {
        if(response.ok) {
          alert('Project Status updated successfully');
                location.reload();
        } else {
          alert('There was an error updating the status');
        }
      });
    });
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
  