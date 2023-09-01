// Function to get a cookie by name
function getCookie(name) {
  const cookieValue = document.cookie.match(
    "(^|;)\\s*" + name + "\\s*=\\s*([^;]+)"
  );
  return cookieValue ? cookieValue.pop() : "";
}

// Function to validate the token via an API call
async function validateToken(token) {
  try {
    const response = await fetch("/backend/token-validation-endpoint", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ token: token }),
    });

    if (response.ok) {
      // Token is valid, return true
      return true;
    }
  } catch (error) {
    console.error("Error validating token:", error);
  }

  // Token validation failed or there was an error, redirect to login page
  window.location.href = "/login";
  return false;
}

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

// Function to hide the error notification
function hideErrorNotification() {
  const notification = document.getElementById("notification");
  notification.style.display = "none";
}

// Function to load page content based on the route
function loadPageContent(route) {
  const app = document.getElementById("app");

  // Define routes and their corresponding HTML files
  const routes = {
    "/": "index.html",
    "/login": "login.html",
    "/dashboard": "dashboard.html",
    "/statistics": "statistics.html",
    "/management": "management.html",
  };

  // Check if the route exists in the defined routes
  if (routes.hasOwnProperty(route)) {
    const pagePath = routes[route];

    // Fetch and load the page content
    fetch(`/frontend/${pagePath}`)
      .then((response) => response.text())
      .then((pageContent) => {
        app.innerHTML = pageContent;
      })
      .catch((error) => {
        console.error("Error loading page:", error);
        // Show an error notification for other errors
        showErrorNotification("An error occurred while loading the page.");
      });
  } else {
    // Route not found, handle accordingly (e.g., show a 404 page)
    //404 ekle
    app.innerHTML = "<h1>Page not found</h1>";
  }
}

// Check for the presence of a valid token
const token = getCookie("token");

// Define the initial route based on the URL
const initialRoute = window.location.pathname;

// Validate the token and load initial content
validateToken(token).then((isValid) => {
  if (isValid) {
    loadPageContent(initialRoute);
  }
});

// Listen for popstate events
window.addEventListener("popstate", () => {
  const newRoute = window.location.pathname;
  loadPageContent(newRoute);
});
