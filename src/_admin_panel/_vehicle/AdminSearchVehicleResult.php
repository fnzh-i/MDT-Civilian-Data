<?php
  require_once __DIR__ . '/../../bootstrap.php';
  $plateNumber = $_GET['plate-number'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN VEHICLE RESULT</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 18px;
    }
    button, input {
      font: inherit;
    }
  </style>
</head>
<body>
  <h2>ADMIN SEARCH VEHICLE RESULT</h2> <br>
  <div id="result"></div>

  <script>
    const plateNumber = "<?php echo $plateNumber; ?>";

    fetch("../../_modules/Controller.php", {
      method: "POST",
      headers: {"Content-Type": "application/x-www-form-urlencoded"},
      body: "action=SEARCH-PLATE-NUMBER&plate-number=" + encodeURIComponent(plateNumber)
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === "error") {
        document.getElementById("result").innerHTML = `<p>${data.message}</p>`;
        return;
      }

      const veh = data.vehicle;
      const lic = data.license;
      const person = data.person;

      let table = `
        <table border="1" cellpadding="8">
          <tr><th>Plate Number</th><td>${veh.plate}</td></tr>
          <tr><th>MV File Number</th><td>${veh.mvFile ?? ""}</td></tr>
          <tr><th>VIN</th><td>${veh.vin}</td></tr>
          <tr><th>Brand</th><td>${veh.brand}</td></tr>
          <tr><th>Model</th><td>${veh.model}</td></tr>
          <tr><th>Color</th><td>${veh.color}</td></tr>
          <tr><th>Year</th><td>${veh.year}</td></tr>
          <tr><th>Registration Expiry</th><td>${veh.regExpiry}</td></tr>
          <tr><th>Status</th><td>${veh.status}</td></tr>
          <tr><th>License Number</th><td>${lic.license_number ?? ""}</td></tr>
        </table>

        <br>
        <a href="AdminCreateVehicle.php?plate-number=${veh.plate}">UPDATE</a>
        <button id="deleteBtn">DELETE</button>
      `;

      document.getElementById("result").innerHTML = table;

      document.getElementById("deleteBtn").addEventListener("click", () => {
        if (!confirm("Are you sure you want to delete this vehicle?")) return;

        fetch("../../_modules/Controller.php", {
          method: "POST",
          headers: {"Content-Type": "application/x-www-form-urlencoded"},
          body: "action=DELETE-VEHICLE&plate-number=" + encodeURIComponent(veh.plate)
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === "success") {
            alert(data.message);
            window.location.href = "AdminSearchVehicle.php"; // BACK TO ADMIN SEARCH VEHICLE
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch(err => alert("Fetch error: " + err));
      });
    });
  </script>
</body>
</html>
