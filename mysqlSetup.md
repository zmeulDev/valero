# How to Create a MySQL Database, User, and Grant Roles for `citybrk.ro`

## Step 1: Log in to MySQL
Access the MySQL shell with the root user:
```bash
sudo mysql -u user -p
```
Enter the root password when prompted.

---

## Step 2: Create a New Database
Create a database for the `citybrk.ro` website:
```sql
CREATE DATABASE citybrk_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

---

## Step 3: Create a New User
Create a user for the database with a strong password:
```sql
CREATE USER 'citybrk_user'@'localhost' IDENTIFIED BY 'strong_password';
```
Replace `strong_password` with a secure password.

---

## Step 4: Grant Permissions to the User
Grant the user full access to the `citybrk_db` database:
```sql
GRANT ALL PRIVILEGES ON citybrk_db.* TO 'citybrk_user'@'localhost';
```

Apply the changes to the privileges:
```sql
FLUSH PRIVILEGES;
```

---

## Step 5: Test the Connection
Exit the MySQL shell:
```sql
EXIT;
```

Log in using the new user to verify the setup:
```bash
mysql -u citybrk_user -p
```
Enter the password for the new user when prompted.

Switch to the `citybrk_db` database to ensure access:
```sql
USE citybrk_db;
SHOW TABLES;
```
If no errors occur, the user and database are correctly set up.

---

## Step 6: Configure the Application to Use the Database
Update the application's `.env` file with the following details:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citybrk_db
DB_USERNAME=citybrk_user
DB_PASSWORD=strong_password
```

---

## Summary
1. Created a database: `citybrk_db`
2. Created a user: `citybrk_user` with a secure password
3. Granted full permissions for `citybrk_db` to `citybrk_user`
4. Verified the setup and updated the application configuration.

You can now use this database for the `citybrk.ro` website.

