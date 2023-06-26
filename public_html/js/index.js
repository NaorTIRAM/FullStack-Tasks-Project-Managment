
window.onload = function() {
    var userName = window.prompt("Please enter your name", "John Smith");
    if (userName != null) {
        alert("Hello "+userName+" This is the login site.You can login, or create new user")
    }
  }
  
   document.addEventListener("DOMContentLoaded", function () {
        const loginForm = document.getElementById("login-form");
    
        loginForm.addEventListener("submit", function (event) {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
    
        if (!validateUsername(username)) {
            alert("Please enter a valid username.");
            event.preventDefault();  // Only prevent form submission if there's an error
            return;
        }
    
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            event.preventDefault();  // Only prevent form submission if there's an error
            return;
        }
    
        console.log("Username:", username, "Password:", password);
        });
    });
    
    function validateUsername(username) {
        // You can adjust the regular expression to match your rules for a valid username
        const re = /^[a-zA-Z0-9]+$/;
        return re.test(String(username));
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
      