import { getAnimals, getCamps, getKinds, getEmployees } from "./service.js";

var campsData = null;
var animalsData = null;
var employeesData = null;
var kindsData = null;

function showCampStatistics() {
  // Calculate the values for each camp
  const campData = campsData.map((camp) => {
    const numAnimals = getNumberOfAnimals(animalsData, camp.id);
    const maxCapacity = parseInt(camp.max_capacity);
    const campKinds = getNumberOfKinds(animalsData, kindsData, camp.id);
    const campCaretakers = getNumberOfCaretakers(employeesData, camp.id);
    const campWorkers = getNumberOfWorkers(employeesData, camp.id);

    return {
      name: camp.name,
      numAnimals,
      maxCapacity,
      numKinds: campKinds,
      numCaretakers: campCaretakers,
      numWorkers: campWorkers,
    };
  });

  // Create the Highcharts chart
  Highcharts.chart("statistics-container", {
    chart: {
      type: "column",
      backgroundColor: "#FFFF",
    },
    title: {
      text: "Camp Statistics",
    },
    xAxis: {
      categories: campData.map((camp) => camp.name),
    },
    yAxis: {
      min: 0,
      max: 30,
      title: {
        text: "Count",
      },
    },
    series: [
      {
        name: "Number of Animals",
        data: campData.map((camp) => camp.numAnimals),
      },
      {
        name: "Max Capacity",
        data: campData.map((camp) => camp.maxCapacity),
      },

      {
        name: "Number of Kinds",
        data: campData.map((camp) => camp.numKinds.length),
      },
      {
        name: "Number of Caretakers",
        data: campData.map((camp) => camp.numCaretakers),
      },
      {
        name: "Number of Workers",
        data: campData.map((camp) => camp.numWorkers),
      },
    ],
  });
}

// Example empty functions that return calculated values
function getNumberOfAnimals(animals, campId) {
  let currentCapacity = 0;
  animals.forEach((animal) => {
    if (animal.camp === campId) {
      currentCapacity++;
    }
  });

  return currentCapacity;
}

function showAnimalStatistics() {
  const mainChartData = kindsData.map((kind) => {
    const animals = animalsData.filter((animal) => animal.kind_id === kind.id);
    return {
      kind: kind,
      animalsOfThatKind: animals,
    };
  });

  const mainChartCategories = mainChartData.map((item) => item.kind.name);
  const mainChartSeriesData = mainChartData.map((item) => ({
    name: item.kind.name,
    y: calculateAverageAge(item.animalsOfThatKind),
    drilldown: true,
  }));

  let originalCategories;
  // Prepare data for drilldown charts
  Highcharts.chart("statistics-container", {
    chart: {
      type: "column",
      events: {
        drilldown: function (e) {
          if (!e.seriesOptions) {
            const chart = this;
            const kindId = e.point.name;
            console.log("kindid", kindId);
            console.log(mainChartData);
            const animalsData = mainChartData.find(
              (data) => data.kind.name === kindId
            ).animalsOfThatKind;

            console.log("animals.data", animalsData);
            const drilldownSeriesData = animalsData.map((animal) => ({
              name: animal.name,
              y: parseInt(animal.age),
            }));

            console.log("drilldowndata", drilldownSeriesData);

            originalCategories = chart.xAxis[0].categories.slice();

            chart.xAxis[0].setCategories(
              animalsData.map((animal) => animal.name),
              false
            );

            setTimeout(function () {
              chart.hideLoading();
              chart.addSeriesAsDrilldown(e.point, {
                name: e.point.name,
                data: drilldownSeriesData,
              });
            }, 10);
          }
        },
        drillup: function () {
          // When drilling up, restore the original categories
          this.xAxis[0].setCategories(originalCategories, false);
        },
      },
    },
    title: {
      text: "Average Animal Age by Kind",
    },
    xAxis: {
      type: "category",
      categories: mainChartCategories,
    },
    yAxis: {
      title: {
        text: "Average Age",
      },
    },
    series: [
      {
        name: "Average Age",
        data: mainChartSeriesData,
      },
    ],
    drilldown: {
      series: [],
    },
  });
}

function showEmployeeStatistics() {
  Highcharts.chart("statistics-container", {
    chart: {
      type: "column",
    },
    title: {
      text: "Camp Statistics",
    },
    xAxis: {
      categories: campsData.map((camp) => camp.name),
      crosshair: true,
    },
    yAxis: [
      {
        title: {
          text: "Average Age",
        },
        min: 18,
        max: 70,
      },
    ],
    tooltip: {
      shared: true,
    },
    plotOptions: {
      column: {
        pointPadding: 0.2,
        borderWidth: 0,
      },
    },
    series: [
      {
        name: "Average Age",
        data: campsData.map((camp) => {
          const employeesInCamp = employeesData.filter(
            (employee) => employee.camp === camp.id
          );
          const totalAge = employeesInCamp.reduce(
            (sum, employee) => sum + parseInt(employee.age),
            0
          );
          const averageAge =
            employeesInCamp.length > 0 ? totalAge / employeesInCamp.length : 0;

          return {
            y: parseInt(averageAge),
          };
        }),
      },
      {
        type: "pie",
        name: "Gender Distribution",
        center: [80, 50], // Position the pie chart in the top-left corner
        size: 100, // Set the size of the pie chart
        data: genderRateData(),
      },
    ],
  });

  // Function to generate pie chart data for gender rate
  function genderRateData() {
    const maleCount = employeesData.filter(
      (employee) => employee.gender === "MALE"
    ).length;
    const femaleCount = employeesData.filter(
      (employee) => employee.gender === "FEMALE"
    ).length;

    const otherCount = employeesData.filter(
      (employee) => employee.gender === "OTHER"
    ).length;

    return [
      ["MALE", maleCount],
      ["FEMALE", femaleCount],
      ["OTHER", otherCount],
    ];
  }
}

function calculateAverageAge(animals) {
  let av = 0;
  animals.forEach((animal) => {
    av += parseInt(animal.age);
  });

  return parseInt(av / animals.length);
}

function getNumberOfKinds(animals, kinds, campId) {
  const campAnimals = animals.filter((animal) => animal.camp === campId);
  var uniqueKindIds = new Set();

  campAnimals.forEach((animal) => {
    uniqueKindIds.add(animal.kind_id);
  });

  return kinds.filter((kind) => uniqueKindIds.has(kind.id));
}

function getNumberOfCaretakers(employees, campId) {
  let count = 0;
  employees.forEach((employee) => {
    if (employee.camp === campId && employee.role === "caretaker") {
      count++;
    }
  });
  return count;
}

function getNumberOfWorkers(employees, campId) {
  let count = 0;
  employees.forEach((employee) => {
    if (employee.camp === campId && employee.role === "worker") {
      count++;
    }
  });
  return count;
}

// Listen for radio button changes
$(document).ready(function () {
  $('input[name="statistics-option"]').on("change", function () {
    const selectedOption = $('input[name="statistics-option"]:checked').attr(
      "id"
    );

    var camps = getCamps();
    var animals = getAnimals();

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

function setData(animals, camps, kinds, employees) {
  campsData = camps;
  animalsData = animals;
  employeesData = employees;
  kindsData = kinds;
}

function loadAndRenderCharts() {
  Promise.all([getAnimals(), getCamps(), getKinds(), getEmployees()])
    .then(([animals, camps, kinds, employees]) => {
      setData(animals, camps, kinds, employees);
      showCampStatistics();
    })
    .catch((error) => {
      console.error("Error loading data:", error);
    });
}

loadAndRenderCharts();
