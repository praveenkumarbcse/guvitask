$(document).ready(function() {
    $('#register-form').submit(function(event) {
      event.preventDefault();
      var email = $('#email').val();
      var password = $('#password').val();
      var confirmPassword = $('#confirm-password').val();
      // perform client-side validation on the email and password
      if (email.trim() === '' || password.trim() === '' || confirmPassword.trim() === '') {
        alert('Email and password fields are required');
        return;
      }
      if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
      }
      // perform AJAX request to register the user
      $.ajax({
        url: 'register.php',
        type: 'POST',
        data: { email: email, password: password },
        success: function(response) {
          // redirect to the login page on successful registration
          window.location.href = 'login.php';
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // display error message if registration fails
          alert('Failed to register user: ' + errorThrown);
        }
      });
    });
  });
  