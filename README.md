# pawunion-platform
PawUnion is a region-based web platform for reporting, searching, and recovering lost and found pets. Features include secure user accounts, structured listings, emotional support tools, admin moderation, and accessible, mobile-friendly design.

# Instructions to Set Up the Paw Union Web-Based Platform

## 1) Download and Install XAMPP
- Go to [XAMPP](https://www.apachefriends.org) and download the latest version of XAMPP for your operating system.
- Run the installer and follow the setup wizard.
- Once installed, open the XAMPP Control Panel and **start Apache and MySQL**.

## 2) Set Up the Database
- Open your browser and go to [localhost/phpmyadmin](http://localhost/phpmyadmin/).
- Click on **Import**, choose the file named `pawunion_db.sql` (located within the `pawunion-app` folder), and press **Go** to import the database.

## 3) Deploy the Application
- Place the `pawunion-app` folder into the `htdocs` directory (usually located at `C:\xampp\htdocs`).
- The full path should be: `C:\xampp\htdocs\pawunion-app`

## 4) Access the Platform
- Open your browser and go to:  
  [http://localhost/pawunion-app/index.php](http://localhost/pawunion-app/index.php)  
  This is the **public landing page** of the platform.

## 5) Using the Platform as a Regular User
- Click the **Login** button on the navbar to sign in.
- If you don’t have an account, click **Register here** to create one.
- Once logged in, you can:
  - ✅ Report lost pets
  - ✅ View lost/found pets
  - ✅ Access resources for pet recovery
  - ✅ Manage your own listings

## 6) Using the Platform as Admin
- To log in as an administrator, use the following credentials:  
  - **Email:** admin@pawunion.com  
  - **Password:** !Pawunion1993
- The Admin Panel allows you to:
  - ✅ View and delete pet posts
  - ✅ Manage user accounts
  - ✅ Monitor platform content

## 7) Logging Out
- Press the **Logout** button located in the navbar to safely end your session.

⚠️ **Tip:** If you encounter unexpected behavior, try accessing the platform in **Incognito mode** via:  
[http://localhost/pawunion-app/index.php](http://localhost/pawunion-app/index.php)
