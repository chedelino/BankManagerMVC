# Banking Operations Management System

This repository hosts a web-based banking management system designed to optimize daily banking operations for various employee roles within a financial institution. Developed using JavaScript, HTML, CSS, and PHP, the system follows the Model-View-Controller (MVC) architecture to ensure modularity, maintainability, and scalability.

The application provides dedicated interfaces for Bank Agents, Client Advisors, and Branch Managers, each tailored to streamline customer account management, appointment scheduling, financial transactions, and contract handling.

## 🌟 Key Features
  ### 🏦 Agent Portal
      👤 Customer Information Handling – Update customer details like address, phone number, and marital status.
      💰 Transaction Processing – Perform deposits and withdrawals while enforcing overdraft limitations.
      📄 Comprehensive Customer Overview – Access a summary of client identities, account balances, active contracts, and assigned advisors.
      📅 Appointment Coordination – Schedule meetings between customers and advisors with precise time slot allocation.
  ### 👨‍💼 Client Advisor Dashboard
      📆 Appointment Management – View, organize, and modify personal schedules for customer consultations.
      🏦 New Customer Registration – Open new accounts, including PEL, CEL, and Joint Accounts, and offer financial contracts like insurance and credit.
      ⚖️ Financial Product Oversight – Adjust overdraft limits, manage account closures, and oversee contract terminations.
  ### 🏢 Branch Manager Administration
    🔑 Employee Access Control – Create, update, or revoke employee login credentials and permissions.
    📜 Banking Product Configuration – Define, update, and manage available account types and contract offerings.
    📝 Regulatory Document Management – Maintain an updated list of required documents for each banking product.
    📊 Bank Performance Analytics – Track vital metrics such as contract signings, scheduled appointments, total customers, and overall bank balance trends.

## 📂 Project Structure

/banking-management-system

│── 📜 a-propos.html         # About page

│── 👨‍💻 agent.php             # Employee management  
│── 🌍 banque-en-ligne.html  # Online banking page  
│── 💳 comptes.html          # Account management  
│── 🔌 connect.php           # Database connection  
│── 👨‍⚖️ conseiller.php        # Client Advisor dashboard  
│── 📧 contact.html          # Contact page  
│── 🏗️ Create_table.sql      # SQL script to create database tables  
│── 🏦 directeur.php         # Bank Director dashboard  
│── 🖼️ images/               # Folder containing images for the application  
│── 🏗️ Insert_table.sql      # SQL script to insert initial data into the database  
│── 🏠 site.php              # Main entry point of the website  
│── 🎨 style.css             # Main CSS file for styling  
│── 🎨 style1.css            # Additional styling file  
│── 💲 tarifs.html           # Pricing page listing various service fees  
│── 🏗️ banque.sql            # Full database schema including tables and relationships  


## ⚙️ Technology Stack
  🎨 Frontend: HTML, CSS, JavaScript
  ⚙️ Backend: PHP
  🏗️ Architecture: MVC (Model-View-Controller)
  🗄️ Database: MySQL (or any relational database for structured data storage)


## 🔑 How It Works
  🔐 Secure Authentication – Employees log in with unique credentials, and access is restricted based on their role (Agent, Advisor, or Manager).
  🚀 Role-Based Functionality – Each role has access to distinct features tailored to their responsibilities.
  📡 Dynamic Data Handling – The system dynamically updates appointments, document requirements, and financial product offerings in real-time.

## 🎯 Why This Project?
This banking system demonstrates the real-world application of web technologies in financial management. It offers structured code organization, a user-friendly interface, and secure role-based access, making it an efficient tool for streamlining banking operations.

## 📜 License
This project is licensed under the MIT License.

