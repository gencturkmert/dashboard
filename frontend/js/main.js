import { validateToken, redirectToLogin } from "./auth.js";
import { initializeRouting } from "./routing.js";

// Function to clear the token from local storage
function clearToken() {
  localStorage.removeItem("token");
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

// Validate the token and load initial content
try {
  validateToken(function (isValid) {
    console.log(isValid);
    if (isValid) {
      initializeRouting();
    } else {
      redirectToLogin();
    }
  });
} catch (e) {
  console.log(e);
  redirectToLogin();
}

// Listen for popstate events
window.addEventListener("popstate", () => {
  initializeRouting();
});
