// Function to get a token from local storage
export function getToken() {
  return localStorage.getItem("token");
}

export function clearToken() {
  localStorage.setItemetItem("token", "");
}

// Function to validate the token via an API call
export function validateToken(callback) {
  const loginData = {
    token: getToken(),
  };

  $.ajax({
    url: "/auth/validate",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(loginData),
    success: function (data) {
      data = JSON.parse(data);

      callback(data["success"]);
    },
    error: function (error) {
      callback(false);
    },
  });
}

// Function to redirect to the login page
export function redirectToLogin() {
  console.log("redirect to login");
  window.location.href = "/bashdoard/login"; // Update the URL as needed
}

export function redirectToDashboard() {
  console.log("redirect to dashb");
  window.location.href = "/bashdoard/dashboard"; // Update the URL as needed
}
