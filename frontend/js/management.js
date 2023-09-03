import {
  getCamps,
  getEmployees,
  deleteEmployee,
  getRoles,
  updateEmployee,
} from "./service.js";

function initializeDataTable(employeeData, campData, chiefsData, rolesData) {
  let table;
  table = $("#table-container").DataTable({
    data: employeeData,
    columns: [
      { data: "name", title: "Name" },
      { data: "surname", title: "Surname" },
      { data: "age", title: "Age" },
      {
        data: "camp",
        title: "Camp",
        render: function (data, type, row) {
          const camp = campData.find((camp) => camp.id === data);
          return camp ? camp.name : "";
        },
      },
      {
        data: "role",
        title: "Role",
        render: function (data, type, row) {
          const role = rolesData.find((role) => role === data);
          return role.charAt(0).toUpperCase() + role.slice(1);
        },
      },
      {
        data: "chief_id",
        title: "Chief",
        render: function (data, type, row) {
          const chief = chiefsData.find((chief) => chief.id === data);
          return chief.name + " " + chief.surname;
        },
      },
      {
        data: "id",
        title: "Actions",
        render: function (data, type, row) {
          return `<td>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <button class="ui small icon red button delete-button" data-employee-id="${row.id}">
                            <i class="trash icon"></i>
                        </button>
                        <button class="ui small icon primary button edit-button" data-employee-id="${row.id}">
                            <i class="pencil icon"></i>
                        </button>
                    </div>
                </td>`;
        },
      },
    ],
  });

  $("#table-container").on("click", ".delete-button", function () {
    const employeeId = $(this).data("employee-id");
    deleteEmployee(employeeId)
      .then((response) => {
        table.row($(this).parents("tr")).remove().draw();
      })
      .catch((error) => {
        console.error("Error deleting employee:", error);
      });
  });

  var tempEmployeeId;
  $("#table-container").on("click", ".edit-button", function () {
    const employeeId = $(this).data("employee-id");
    const employee = employeeData.find(
      (employee) => parseInt(employee.id) === employeeId
    );

    $("#edit-name").val(employee.name);
    $("#edit-surname").val(employee.surname);
    $("#edit-role").val(employee.role);
    $("#edit-chief").val(employee.chief_id);
    $("#edit-camp").val(employee.camp);

    $("#edit-modal").modal("show");

    tempEmployeeId = employeeId;
  });

  $("#edit-save").click(function () {
    const updatedEmployeeData = {
      id: tempEmployeeId,
      name: $("#edit-name").val(),
      surname: $("#edit-surname").val(),
      role: $("#edit-role").val(),
      chief: $("#edit-chief").val(),
      camp: $("#edit-camp").val(),
    };

    updateEmployee(updatedEmployeeData)
      .then(() => {
        $("#edit-modal").modal("hide");

        const index = employeeData.findIndex(
          (employee) => parseInt(employee.id) === updatedEmployeeData.id
        );

        if (index !== -1) {
          console.log(index);
          employeeData[index] = updatedEmployeeData;

          initializeDataTable(employeeData, campData, chiefsData, rolesData);
          return;
        }
      })
      .catch((error) => {
        console.error("Error updating employee:", error);
      });
  });
}

function createEmployeeDataTable() {
  Promise.all([getEmployees(), getCamps(), getRoles()])
    .then(([employees, camps, roles]) => {
      initializeDataTable(
        employees.filter((employee) => employee.role != "manager"),
        camps,
        employees.filter((employee) => employee.role === "manager"),
        roles
      );
      populateCampsSelect(camps);
      populateRolesSelect(roles);
      populateChiefsSelect(
        employees.filter((employee) => employee.role === "manager")
      );
    })
    .catch((error) => {
      console.error("Error loading data:", error);

      //   location.reload();
    });
}

function populateCampsSelect(campsData) {
  const $campSelect = $("#edit-camp");
  $campSelect.empty();
  campsData.forEach(function (camp) {
    $campSelect.append(
      $("<option>", {
        value: camp.id,
        text: camp.name,
      })
    );
  });
}

function populateRolesSelect(rolesData) {
  const $roleSelect = $("#edit-role");
  $roleSelect.empty();
  rolesData.forEach(function (role) {
    $roleSelect.append(
      $("<option>", {
        value: role,
        text: role,
      })
    );
  });
}

function populateChiefsSelect(chiefsData) {
  const $chiefSelect = $("#edit-chief");
  $chiefSelect.empty();
  chiefsData.forEach(function (chief) {
    $chiefSelect.append(
      $("<option>", {
        value: chief.id,
        text: `${chief.name} ${chief.surname}`,
      })
    );
  });
}

createEmployeeDataTable();
