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
