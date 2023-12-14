$(function() {
    $('#login-form').submit(function(event) {
      event.preventDefault();
  
      var email = $('#email').val();
      var password = $('#password').val();
  
      // perform client-side validation on the email and password
      if (email.trim() === '') {
        $('#login-error').html('Email is required').removeClass('d-none');
        return;
      }
      if (password.trim() === '') {
        $('#login-error').html('Password is required').removeClass('d-none');
        return;
      }
  
      // send the login request to the server using jQuery AJAX
      $.ajax({
        url: 'login.php',
        type: 'POST',
        data: {
          email: email,
          password: password
        },
        dataType: 'json',
        success: function(response) {
          // redirect the user to the profile page on successful login
          window.location.href = 'profile.php';
        },
        error: function(xhr, status, error) {
          // display the error message returned by the server
          var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred while logging in';
          $('#login-error').html(errorMessage).removeClass('d-none');
        }
      });
    });
  });
  