import { redirectToDashboard } from "./auth.js";

function loginUser() {
  const username = $('input[name="username"]').val();
  const password = $('input[name="password"]').val();

  if (username === "" || password === "") {
    showErrorNotification("Username and password are required.");
    return;
  }

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
    success: function (data) {
      // Successful response
      // Parse the response JSON to get the bearer token
      data = JSON.parse(data);
      const bearerToken = data["token"];

      // Store the bearer token in local storage
      localStorage.setItem("token", bearerToken);

      // Redirect to the dashboard or another authorized page
      redirectToDashboard();
    },
    error: function (xhr) {
      // Error response
      // Handle the error if needed
      console.error("Login failed");
      // You can add additional error handling here if required
      showErrorNotification("Login failed"); // Show an error notification
    },
  });
}

// Function to initialize the login page
function initializeLoginPage() {
  // Attach a click event handler to the login button
  $("#login-button").on("click", function (event) {
    event.preventDefault();
    loginUser(); // Call the loginUser function when the login button is clicked
  });
}

// Function to show an error notification
function showErrorNotification(message) {
  const notification = $("#notification");
  const notificationText = $("#notification-text");

  // Set the error message
  notificationText.text(message);

  // Show the notification
  notification.css("display", "block");

  // Close the notification when the close icon is clicked
  notification.find(".close.icon").on("click", function () {
    notification.css("display", "none");
  });
}

// Initialize the login page
initializeLoginPage();
