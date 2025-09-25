# Ticket Selling Assessment

## Introduction

This is a technical assessment project for managing event ticket sales. It allows users to view events, purchase tickets, and generate sales reports.

## Setup Instructions

1. **Clone the repository and enter the project folder:**
   ```
   git clone https://github.com/negagl/ticket-selling-assesment
   cd ticket-selling-assesment
   ```

2. **Initialize the database:**  
   Run the following command to set up the database schema and sample data.  
   *(Change the root credentials in `config/init_db.php` if needed.)*
   ```
   php config/init_db.php
   ```

3. **Start the project:**  
   Launch the PHP built-in server:
   ```
   php -S localhost:80 -t public
   ```

4. **Test the application:**  
   - Browse different events.
   - To purchase tickets, use one of the test users:  
     `test1@user.com`, `test2@user.com`, or `test3@user.com`.  
     *(Any other email will result in an error as the user is not registered.)*

5. **View ticket sales reports:**  
   Go to `/report.php` to see the report of tickets sold per event and ticket type.

---

That's all!

