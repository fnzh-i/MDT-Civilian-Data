
    const licenseNumber = "<?= $licenseNumber ?>";

    if (licenseNumber) {
    fetch("../../_modules/Controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=SEARCH-LICENSE-NUMBER&license-number=" + encodeURIComponent(licenseNumber)
    })
        .then(res => res.json())
        .then(data => {
        if (data.status === "success") {
            const lic = data.license;

            document.getElementById("license-number").value = lic.licenseNumber;
            document.getElementById("issue-date").value = lic.issueDate?.split("T")[0] ?? "";
            document.getElementById("first-name").value = lic.first_name;
            document.getElementById("middle-name").value = lic.middle_name ?? "";
            document.getElementById("last-name").value = lic.last_name;
            document.getElementById("date-of-birth").value = lic.date_of_birth?.split("T")[0] ?? "";
            document.getElementById("address").value = lic.address;
            document.getElementById("nationality").value = lic.nationality;
            document.getElementById("Height").value = lic.height;
            document.getElementById("weight").value = lic.weight;
            document.getElementById("eye-color").value = lic.eye_color;
            document.getElementById("blood-type").value = lic.blood_type;

            // STATUS
            document.querySelectorAll("input[name='license-status']").forEach(r => {
            if (r.value === lic.status) r.checked = true;
            });

            // TYPE
            document.querySelectorAll("input[name='license-type']").forEach(r => {
            if (r.value === lic.type) r.checked = true;
            });

            // EXPIRY
            if (lic.issueDate && lic.expiryDate) {
            const diffYears = new Date(lic.expiryDate).getFullYear() - new Date(lic.issueDate).getFullYear();
            document.querySelectorAll("input[name='expiry-option']").forEach(r => {
                if (r.value == diffYears) r.checked = true;
            });
            }

            // DL CODES
            const codes = lic.dl_codes.split(",");
            document.querySelectorAll("input[name='dl-codes[]']").forEach(cb => {
            if (codes.includes(cb.value)) cb.checked = true;
            });

            // SEX
            document.querySelectorAll("input[name='sex']").forEach(r => {
            if (r.value === lic.gender) r.checked = true;
            });

            // MODIFY BUTTON
            document.querySelector("input[name='action']").value = "UPDATE-LICENSE";
            document.querySelector("button[type='submit']").innerText = "Update License";
        }
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