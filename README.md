# E-Scooter Rental App

E-Scooter Rental App is a web application developed as a personal project to demonstrate database handling, form management, and interactive interfaces using PHP, MySQL, and JavaScript.

The project simulates a complete electric scooter rental system for learning and portfolio purposes.

## Features
- User interface with login and dashboard
- Scooter selection based on location
- Rental form with user details
- Ride summary with price calculation
- Problem reporting for scooters
- Employee interface for internal management
- Invoice generation for serviced scooters

## Technologies Used
- PHP
- MySQL
- JavaScript
- HTML & CSS
- XAMPP (Apache & MySQL)

## Project Structure
```
E-Scooter-Rental-App/
├── konekcija.php         # PHP file for database connection
├── index.php             # Login page
├── pocetna.php           # User dashboard / home page
├── trotineti.php         # Page to select a scooter by location
├── iznajmljivanje.php    # Form for entering user rental details
├── zavrsi_voznju.php     # PHP file for calculating ride cost and ending time
├── voznja.php            # Ride summary: price, history table, problem reporting
├── prijavi_problem.php   # PHP file to submit scooter problem reports
├── interni.php           # Employee interface for internal management
└── faktura.php           # Page for generating and displaying invoices
```
## How to Run Locally

1. **Install XAMPP** and start **Apache** and **MySQL**.  
2. **Copy project folder** to `htdocs`   
3. **Import the database**:  
   - Open phpMyAdmin, create a database
   - Import `database/e_scooter.sql`.    
4. **Open in browser**: `http://localhost/E-Scooter-rental-app/php/index.php`
