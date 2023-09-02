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
