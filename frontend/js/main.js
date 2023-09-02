import { getToken, validateToken, redirectToLogin } from "./auth.js";
import { initializeRouting } from "./routing.js";

// Function to clear the token from local storage
function clearToken() {
  localStorage.removeItem("token");
}

// Function to handle logout
function logout() {
  clearToken();
  redirectToLogin();
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

// Function to hide the error notification
function hideErrorNotification() {
  const notification = $("#notification");
  notification.css("display", "none");
}

// Check for the presence of a valid token
const token = getToken();

// Validate the token and load initial content
validateToken(token)
  .then((isValid) => {
    if (isValid) {
      // Redirect users with valid tokens to the dashboard page, but only if not on the login page
      if (window.location.pathname !== "/bashdoard/login") {
        window.location.href = "/bashdoard/dashboard";
      } else {
        initializeRouting();
      }
    } else {
      redirectToLogin();
    }
  })
  .catch(() => {
    redirectToLogin();
  });

// Listen for popstate events
window.addEventListener("popstate", () => {
  initializeRouting();
});
