import { clearToken, redirectToLogin } from "./auth.js";

function logout() {
  clearToken();
  redirectToLogin();
}
