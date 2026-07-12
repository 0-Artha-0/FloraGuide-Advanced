# FloraGuide 🌱

FloraGuide is a web application built to provide clear, accessible **plant care guides**. 
Its main purpose is to help plant enthusiats understand how to nurture each plant.
Alongside these guides, FloraGuide offers tools to set care reminders and organize 
personal plant collections, making plant care both informative and practical.

## Setup
1. Clone this folder ('project/') into your local server directory (`htdocs` for XAMPP).
2. Import the provided database schema ('floraguide.sql') into MySQL. 
3. If you recieve a 'database does not exist' error or similar after running the sql file, 
    remove 'DROP DATABASE FloraGuide;' from the top of the script.
4. Start Apache and MySQL, then open this link ('http://localhost/project/login.php') in your browser.

## Project Structure
- `/FloraGuide-Main/mainPages/` – core pages (directory, individual_plant, collections, reminders, about)
- `/FloraGuide-Main/styles/` – CSS files
- `/FloraGuide-Main/Images/` – logos and assets
- `/FloraGuide-Main/index.php` – logos and assets
- `connecting.php` – database connection
- `login.php` and other supporting files (login_check, registration, register_user.php) – for intial registery into the system

## Authors
This project was in fullfilment of Development of web applications course requirements, by:
- Huda Bakather – U21101466  
- Maitha Adel – U22100299  
- Aaliya Asif – U22100756  
- Shaffa Zeenath Abdul Nazeer – U22101031  
- Roudha Abdulla – U22101256

Instructor: Isam Al Jawarneh
Section: 31
University of Sharjah



