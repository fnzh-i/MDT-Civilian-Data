Project log maintained by fnzh-i <br>
Development ongoing — updates posted as time allows.

## Timeline: 
> 🚧 **This is an ongoing project!** Progress dates may skip certain days since work continues only when time allows.

- Nov 8, 2025   - Initial commit: create repository structure, add README, and basic configuration files to start development.<br>
- Nov 11, 2025  - Created core entity classes: Person and DriverLicense. Added .gitignore.<br>
                - Moved PHP files to src directory and update .gitignore. Removed DBConnect.php
- Nov 12, 2025  - Updated and refactored licenses, vehicles, and tickets modules to align with the new merged table structure, 
                resolving schema conflicts and ensuring smooth data migration.<br>
                - Removed commented-out SQL and sample code.<br>
                - Added REVOKED status to DriversLicenseStatus enum.<br>
- Nov 14, 2025  - Implemented multiple UI pages (Admin, Create Vehicle, Search Vehicle, Search License, Add Ticket) and introduced a new User class. 
                - Added Controller.php to act as the central bridge between the frontend, backend, and database. All frontend form requests are routed through a switch statement inside Controller.php, which delegates each request to the appropriate class methods using static database functions.<br>
                - Created Error.php to handle and display all system and input errors.<br>
                - Refactored and modularize code, added a seperate folder for admin panel.<br>
                - Refactored admin panel file structure.<br>
- Nov 16, 2025  - Converted DB row to DriversLicense object and Converted the object to an array for JSON output in api.php.<br>
                - Implemented dedicated API endpoints for managing licenses, tickets, users, and vehicles, allowing the frontend to retrieve, create, update, and search data through standardized JSON responses. This separation of endpoints improves modularity, simplifies integration, and ensures each resource can be accessed independently by the UI.<br>
                - Integrated Tailwind CSS into the frontend along with all required assets such as the configuration file, compiled output, and CDN/build setup.<br>
                - Removed legacy index.php and deprecated modules and Moved admin panel files to a new _admin_panel directory and added new pages for dashboard, landing, license, and vehicle.<br>
                - Updated .gitignore, and documented changes in TIMELINE.md.<br>
                - Moved API files to src/api and update bootstrap path.<br>

- Nov 16, 2025  - Implemented backend login and API integration (Replaced the frontend dummy login logic with an API-based login using fetch in script.js)
- Nov 21, 2025  - Implemented vehicle plate lookup via AJAX and API refactor. <br>
                - Added a lookupVehicle() function in script.js to perform AJAX-based vehicle plate searches. <br>
                - Refactored Controller.php to return JSON responses for plate lookups and updated vehicleAPI.php to encapsulate vehicle-related API logic in a VehicleAPI class.<br>
                - Adjusted vehicle.php and bootstrap.php for correct asset paths and improved autoloading.<br>
                - Implemented AJAX license and vehicle lookup with API refactor. Refactored vehicle and license lookup to use AJAX requests and return JSON responses. Added LicenseAPI and updated.<br>
                - Added LicenseAPI and updated VehicleAPI to provide structured JSON output for lookups and listings. <br>
                - Updated Controller.php to route 'SEARCH-PLATE-NUMBER' and 'SEARCH-LICENSE-NUMBER' actions to the new API classes. <br>
                - Updated frontend scripts and page links for improved navigation and error handling.<br>
                - Added admin user management functionality in password-hash branch.
- Nov 22, 2025  - Added 'Create User' button to admin menu.<br>
                - Fixed variable assignment in AdminMenu update logic.