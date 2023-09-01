$(document).ready(function () {
  $("form").submit(function (event) {
    event.preventDefault();

    // Get the username and password entered by the user
    const username = $('input[name="username"]').val();
    const password = $('input[name="password"]').val();

    // Create an object to hold the login data
    const loginData = {
      username: username,
      password: password,
    };

    // Send a POST request to the backend for user authentication
    $.ajax({
      type: "POST",
      url: "/auth/login",
      contentType: "application/json",
      data: JSON.stringify(loginData),
      success: function (response) {
        // Check the response for authentication success or failure
        if (response.success) {
          // Redirect to the dashboard page upon successful login
          window.location.href = "/dashboard";
        } else {
          // Show an error message for authentication failure
          showErrorNotification(
            "Invalid username or password. Please try again."
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Error during login:", error);
        // Show an error notification for other errors
        showErrorNotification(
          "An error occurred during login. Please try again later."
        );
      },
    });
  });

  //Similar to main.js but to avoid infinite redirection, I did not include that in html file
  // Function to show an error notification
  function showErrorNotification(message) {
    const notification = document.getElementById("notification");
    const notificationText = document.getElementById("notification-text");

    // Set the error message
    notificationText.innerText = message;

    // Show the notification
    notification.style.display = "block";

    // Close the notification when the close icon is clicked
    notification.querySelector(".close.icon").addEventListener("click", () => {
      notification.style.display = "none";
    });
  }
});
