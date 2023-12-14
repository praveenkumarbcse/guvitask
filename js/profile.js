$(document).ready(function() {
    // Retrieve user profile details on page load
    $.ajax({
      url: "get_profile.php",
      type: "GET",
      dataType: "json",
      success: function(data) {
        // Fill in the profile details form with retrieved data
        $("#age").val(data.age);
        $("#dob").val(data.dob);
        $("#contact").val(data.contact);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  
    // Handle update profile form submission
    $("#update-profile-form").submit(function(event) {
      event.preventDefault(); // Prevent form submission
  
      // Serialize form data
      var formData = $(this).serialize();
  
      // Send AJAX request to update profile in the database
      $.ajax({
        url: "update_profile.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(data) {
          // Display success message
          $("#success-message").text("Profile updated successfully!");
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Display error message
          $("#error-message").text("Error updating profile!");
        }
      });
    });
  });
  