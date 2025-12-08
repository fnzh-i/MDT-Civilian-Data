// ================= API URL =================
const API_URL = "../../_modules/Controller.php";

let dashboardData = null;


// ================= LOGIN =================
function login() {
    const email = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const formData = new FormData();
    formData.append("action", "USER-LOGIN");
    formData.append("email", email);
    formData.append("password", password);

    fetch("../../_modules/Controller.php", {
        method: "POST",
        body: formData,
    })
        .then((res) => res.json())
        .then((response) => {
            console.log("Response from PHP:", response);

            if (response.status === "SUCCESS") {
                window.userRole = response.role;
                window.location.href = response.redirect;
            } else {
                const errorElement = document.getElementById("error");
                errorElement.innerText = response.message;
                errorElement.classList.remove("hidden");
            }
        })
        .catch((err) => {
            console.error("Fetch error:", err);
            alert("Error connecting to server.");
        });
}

// ================= FETCH DASHBOARD DATA =================
async function fetchDashboardData(licenseID) {
    const formData = new FormData();
    formData.append("action", "FETCH-DASHBOARD");
    formData.append("license_id", licenseID);

    try {
        const res = await fetch(API_URL, {
            method: "POST",
            body: formData,
        });

        const data = await res.json();

        if (!data || data.status === "error") {
            console.error("Dashboard load failed:", data?.message);
            return null;
        }

        return data;

    } catch (err) {
        console.error("Dashboard fetch error:", err);
        return null;
    }
}

// ================= LOAD LICENSE PANEL =================
function loadLicenseBox() {
    const L = dashboardData.user;
    const box = document.getElementById("licenseBox");

    box.innerHTML = `
        <div class="flex items-center gap-4 mb-4">
            <img src="../../../public/assets/id.png" class="w-14 h-14 opacity-90">
            <h2 class="text-2xl font-bold text-gray-800">Driver's License</h2>
        </div>

        <p><b>Name:</b> ${L.name}</p>
        <p><b>License #:</b> ${L.licenseNumber}</p>
        <p><b>Status:</b> ${L.licenseStatus}</p>
        <p><b>Expiration:</b> ${L.expiry}</p>

        <button onclick="window.location.href='user_license.php'"
            class="mt-6 w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
            View Full License Details
        </button>
    `;
}

// ================= LOAD VEHICLE PANEL =================
function loadVehicleBox() {
    const V = dashboardData.vehicles;
    const box = document.getElementById("vehicleBox");

    let vehiclesHTML = V.map(v => `
        <li class="border-b pb-2">
            <p class="font-bold">${v.name}</p>
            <p class="text-sm text-gray-600">Plate: ${v.plate}</p>
        </li>
    `).join("");

    box.innerHTML = `
        <div class="flex items-center gap-4 mb-4">
            <img src="../../../public/assets/car.png" class="w-14 h-14 opacity-90">
            <h2 class="text-2xl font-bold text-gray-800">Registered Vehicles</h2>
        </div>

        <ul class="space-y-3">
            ${vehiclesHTML}
        </ul>

        <button onclick="window.location.href='user_vehicle.php'"
            class="mt-6 w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
            View All Vehicles
        </button>
    `;
}

// ================= LOAD VIOLATION PANEL =================
function loadViolationBox() {
    const V = dashboardData.violations;
    const box = document.getElementById("violationBox");

    let violationsHTML = V.map(v => `
        <li class="border-b pb-2">
            <p class="font-bold text-red-600">${v.offense}</p>
            <p class="text-sm text-gray-600">Issued: ${v.date} - ₱${v.fine} Fine</p>
        </li>
    `).join("");

    box.innerHTML = `
        <div class="flex items-center gap-4 mb-4">
            <img src="../../../public/assets/ticket.png" class="w-14 h-14 opacity-90">
            <h2 class="text-2xl font-bold text-gray-800">Ticket Violations</h2>
        </div>

        <ul class="space-y-3">
            ${violationsHTML}
        </ul>

        <button onclick="window.location.href='user_violations.php'"
            class="mt-6 w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
            View Violations
        </button>
    `;
}

// ================= INIT DASHBOARD =================
document.addEventListener("DOMContentLoaded", async () => {
    const licenseID = document.body.getAttribute("data-license-id");
    if (!licenseID) return;

    dashboardData = await fetchDashboardData(licenseID);
    if (!dashboardData) return;

    // Load panels only if they exist on the page
    if (document.getElementById("licenseBox")) {
        loadLicenseBox();
    }
    if (document.getElementById("vehicleBox")) {
        loadVehicleBox();
    }
    if (document.getElementById("violationBox")) {
        loadViolationBox();
    }
});

function getCurrentPage() {
    const path = window.location.pathname;
    return path.substring(path.lastIndexOf("/") + 1);
}


function loadFullLicenseDetails() {
    const L = dashboardData.user;
    const box = document.getElementById("licenseFull");

    box.innerHTML = `
            <h2 class="text-3xl font-bold mb-4">Driver’s License Information</h2>

            <p><b>Name:</b> ${L.name}</p>
            <p><b>License Number:</b> ${L.licenseNumber}</p>
            <p><b>Status:</b> ${L.licenseStatus}</p>
            <p><b>Date of Birth:</b> ${L.dob}</p>
            <p><b>Address:</b> ${L.address}</p>
            <p><b>Type:</b> ${L.type}</p>
            <p><b>Expiration Date:</b> ${L.expiry}</p>

            <hr class="my-4">
            <p><b>Restrictions:</b> ${L.restrictions}</p>
            <p><b>Conditions:</b> ${L.conditions}</p>
        `;
}

function loadFullVehicleDetails() {
    const V = dashboardData.vehicles;
    const box = document.getElementById("vehicleFull");

    let list = V.map(
        (v) => `
        <div class="border p-4 rounded-lg bg-gray-50">
            <p><b>Plate Number:</b> ${v.plate}</p>
            <p><b>MV File Number:</b> ${v.mvFileNumber}</p>
            <p><b>VIN:</b> ${v.vin}</p>
            <p><b>Brand:</b> ${v.brand}</p>
            <p><b>Model:</b> ${v.model}</p>
            <p><b>Year:</b> ${v.year}</p>
            <p><b>Color:</b> ${v.color}</p>
            <p><b>Registration Status:</b> ${v.status}</p>
            <p><b>Registration Expiry:</b> ${v.expiry}</p>
        </div>
    `
    ).join("");

    box.innerHTML = `
        <h2 class="text-3xl font-bold mb-4">Registered Vehicles</h2>
        <div class="space-y-4">${list}</div>
    `;
}


function loadFullViolationList() {
    const V = dashboardData.violations;
    const box = document.getElementById("violationFull");

    // Map each violation into a separate card
    const list = V.map(
        (v) => `
        <div class="border rounded-lg p-4 bg-red-50 shadow hover:shadow-lg transition">
            <p><b>Offense:</b> ${v.offense}</p>
            <p><b>Date:</b> ${v.date}</p>
            <p><b>Place:</b> ${v.place}</p>
            <p><b>Status:</b> ${v.status}</p>
            <p><b>Note:</b> ${v.note || "-"}</p>
            <p><b>Fine:</b> ₱${v.fine}</p>
        </div>
    `
    ).join("");

    box.innerHTML = list;
}



document.addEventListener("DOMContentLoaded", async () => {

    const licenseID = document.body.getAttribute("data-license-id");
    if (!licenseID) return;

    dashboardData = await fetchDashboardData(licenseID);
    if (!dashboardData) return;

    const page = getCurrentPage();

    switch (page) {
        case "user_dashboard.php":
            if (document.getElementById("licenseBox")) loadLicenseBox();
            if (document.getElementById("vehicleBox")) loadVehicleBox();
            if (document.getElementById("violationBox")) loadViolationBox();
            break;

        case "user_license.php":
            loadFullLicenseDetails();
            break;

        case "user_vehicle.php":
            loadFullVehicleDetails();
            break;

        case "user_violations.php":
            loadFullViolationList();
            break;
    }
});

// ================= NOT FOUND =================
document.getElementById("settingsBtn").addEventListener("click", async () => {
  try {
    // Check if the settings page exists by fetching it
    const res = await fetch("user_settings.php", { method: "HEAD" });
    if (res.ok) {
      // Page exists, redirect
      window.location.href = "../not_found.php";
    } else {
      // Page not found, redirect to 404
      window.location.href = "../not_found.php";
    }
  } catch (err) {
    // On error (network issue, etc.), also redirect to 404
    window.location.href = "../not_found.php";
  }
});

// ================= TOGGLE =================
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");

    toggleBtn.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.toggle("-translate-x-full");
    });
});
