export function loadPageContent(route) {
  const app = document.getElementById("app");

  const routes = {
    "/bashdoard/": "index.html",
    "/bashdoard/login": "login.html",
    "/bashdoard/dashboard": "dashboard.html",
    "/bashdoard/statistics": "statistics.html",
    "/bashdoard/management": "management.html",
    "/frontend/index.html": "index.html",
    "/frontend/login.html": "login.html",
    "/frontend/dashboard.html": "dashboard.html",
    "/frontend/statistics.html": "statistics.html",
    "/frontend/management.html": "management.html",
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
        showErrorNotification(
          "An error occurred while loading the page.",
          error
        );
      });
  } else {
    // Route not found, handle accordingly (e.g., show a 404 page)
    //404 ekle
    app.innerHTML = "<h1>Page not found</h1>";
  }
}

// Function to initialize routing
export function initializeRouting() {
  // Listen for popstate events
  window.addEventListener("popstate", () => {
    const newRoute = window.location.pathname;
    loadPageContent(newRoute);
  });
}
