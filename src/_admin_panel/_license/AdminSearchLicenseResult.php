<?php
  require_once __DIR__ . '/../../bootstrap.php';
  $licenseNumber = $_GET['license-number'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN LICENSE RESULT</title>
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
  <h2>ADMIN SEARCH LICENSE RESULT</h2> <br>
  <div id="result"></div>

  <script>
    const licenseNumber = "<?php echo $licenseNumber; ?>";

    fetch("../../_modules/Controller.php", {
      method: "POST",
      headers: {"Content-Type": "application/x-www-form-urlencoded"},
      body: "action=SEARCH-LICENSE-NUMBER&license-number=" + encodeURIComponent(licenseNumber)
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === "error") {
        document.getElementById("result").innerHTML = `<p>${data.message}</p>`;
        return;
      }

      const lic = data.license;

      let table = `
        <table border="1" cellpadding="8">
          <tr><th>License Number</th><td>${lic.licenseNumber}</td></tr>
          <tr><th>Status</th><td>${lic.status}</td></tr>
          <tr><th>Type</th><td>${lic.type}</td></tr>
          <tr><th>Issue Date</th><td>${lic.issueDate}</td></tr>
          <tr><th>Expiry Date</th><td>${lic.expiryDate}</td></tr>
          <tr><th>DL Codes</th><td>${lic.dl_codes}</td></tr>
          <tr><th>Name</th><td>${lic.first_name} ${lic.middle_name ?? ""} ${lic.last_name}</td></tr>
          <tr><th>Birthday</th><td>${lic.date_of_birth}</td></tr>
          <tr><th>Gender</th><td>${lic.gender}</td></tr>
          <tr><th>Address</th><td>${lic.address}</td></tr>
          <tr><th>Nationality</th><td>${lic.nationality}</td></tr>
          <tr><th>Height</th><td>${lic.height}</td></tr>
          <tr><th>Weight</th><td>${lic.weight}</td></tr>
          <tr><th>Eye Color</th><td>${lic.eye_color}</td></tr>
          <tr><th>Blood Type</th><td>${lic.blood_type}</td></tr>
        </table>

        <br>
        <a href="AdminCreateLicense.php?license-number=${lic.licenseNumber}">UPDATE</a>
        <button id="deleteBtn">DELETE</button>
      `;

      document.getElementById("result").innerHTML = table;


      document.getElementById("deleteBtn").addEventListener("click", () => {
        if (!confirm("Are you sure you want to delete this license?")) return;

        fetch("../../_modules/Controller.php", {
          method: "POST",
          headers: {"Content-Type": "application/x-www-form-urlencoded"},
          body: "action=DELETE-LICENSE&license-number=" + encodeURIComponent(lic.licenseNumber)
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === "success") {
            alert(data.message);
            window.location.href = "AdminSearchLicense.php"; // BACK TO SEARCH LICENSE PAGE
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