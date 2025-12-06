// RUN EDIT/CREATE LOGIC
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

// ================= TOGGLE =================
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");

    toggleBtn.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.toggle("-translate-x-full");
    });
});
