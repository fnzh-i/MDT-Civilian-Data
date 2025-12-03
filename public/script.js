//================= API SCRIPT =================

const API_URL = "../src/Controller.php";
let currentLicense = null;

function login() {

    if (!acceptance.terms || !acceptance.privacy) {
        alert("You must accept the Terms & Conditions and Privacy Policy to continue.");
        // Optionally, open the modals automatically
        if (!acceptance.terms) openModal('termsModal');
        else if (!acceptance.privacy) openModal('privacyModal');
        return;
    }
    const email = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const formData = new FormData();
    formData.append("action", "USER-LOGIN");
    formData.append("email", email);
    formData.append("password", password);

    fetch("../_modules/Controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(response => {
        console.log("Response from PHP:", response);
        if (response.trim() === "SUCCESS") {
            window.location.href = "../_pages/officer_dashboard.php";
            console.log("Login successful");
        } else {
            const errorElement = document.getElementById("error");
            errorElement.innerText = response;
            errorElement.classList.remove("hidden");
            console.log("Login failed:", response);
        }
    })
    .catch(err => {
        console.error("Fetch error:", err);
        alert("Error connecting to server.");
    });

}

// ================= VEHICLE LOOKUP =================
function lookupVehicle() {
    const box = document.getElementById("infoBox");

    const formData = new FormData();
    formData.append("action", "SEARCH-PLATE-NUMBER");
    formData.append("plate-number", document.getElementById("plateInput").value);

    fetch("../_modules/Controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log("Response:", data);

        if (data.status === "error") {
            alert(data.message);
            return;
        }

        // Success
        const v = data.vehicle; 
        console.log("Found Vehicle:", v);

        
        box.innerHTML = `
            <div class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
                <h2 class="text-2xl font-bold mb-2">Vehicle Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><b>Status:</b> ${v.status}</p>
                    <p><b>Plate Number:</b> ${v.plate}</p>
                    <p><b>MV File Number:</b> ${v.mvFile}</p>
                    <p><b>Make:</b> ${v.brand}</p>
                    <p><b>Model:</b> ${v.model}</p>
                    <p><b>Year:</b> ${v.year}</p>
                    <p><b>Color:</b> ${v.color}</p>
                    <p><b>VIN:</b> ${v.vin}</p>
                    <p><b>Registration Expiry:</b> ${v.regExpiry}</p>
                </div>
                <h3 class="text-xl font-bold mt-4">Registered Owner</h3>
                <p><b>Name:</b> ${data.person.full_name}</p>
                <p><b>License Number:</b> ${data.license.license_number}</p>
                <p><b>Address:</b> ${data.person.address}</p>
                <h3 class="text-xl font-bold mt-4">Insurance Information</h3>
                <p><b>Insurance Company:</b> ${v.insuranceCompany}</p>
                <p><b>Policy No.:</b> ${v.policyNumber}</p>
                <p><b>Expiry Date:</b> ${v.insuranceExpiry}</p>
            </div>
        `;
        box.classList.remove("hidden");
    })
    .catch(err => console.error("Fetch Error:", err));
}

// ---------- LICENSE LOOKUP ----------
function lookupLicense() {
    // const lic = document.getElementById("licenseInput").value.trim();
    // const error = document.getElementById("error");
    const box = document.getElementById("infoBox");

    const formData = new FormData();
    formData.append("action", "SEARCH-LICENSE-NUMBER");
    formData.append("license-number", document.getElementById("licenseInput").value.trim());

    fetch("../_modules/Controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log("Response:", data);

        if (data.status === "error") {
            alert(data.message);
            return;
        }

        const L = data.license;
        console.log("Found License:", L);

        currentLicense = L;
        currentLicense.violations = L.violations || [];

        // Fill License Info
        box.innerHTML = `
            <div class="bg-white p-6 rounded-2xl shadow-xl mb-6">
                <h2 class="text-2xl font-bold mb-3">License Status</h2>
                <p><b>Status:</b> ${L.status}</p>
                <p><b>License Number:</b> ${L.licenseNumber}</p>
                <p><b>License Type:</b> ${L.type}</p>
                <p><b>Issue Date:</b> ${L.issueDate}</p>
                <p><b>Expiry Date:</b> ${L.expiryDate}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl mb-6">
                <h2 class="text-2xl font-bold mb-3">Personal Information</h2>
                <p><b>Full Name:</b> ${L.first_name}</p>
                <p><b>Full Name:</b> ${L.middle_name}</p>
                <p><b>Full Name:</b> ${L.last_name}</p>
                <p><b>Date of Birth:</b> ${L.date_of_birth}</p>
                <p><b>Sex:</b> ${L.gender}</p>
                <p><b>Address:</b> ${L.address}</p>
                <p><b>Nationality:</b> ${L.nationality}</p>
                <p><b>Height:</b> ${L.height}</p>
                <p><b>Weight:</b> ${L.weight}</p>
                <p><b>Eye Color:</b> ${L.eye_color}</p>
                <p><b>Blood Type:</b> ${L.blood_type}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl mb-6">
                <h2 class="text-2xl font-bold mb-3">License Details</h2>
                <p><b>Restrictions:</b> ${L.dl_codes}</p>
                <p><b>Endorsements:</b> ${L.endorsements}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl mb-6 overflow-x-auto">
            <h2 class="text-2xl font-bold mb-4">Violation History</h2>
            <table class="w-full border-collapse">
                <thead class="bg-gray-200 sticky top-0">
                    <tr>
                        <th class="border px-3 py-2 text-left">Date</th>
                        <th class="border px-3 py-2 text-left">Offense</th>
                        <th class="border px-3 py-2 text-left">Place</th>
                        <th class="border px-3 py-2 text-left">Notes</th>
                        <th class="border px-3 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody id="violationTable"></tbody>
            </table>
            </div>

            <!-- Add Violation Modal Trigger Button -->
            <button id="showViolationFormBtn" 
                class="bg-green-500 hover:bg-red-700 transition text-white px-5 py-3 rounded-xl hover:from-green-600 hover:to-green-800 transition font-bold mb-4">
                Add New Ticket Violation
            </button>

            <!-- Modal -->
            <div id="violationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md relative">
                    <button onclick="toggleViolationModal()" class="absolute top-3 right-3 text-gray-600 font-bold text-xl">&times;</button>
                    <h2 class="text-2xl font-bold mb-4">Add New Ticket Violation</h2>
                    <div class="mb-3">
                        <label class="font-semibold">Date of Violation:</label>
                        <input id="v_date" type="date" class="p-2 border rounded w-full">
                    </div>
                    <div class="mb-3">
                        <label class="font-semibold">Offense Description:</label>
                        <input id="v_offense" type="text" class="p-2 border rounded w-full" list="violations-list">
                        <datalist id="violations-list">
                        <option value="ILLEGAL PARKING">
                        <option value="RECKLESS DRIVING">
                        <option value="DISOBEYING TRAFFIC SIGNS">
                        <option value="OVERSPEEDING">
                        <option value="DRIVING UNDER INFLUENCE">
                        <option value="OBSTRUCTION">
                        <option value="NO DRIVER LICENSE">
                        <option value="EXPIRED LICENSE">
                        <option value="UNREGISTERED VEHICLE">
                        <option value="NO OR/CR">
                        <option value="NUMBER CODING">
                        <option value="NO HELMET">
                        <option value="NO SEATBELT">
                    </datalist>
                    </div>
                    <div class="mb-3">
                        <label class="font-semibold">Place of Incident:</label>
                        <input id="v_place" type="text" class="p-2 border rounded w-full">
                    </div>
                    <div class="mb-3">
                        <label class="font-semibold">Note:</label>
                        <textarea id="v_note" class="p-2 border rounded w-full"></textarea>
                    </div>
                    <button onclick="addViolation(); toggleViolationModal();" 
                        class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-5 py-3 rounded-xl hover:from-blue-600 hover:to-blue-800 transition font-bold w-full">
                        Submit Violation
                    </button>
                </div>
            </div>
        `;
        box.classList.remove("hidden");

        loadViolations();

        const btn = document.getElementById("showViolationFormBtn");
        if (btn) {
            btn.addEventListener("click", toggleViolationModal);
        }
    })
    .catch(err => console.error("Fetch Error:", err));
}

function addViolation() {
    if (!currentLicense) return;

    const violationData = {
        "license_id": currentLicense.id, // yung current license
        "violation": document.getElementById("v_offense").value,
        "date-of-incident": document.getElementById("v_date").value,
        "place-of-incident": document.getElementById("v_place").value,
        "note": document.getElementById("v_note").value
    };

    // validate
    if (!violationData.violation || !violationData["date-of-incident"] || !violationData["place-of-incident"]) {
        alert("Please fill in all required fields.");
        return;
    }

    const formData = new FormData();
    formData.append("action", "CREATE-TICKET");
    for (const key in violationData) {
        formData.append(key, violationData[key]);
    }

    fetch("../_modules/Controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            // reload yung violations table
            loadViolations(); 
            
            // Clear yung mga input sa Add New TicketViolation
            document.getElementById("v_date").value = "";
            document.getElementById("v_offense").value = "";
            document.getElementById("v_place").value = "";
            document.getElementById("v_note").value = "";
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(err => console.error("Error adding violation:", err));
}

function loadViolations() {
    if (!currentLicense) return;

    const table = document.getElementById("violationTable");
    table.innerHTML = ""; // clear table

    const formData = new FormData();
    formData.append("action", "FETCH-TICKETS");
    formData.append("license_id", currentLicense.id);

    fetch("../_modules/Controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            currentLicense.violations = data.tickets.map(t => ({
                date: t.date_of_incident,
                offense: t.violation,
                location: t.place_of_incident,
                note: t.note,
                status: t.status
            }));

            currentLicense.violations.forEach(v => {
                table.innerHTML += `
                    <tr>
                        <td class="border px-3 py-1">${v.date}</td>
                        <td class="border px-3 py-1">${v.offense}</td>
                        <td class="border px-3 py-1">${v.location}</td>
                        <td class="border px-3 py-1">${v.note}</td>
                        <td class="border px-3 py-1 font-semibold ${v.status === "Paid" ? "text-green-600" : "text-red-600"}">${v.status}</td>
                    </tr>
                `;
            });
        } else {
            console.error("Error fetching tickets:", data.message);
        }
    })
    .catch(err => console.error("Fetch error:", err));
}

// ================= MODALSS =================

function toggleViolationModal() {
    const modal = document.getElementById("violationModal");
    if (!modal) return;
    modal.classList.toggle("hidden");
}

// Keep track of acceptance
const acceptance = {
    terms: localStorage.getItem('mdt_accept_terms') === 'true',
    privacy: localStorage.getItem('mdt_accept_privacy') === 'true'
};

// Initialize checkbox states if already accepted
document.addEventListener('DOMContentLoaded', () => {
    if (acceptance.terms) {
        const tcb = document.getElementById('acceptTerms');
        if (tcb) tcb.checked = true;
        const tbtn = document.getElementById('termsAcceptBtn');
        if (tbtn) tbtn.disabled = false;
    }
    if (acceptance.privacy) {
        const pcb = document.getElementById('acceptPrivacy');
        if (pcb) pcb.checked = true;
        const pbtn = document.getElementById('privacyAcceptBtn');
        if (pbtn) pbtn.disabled = false;
    }
});

function handleCheckboxChange(which) { // eto mag hhandle sa checkbox kung naka
    if (which === 'terms') {
        const checked = document.getElementById('acceptTerms').checked;
        document.getElementById('termsAcceptBtn').disabled = !checked;
    } else if (which === 'privacy') {
        const checked = document.getElementById('acceptPrivacy').checked;
        document.getElementById('privacyAcceptBtn').disabled = !checked;
    }
}

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('flex');
    document.getElementById(id).classList.add('hidden');
}

function toggleAcceptButton(which) {
    if (which === 'terms') {
        const checked = document.getElementById('acceptTerms').checked;
        document.getElementById('termsAcceptBtn').disabled = !checked;
    } else if (which === 'privacy') {
        const checked = document.getElementById('acceptPrivacy').checked;
        document.getElementById('privacyAcceptBtn').disabled = !checked;
    }
}

function accept(which) {
    if (which === 'terms') {
        const checked = document.getElementById('acceptTerms').checked;
        if (!checked) return;
        localStorage.setItem('mdt_accept_terms', 'false');
        acceptance.terms = false;
        closeModal('termsModal');
    } else if (which === 'privacy') {
        const checked = document.getElementById('acceptPrivacy').checked;
        if (!checked) return;
        localStorage.setItem('mdt_accept_privacy', 'true');
        acceptance.privacy = true;
        closeModal('privacyModal');
    }
    updateLoginButton();
}

function updateLoginButton() {
    const loginBtn = document.getElementById('loginBtn');
    if (!loginBtn) return;
    loginBtn.disabled = !(acceptance.terms && acceptance.privacy);
}

// ================= TOGGLE =================
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");

    toggleBtn.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.toggle("-translate-x-full");
    });
});

// ================= LOAD LICENSE PANEL =================
function loadLicenseBox() {
    const L = sampleDashboardData.user;
    const box = document.getElementById("licenseBox");

    box.innerHTML = `
        <div class="flex items-center gap-4 mb-4">
            <img src="../../public/assets/id.png" class="w-14 h-14 opacity-90">
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
    const V = sampleDashboardData.vehicles;
    const box = document.getElementById("vehicleBox");

    let vehiclesHTML = V.map(v => `
        <li class="border-b pb-2">
            <p class="font-bold">${v.name}</p>
            <p class="text-sm text-gray-600">Plate: ${v.plate}</p>
        </li>
    `).join("");

    box.innerHTML = `
        <div class="flex items-center gap-4 mb-4">
            <img src="../../public/assets/car.png" class="w-14 h-14 opacity-90">
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
    const V = sampleDashboardData.violations;
    const box = document.getElementById("violationBox");

    let violationsHTML = V.map(v => `
        <li class="border-b pb-2">
            <p class="font-bold text-red-600">${v.offense}</p>
            <p class="text-sm text-gray-600">Issued: ${v.date} - ₱${v.fine} Fine</p>
        </li>
    `).join("");

    box.innerHTML = `
        <div class="flex items-center gap-4 mb-4">
            <img src="../../public/assets/ticket.png" class="w-14 h-14 opacity-90">
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
document.addEventListener("DOMContentLoaded", () => {
    loadLicenseBox();
    loadVehicleBox();
    loadViolationBox();
});
