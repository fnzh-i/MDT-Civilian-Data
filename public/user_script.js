// ================= LOAD LICENSE PANEL =================
// function loadLicenseBox() {
//     const L = sampleDashboardData.user;
//     const box = document.getElementById("licenseBox");

//     box.innerHTML = `
//         <div class="flex items-center gap-4 mb-4">
//             <img src="../../public/assets/id.png" class="w-14 h-14 opacity-90">
//             <h2 class="text-2xl font-bold text-gray-800">Driver's License</h2>
//         </div>

//         <p><b>Name:</b> ${L.name}</p>
//         <p><b>License #:</b> ${L.licenseNumber}</p>
//         <p><b>Status:</b> ${L.licenseStatus}</p>
//         <p><b>Expiration:</b> ${L.expiry}</p>

//         <button onclick="window.location.href='user_license.php'"
//             class="mt-6 w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
//             View Full License Details
//         </button>
//     `;
// }


// ================= LOAD VEHICLE PANEL =================
// function loadVehicleBox() {
//     const V = sampleDashboardData.vehicles;
//     const box = document.getElementById("vehicleBox");

//     let vehiclesHTML = V.map(v => `
//         <li class="border-b pb-2">
//             <p class="font-bold">${v.name}</p>
//             <p class="text-sm text-gray-600">Plate: ${v.plate}</p>
//         </li>
//     `).join("");

//     box.innerHTML = `
//         <div class="flex items-center gap-4 mb-4">
//             <img src="../../public/assets/car.png" class="w-14 h-14 opacity-90">
//             <h2 class="text-2xl font-bold text-gray-800">Registered Vehicles</h2>
//         </div>

//         <ul class="space-y-3">
//             ${vehiclesHTML}
//         </ul>

//         <button onclick="window.location.href='user_vehicle.php'"
//             class="mt-6 w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
//             View All Vehicles
//         </button>
//     `;
// }


// ================= LOAD VIOLATION PANEL =================
// function loadViolationBox() {
//     const V = sampleDashboardData.violations;
//     const box = document.getElementById("violationBox");

//     let violationsHTML = V.map(v => `
//         <li class="border-b pb-2">
//             <p class="font-bold text-red-600">${v.offense}</p>
//             <p class="text-sm text-gray-600">Issued: ${v.date} - ₱${v.fine} Fine</p>
//         </li>
//     `).join("");

//     box.innerHTML = `
//         <div class="flex items-center gap-4 mb-4">
//             <img src="../../public/assets/ticket.png" class="w-14 h-14 opacity-90">
//             <h2 class="text-2xl font-bold text-gray-800">Ticket Violations</h2>
//         </div>

//         <ul class="space-y-3">
//             ${violationsHTML}
//         </ul>

//         <button onclick="window.location.href='user_violations.php'"
//             class="mt-6 w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
//             View Violations
//         </button>
//     `;
// }


// ================= INIT DASHBOARD =================
// document.addEventListener("DOMContentLoaded", () => {
//     loadLicenseBox();
//     loadVehicleBox();
//     loadViolationBox();
// });