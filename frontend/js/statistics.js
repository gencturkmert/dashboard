function showCampStatistics() {
  console.log("1");
}

function showAnimalStatistics() {
  console.log("2");
}

function showEmployeeStatistics() {
  console.log("3");
}

// Listen for radio button changes
$(document).ready(function () {
  $('input[name="statistics-option"]').on("change", function () {
    const selectedOption = $('input[name="statistics-option"]:checked').attr(
      "id"
    );

    // Call the corresponding function based on the selected option
    switch (selectedOption) {
      case "camp-stats":
        showCampStatistics();
        break;
      case "animal-stats":
        showAnimalStatistics();
        break;
      case "employee-stats":
        showEmployeeStatistics();
        break;
      default:
        break;
    }
  });
});

showCampStatistics();
