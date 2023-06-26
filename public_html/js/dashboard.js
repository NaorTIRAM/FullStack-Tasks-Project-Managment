window.onload = function() {
    var userName = window.prompt("Please enter your name", "John Smith");
    if (userName != null) {
        alert("Hello "+userName+" This is the dashboard site.You can see the active projects and tasks here")
    }
  }
  
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
  