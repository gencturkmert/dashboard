import { getAnimals, getCamps, getEmployees, getKinds } from "./service.js";

// Function to calculate camp capacity rate
function calculateCampCapacityRate(animals, camps) {
  const campToRateMap = new Map();

  camps.forEach((camp) => {
    const campId = camp.id;
    const maxCapacity = camp.max_capacity;
    let currentCapacity = 0;

    animals.forEach((animal) => {
      if (animal.camp === campId) {
        currentCapacity++;
      }
    });

    const capacityRate = parseInt((currentCapacity / maxCapacity) * 100);
    campToRateMap.set(camp.name, capacityRate);
  });

  return campToRateMap;
}

// Function to count animals per kind
function countAnimalsPerKind(animals, kinds) {
  console.log(kinds);
  const kindCounts = {};

  animals.forEach((animal) => {
    const kindId = animal.kind_id;

    if (!kindCounts[kindId]) {
      kindCounts[kindId] = 1;
    } else {
      kindCounts[kindId]++;
    }
  });

  const kindData = kinds.map((kind) => ({
    name: kind.name,
    y: kindCounts[kind.id] || 0,
  }));

  return kindData;
}

function renderPieChart(animals, kinds) {
  const kindData = countAnimalsPerKind(animals, kinds);

  Highcharts.chart("kind-chart-container", {
    chart: {
      type: "pie",
    },
    title: {
      text: "Animals by Kind",
    },
    series: [
      {
        name: "Number of Animals",
        colorByPoint: true,
        data: kindData,
      },
    ],
  });
}

function renderCampBarChart(animals, camps) {
  const campToRateMap = calculateCampCapacityRate(animals, camps);

  Highcharts.chart("camp-chart-container", {
    chart: {
      type: "bar",
    },
    title: {
      text: "Camp Capacity Rate",
    },
    xAxis: {
      categories: Array.from(campToRateMap.keys()),
      title: {
        text: "Camp",
      },
    },
    yAxis: {
      min: 0,
      max: 100,
      title: {
        text: "Solidity Rate (%)",
      },
    },
    series: [
      {
        name: "Animals Solidity Rate %",
        data: Array.from(campToRateMap.values()),
      },
    ],
  });
}

function loadAndRenderCharts() {
  Promise.all([getAnimals(), getCamps(), getKinds(), getEmployees()])
    .then(([animals, camps, kinds, employees]) => {
      renderCampBarChart(animals, camps);
      renderPieChart(animals, kinds);
      createManagerCards(employees, camps, animals);
    })
    .catch((error) => {
      console.error("Error loading data:", error);
    });
}

function createManagerCards(employees, camps, animals) {
  const managers = employees.filter((employee) => employee.role === "manager");

  const container = document.getElementById("manager-cards-container");

  const gridRow = document.createElement("div");
  gridRow.classList.add("row");

  managers.forEach((manager) => {
    const gridColumn = document.createElement("div");
    gridColumn.classList.add("equal", "width", "column");
    gridColumn.style.width = "20%";

    const card = document.createElement("div");
    card.classList.add("ui", "card");

    const image = document.createElement("div");
    image.classList.add("image");
    const gender =
      manager.gender === "MALE" ? "assets/male.png" : "assets/female.png";
    image.innerHTML = `<img src="${gender}">`;

    const content = document.createElement("div");
    content.classList.add("content");

    const header = document.createElement("div");
    header.classList.add("header");
    header.innerText = `${manager.name} ${manager.surname}`;

    const meta = document.createElement("div");
    meta.classList.add("meta");
    meta.innerText = camps[manager.location - 1].name;

    const description = document.createElement("div");
    description.classList.add("description");
    description.innerHTML = `Number of Subordinates: ${countSubordinates(
      employees,
      manager.id
    )}<br>Number of Animals: ${countAnimals(animals, employees, manager.id)}`;

    content.appendChild(header);
    content.appendChild(meta);
    content.appendChild(description);

    card.appendChild(image);
    card.appendChild(content);

    gridColumn.appendChild(card);

    gridRow.appendChild(gridColumn);

    container.appendChild(gridRow);
  });
}

function countSubordinates(employees, managerId) {
  return employees.filter((employee) => employee.chief_id === managerId).length;
}

function countAnimals(animals, employees, managerId) {
  const filteredEmployees = employees.filter(
    (employee) => employee.chief_id === managerId
  );

  let count = 0;

  for (const animal of animals) {
    if (
      filteredEmployees.some((employee) => employee.id === animal.caretaker_id)
    ) {
      count++;
    }
  }

  return count;
}

loadAndRenderCharts();
