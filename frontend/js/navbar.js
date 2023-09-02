import { clearToken, redirectToLogin } from "./auth.js";

function logout() {
  clearToken();
  redirectToLogin();
}

function init() {
  $("#logout-button").on("click", function (event) {
    event.preventDefault();
    logout(); // Call the loginUser function when the login button is clicked
  });
}

init();
