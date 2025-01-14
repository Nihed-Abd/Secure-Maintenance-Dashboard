# Secure Maintenance Dashboard

## Description
Secure Maintenance Dashboard is a web application built with native PHP and an SQL database using phpMyAdmin. The application features a secure login and sign-up system with password reset functionality via access tokens and email verification. The dashboard enables admins to add posts with various maintenance schedules (daily, weekly, monthly, or yearly) and automatically sends email notifications to users at 8:00 AM for maintenance tasks due that day. Users can also view a comprehensive history of all maintenance activities.

## Features
- **User Authentication**: Secure login and sign-up with email verification and password reset using access tokens.
- **Dashboard**: Admins can add posts with maintenance schedules.
- **Maintenance Types**: Posts can be categorized into daily, weekly, monthly, or yearly maintenance.
- **Email Notifications**: Automatic email notifications sent to users at 8:00 AM for tasks due that day.
- **Maintenance History**: Users can view a history of all maintenance activities.

### Installation
1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/secure-maintenance-dashboard.git


2. **Navigate to the project directory**

cd secure-maintenance-dashboard

3. **Set up the SQL Database**

- Create a new database using phpMyAdmin.
- Import the segemcom.sql file located in the project directory to set up the necessary tables.

4. **Configure Database Connection**

Update the config.php file with your database credentials.


Set up Email Sending

5. **Set up Email Sending**

       ++ Update Email API Key 
       ++ Update Sender Email
       
--Files To update :
        forgot password.php
       send_notification_now.php 



#### Usage

Sign Up: Create a new account by signing up.
Login: Log in using your email and password.
Add Post: Admins can add new posts with the desired maintenance schedule.
View Maintenance History: Users can view the history of all maintenance activities.


       
##### Contributing

We welcome contributions! Please fork the repository and submit a pull request for review.


###### Contact
For any questions or inquiries, please contact nihedabdworks@gmail.com.


Feel free to customize the details such as repository URL, email addresses, and any specific configurations unique to your setup.


