document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");

    console.log("Sidebar:", sidebar); // Debug
    console.log("Sidebar Toggle:", sidebarToggle); // Debug

    if (!sidebar || !sidebarToggle) {
        console.error("Sidebar or Toggle button not found.");
        return; // Exit if elements are missing
    }

    sidebarToggle.addEventListener("click", function () {
        console.log("Button clicked!"); // Debug
        sidebar.classList.toggle("sidebar-hidden");
        sidebar.classList.toggle("sidebar-shown");
    });
});
