export function getAnimals() {
  const token = localStorage.getItem("token");
  return $.ajax({
    url: "/admin/animals",
    method: "GET",
    headers: {
      Authorization: `Bearer ${token}`,
    },
  }).then((response) => JSON.parse(response));
}

export function getCamps() {
  const token = localStorage.getItem("token");
  return $.ajax({
    url: "/admin/camps",
    method: "GET",
    headers: {
      Authorization: `Bearer ${token}`,
    },
  }).then((response) => JSON.parse(response));
}

export function getEmployees() {
  const token = localStorage.getItem("token");
  return $.ajax({
    url: "/admin/employees",
    method: "GET",
    headers: {
      Authorization: `Bearer ${token}`,
    },
  }).then((response) => JSON.parse(response));
}

export function getKinds() {
  const token = localStorage.getItem("token");
  return $.ajax({
    url: "/admin/kinds",
    method: "GET",
    headers: {
      Authorization: `Bearer ${token}`,
    },
  }).then((response) => JSON.parse(response));
}

export function deleteEmployee(employeeId) {
  const token = localStorage.getItem("token");
  const deleteData = {
    id: employeeId,
  };
  console.log(deleteData);
  $.ajax({
    url: "/admin/deleteEmployee",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(deleteData),
    headers: {
      Authorization: `Bearer ${token}`,
    },
  }).then((response) => {
    JSON.parse(response);
  });
}

export function getRoles() {
  return ["caretaker", "worker"];
}

export function updateEmployee(updatedEmployeeData) {
  const token = localStorage.getItem("token");

  $.ajax({
    url: "/admin/updateEmployee",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(updatedEmployeeData),
    headers: {
      Authorization: `Bearer ${token}`,
    },
  }).then((response) => JSON.parse(response));
}
