// Function to get a token from local storage
export function getToken() {
  return localStorage.getItem("token");
}

// Function to validate the token via an API call
export function validateToken(token) {
  return new Promise((resolve, reject) => {
    const loginData = {
      token: getToken(),
    };

    $.ajax({
      url: "/auth/login",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(loginData),
      success: function (data) {
        resolve(data.isValid);
      },
      error: function (error) {
        console.error("Error validating token:", error);
        reject(error);
      },
    });
  });
}

// Function to redirect to the login page
export function redirectToLogin() {
  window.location.href = "/bashdoard/login"; // Update the URL as needed
}

export function redirectToDashboard() {
  window.location.href = "/bashdoard/dashboard"; // Update the URL as needed
}
