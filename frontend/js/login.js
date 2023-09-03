import { redirectToDashboard } from "./auth.js";

async function loginUser() {
  const username = $('input[name="username"]').val();
  const password = $('input[name="password"]').val();

  if (username === "" || password === "") {
    showErrorNotification("Username and password are required.");
    return;
  }

  const encryptedPassword = await encryptPassword(password);

  const loginData = {
    username: username,
    password: encryptedPassword,
  };

  $.ajax({
    type: "POST",
    url: "/auth/login",
    contentType: "application/json",
    data: JSON.stringify(loginData),
    success: function (data) {
      data = JSON.parse(data);
      const bearerToken = data["token"];
      localStorage.setItem("token", bearerToken);
      redirectToDashboard();
    },
    error: function (xhr) {
      console.error("Login failed");
      showErrorNotification("Login failed");
    },
  });
}

function initializeLoginPage() {
  $("#login-button").on("click", function (event) {
    event.preventDefault();
    loginUser();
  });
}

function showErrorNotification(message) {
  const notification = $("#notification");
  const notificationText = $("#notification-text");

  notificationText.text(message);
  notification.css("display", "block");

  notification.find(".close.icon").on("click", function () {
    notification.css("display", "none");
  });
}

async function encryptPassword(password) {
  const textEncoder = new TextEncoder();
  const passwordBuffer = textEncoder.encode(password);
  const passwordHash = await crypto.subtle.digest("SHA-256", passwordBuffer);
  return hexString(passwordHash);
}

function hexString(buffer) {
  const byteArray = new Uint8Array(buffer);
  const hexParts = [];
  byteArray.forEach((byte) => {
    const hex = byte.toString(16);
    hexParts.push(hex.padStart(2, "0"));
  });
  return hexParts.join("");
}

initializeLoginPage();
