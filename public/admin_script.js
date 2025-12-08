// ================= LICENSE SCRIPT =================
if (window.pageMode === "edit-create" && window.pageLicenseNumber) {
    const licenseNumber = window.pageLicenseNumber;

    fetch("../../_modules/Controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body:
        "action=SEARCH-LICENSE-NUMBER&license-number=" +
        encodeURIComponent(licenseNumber),
    })
        .then((res) => res.json())
        .then((data) => {
        if (data.status === "success") {
            const lic = data.license;

            // Fill inputs
            document.getElementById("license-number").value =
            lic.licenseNumber;
            document.getElementById("issue-date").value = lic.issueDate
            ? new Date(lic.issueDate).toISOString().split("T")[0]
            : "";
            document.getElementById("first-name").value = lic.first_name;
            document.getElementById("middle-name").value =
            lic.middle_name ?? "";
            document.getElementById("last-name").value = lic.last_name;
            document.getElementById("date-of-birth").value =
            lic.date_of_birth
                ? new Date(lic.date_of_birth).toISOString().split("T")[0]
                : "";
            document.getElementById("address").value = lic.address;
            document.getElementById("nationality").value = lic.nationality;
            document.getElementById("Height").value = lic.height;
            document.getElementById("weight").value = lic.weight;
            document.getElementById("eye-color").value = lic.eye_color;
            document.getElementById("blood-type").value = lic.blood_type;

            // Radio buttons
            document
            .querySelectorAll('input[name="license-status"]')
            .forEach((r) => {
                if (r.value === lic.status) r.checked = true;
            });
            document
            .querySelectorAll('input[name="license-type"]')
            .forEach((r) => {
                if (r.value === lic.type) r.checked = true;
            });
            document.querySelectorAll('input[name="sex"]').forEach((r) => {
            if (r.value === lic.gender) r.checked = true;
            });

            // Expiry
            if (lic.expiryDate && lic.issueDate) {
            const diff =
                new Date(lic.expiryDate).getFullYear() -
                new Date(lic.issueDate).getFullYear();
            document
                .querySelector(
                `input[name="expiry-option"][value="${diff}"]`
                )
                ?.setAttribute("checked", true);
            }

            // DL Codes
            const dl = lic.dl_codes.split(",").map((c) => c.trim());
            document
            .querySelectorAll('input[name="dl-codes[]"]')
            .forEach((cb) => {
                if (dl.includes(cb.value)) cb.checked = true;
            });

            // Change to UPDATE mode
            document.querySelector('input[name="action"]').value =
            "UPDATE-LICENSE";
            document.querySelector('button[type="submit"]').textContent =
            "Update";
        }
        });
    }


// RUN SEARCH RESULT LOGIC
if (window.pageMode === "search-result" && window.pageLicenseNumber) {
    fetch("../../_modules/Controller.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "action=SEARCH-LICENSE-NUMBER&license-number=" + encodeURIComponent(window.pageLicenseNumber),
    })
    .then((res) => res.json())
    .then((data) => {
        if (data.status === "error") {
        document.getElementById("result").innerHTML = `<p>${data.message}</p>`;
        return;
        }

        const lic = data.license;

        let table = `
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
            <tbody class="divide-y divide-gray-300">
                ${Object.entries({
                "License Number": lic.licenseNumber,
                Status: lic.status,
                Type: lic.type,
                "Issue Date": lic.issueDate,
                "Expiry Date": lic.expiryDate,
                "DL Codes": lic.dl_codes,
                Name:
                    lic.first_name +
                    " " +
                    (lic.middle_name ?? "") +
                    " " +
                    lic.last_name,
                Birthday: lic.date_of_birth,
                Gender: lic.gender,
                Address: lic.address,
                Nationality: lic.nationality,
                Height: lic.height,
                Weight: lic.weight,
                "Eye Color": lic.eye_color,
                "Blood Type": lic.blood_type,
                })
                .map(
                    ([key, value]) => `
                <tr>
                    <th class="p-4 font-semibold bg-gray-100 w-1/3">${key}</th>
                    <td class="p-4">${value}</td>
                </tr>
                `
                )
                .join("")}
            </tbody>
        </table>

        <div class="flex gap-4 mt-8">
            <a href="AdminCreateLicense.php?license-number=${lic.licenseNumber}"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
            UPDATE
            </a>

            <button id="deleteBtn"
            class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 transition">
            DELETE
            </button>
        </div>
        `;

        document.getElementById("result").innerHTML = table;

        document.getElementById("deleteBtn").addEventListener("click", () => {
        if (!confirm("Are you sure you want to delete this license?")) return;

        fetch("../../_modules/Controller.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "action=DELETE-LICENSE&license-number=" + encodeURIComponent(lic.licenseNumber),
            })
            .then((res) => res.json())
            .then((data) => {
                if (data.status === "success") {
                alert(data.message);
                window.location.href = "AdminSearchLicense.php";
                } else {
                alert("Error: " + data.message);
                }
            });
        });
        });
}
// ================= VEHICLE SCRIPT =================

if (window.pageMode === "vehicle-edit-create" && window.pagePlateNumber) {
    const plateNumber = window.pagePlateNumber;

    fetch("../../_modules/Controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=SEARCH-PLATE-NUMBER&plate-number=" + encodeURIComponent(plateNumber),
    })
        .then((res) => res.json())
        .then((data) => {
        if (data.status === "success") {
            const veh = data.vehicle;

            // YUNG MGA STRING TYPES
            document.getElementById("license-number").value =
            data.license.license_number ?? "";
            document.getElementById("plate-number").value =
            veh.plate ?? "";
            document.getElementById("mv-file-number").value =
            veh.mvFile ?? "";
            document.getElementById("vin").value = veh.vin ?? "";
            document.getElementById("issue-date").value =
            veh.issueDate ?? "";
            document.getElementById("brand-name").value = veh.brand ?? "";
            document.getElementById("model-name").value = veh.model ?? "";
            document.getElementById("model-year").value = veh.year ?? "";
            document.getElementById("model-color").value =
            veh.color ?? "";
            document.getElementById("vehicle-id").value = veh.id; // NEED TO BASTA HAHHAHA NEED TO SA UPDATE
            
            // REGISTRATION STATUS
            const statusRadios = document.getElementsByName(
            "registration-status"
            );
            statusRadios.forEach((radio) => {
            if (radio.value === veh.status) radio.checked = true;
            });

            // UPDATE MODE
            document.querySelector('input[name="action"]').value =
            "UPDATE-VEHICLE";
            document.querySelector('button[type="submit"]').textContent = 
            "Update";
            
        }
        })
        .catch((err) => console.error("Fetch error:", err));
}

if (window.pageMode === "vehicle-search-result" && window.pagePlateNumber) {
    const plateNumber = window.pagePlateNumber;

    fetch("../../_modules/Controller.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body:
        "action=SEARCH-PLATE-NUMBER&plate-number=" +
        encodeURIComponent(plateNumber),
    })
    .then((res) => res.json())
    .then((data) => {
        if (data.status === "error") {
        document.getElementById(
            "result"
        ).innerHTML = `<p class="text-red-600 font-semibold">${data.message}</p>`;
        return;
        }

        const veh = data.vehicle;
        const lic = data.license;
        const person = data.person;

        let table = `
    <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
    <tbody class="divide-y divide-gray-300">

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">Plate Number</th>
        <td class="p-4">${veh.plate}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">MV File Number</th>
        <td class="p-4">${veh.mvFile ?? ""}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">VIN</th>
        <td class="p-4">${veh.vin}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">Brand</th>
        <td class="p-4">${veh.brand}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">Model</th>
        <td class="p-4">${veh.model}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">Color</th>
        <td class="p-4">${veh.color}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">Year</th>
        <td class="p-4">${veh.year}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">Registration Expiry</th>
        <td class="p-4">${veh.regExpiry}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">Status</th>
        <td class="p-4">${veh.status}</td>
        </tr>

        <tr>
        <th class="p-4 font-semibold bg-gray-100 w-1/3">License Number</th>
        <td class="p-4">${lic.license_number ?? ""}</td>
        </tr>

    </tbody>
    </table>

    <div class="flex gap-4 mt-8">
    <a href="AdminCreateVehicle.php?vehicle-id=${veh.id}&plate-number=${
        veh.plate
        }"
        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
        UPDATE
    </a>

    <button id="deleteBtn"
        class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 transition">
        DELETE
    </button>
    </div>
`;

        document.getElementById("vehicle-result").innerHTML = table;

        document.getElementById("deleteBtn").addEventListener("click", () => {
        if (!confirm("Are you sure you want to delete this vehicle?")) return;

        fetch("../../_modules/Controller.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body:
            "action=DELETE-VEHICLE&plate-number=" +
            encodeURIComponent(veh.plate),
        })
            .then((res) => res.json())
            .then((data) => {
            if (data.status === "success") {
                alert(data.message);
                window.location.href = "AdminSearchVehicle.php";
            } else {
                alert("Error: " + data.message);
            }
            })
            .catch((err) => alert("Fetch error: " + err));
        });
    });

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

// ================= NOT FOUND =================
document.getElementById("settingsBtn").addEventListener("click", async () => {
  try {
    // Check if the settings page exists by fetching it
    const res = await fetch("admin_settings.php", { method: "HEAD" });
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