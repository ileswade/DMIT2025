# 📋 Student Lab Submission Guide
**Simple Steps to Submit Your Work**

## 🎯 Quick Overview

When you're ready to submit your lab, you'll need to:
1. **Navigate** to your project folder
2. **Backup** your database (if needed)
3. **Zip** your project folder
4. **Submit** the zip file

**Total time: 2-3 minutes** ⏰

---

## 📂 Step 1: Find Your Project Folder

### On Windows (Command Prompt or PowerShell):
```cmd
cd "path\to\your\project"
cd php\lab1
```

### On Mac/Linux (Terminal):
```bash
cd /path/to/your/project
cd php/lab1
```

### 💡 **Easy Way to Find Your Path:**
- **Windows:** Open your project in File Explorer, click on the address bar, copy the path
- **Mac:** Open Finder, right-click your project folder, hold Option key, choose "Copy as Pathname"
- **VS Code users:** Open terminal in VS Code (it starts in the right location automatically)

---

## 🗄️ Step 2: Backup Your Database

### **Do I Need to Backup My Database?**

✅ **YES, backup if your project:**
- Creates, reads, or stores data in tables
- Has user registration, login, or profiles
- Stores products, orders, comments, etc.
- Uses any `INSERT`, `UPDATE`, or `DELETE` statements

❌ **NO backup needed if your project:**
- Only displays static content (no database at all)
- Only uses PHP for calculations or forms (no data storage)
- Your instructor specifically said "no database needed"

### **How to Backup Your Database:**

1. **Make sure you're in your project folder:**
   ```bash
   # You should be in something like: /your/path/php/lab1
   pwd    # (Mac/Linux) or 
   cd     # (Windows) to see current location
   ```

2. **Run the backup script:**
   ```bash
   php ../shared/backup-database.php
   ```

3. **Look for success message:**
   ```
   ✅ Database backup completed!
   📄 Saved as: database-backup-lab1.sql
   ```

4. **Verify the file was created:**
   - You should now see a file like `database-backup-lab1.sql` in your project folder
   - This file contains all your tables and data

### **Troubleshooting Database Backup:**

**❌ "Please run this script from inside your project folder"**
- You're in the wrong directory
- Use `cd php/lab1` to get to your project first

**❌ "Cannot find database utility"**  
- Make sure Docker is running: `docker compose up -d`
- Check you're in the right project structure

**❌ "Database connection failed"**
- Docker containers aren't running
- Run `docker compose up -d` from the main project directory

---

## 📦 Step 3: Create Your Submission Zip File

### **Option A: Using Command Line**

1. **Go up one level** (to the `php` folder):
   ```bash
   cd ..    # Now you should be in the 'php' folder
   ```

2. **Create the zip file:**
   
   **Windows (PowerShell):**
   ```powershell
   Compress-Archive -Path lab1 -DestinationPath "LastName_FirstName_Lab1.zip"
   ```
   
   **Mac/Linux:**
   ```bash
   zip -r LastName_FirstName_Lab1.zip lab1/
   ```

3. **Replace with your actual name:**
   ```bash
   # Example:
   zip -r Smith_John_Lab1.zip lab1/
   ```

### **Option B: Using File Explorer/Finder (Easier for beginners)**

1. **Navigate to your php folder** in File Explorer (Windows) or Finder (Mac)
2. **Right-click on your lab1 folder**
3. **Choose "Compress" (Mac) or "Send to > Compressed folder" (Windows)**
4. **Rename the zip file** to: `LastName_FirstName_Lab1.zip`

---

## ✅ Step 4: Verify Your Submission

### **Check Your Zip File Contains:**

**Unzip your file and verify it has:**
- ✅ All your PHP files (`index.php`, `process.php`, etc.)
- ✅ Any CSS, JavaScript, or image files you created
- ✅ Your database backup file (if needed): `database-backup-lab1.sql`
- ✅ No extra folders or files (like `.DS_Store` on Mac)

**Your zip file should look like:**
```
Smith_John_Lab1.zip
└── lab1/
    ├── index.php
    ├── process.php
    ├── styles.css
    ├── database-backup-lab1.sql  ⭐ (if database used)
    └── images/
        └── logo.png
```

### **File Size Check:**
- **With database:** Usually 50KB - 5MB
- **Without database:** Usually 10KB - 1MB  
- **If over 10MB:** You might have included unnecessary files

---

## 🚀 Complete Example Walkthrough

**Let's say you're submitting "Lab 1" and your name is "Alex Johnson":**

### **Step by step:**

1. **Open Terminal/Command Prompt**
   
2. **Navigate to your project:**
   ```bash
   cd /path/to/your/DMIT2025/php/lab1
   ```

3. **Backup database (if needed):**
   ```bash
   php ../shared/backup-database.php
   ```
   
   Look for: `✅ Database backup completed!`

4. **Go to parent folder:**
   ```bash
   cd ..    # Now in the 'php' folder
   ```

5. **Create zip:**
   ```bash
   zip -r Johnson_Alex_Lab1.zip lab1/
   ```

6. **Verify:**
   - File `Johnson_Alex_Lab1.zip` should appear
   - Contains your `lab1` folder with all files + database backup

**Done! Submit the zip file.** 🎉

---

## ❓ Frequently Asked Questions

### **Q: Do I need to zip the entire project folder or just individual files?**
**A:** Zip the entire project folder (`lab1`, `lab2`, etc.). This keeps everything organized.

### **Q: What if I don't have a database in my project?**
**A:** Skip the database backup step. Just zip your project folder with your PHP files.

### **Q: Can I submit without the command line?**
**A:** Yes! Use your file manager to:
1. Navigate to your project folder  
2. Right-click and compress/zip the folder
3. Rename to the proper format

### **Q: What if the backup script doesn't work?**
**A:** Try the web interface:
1. Go to http://localhost:8080/shared/export-database.php
2. Select your project
3. Click "Save SQL File to Project"

### **Q: Should I include the `mysql_data` folder?**
**A:** **NO!** Never include `mysql_data`. The backup script creates a clean SQL file instead.

### **Q: My zip file is huge (over 10MB). Is that normal?**
**A:** Probably not. Check if you accidentally included:
- Image files that are too large
- The `mysql_data` folder (remove it)
- Backup files or temporary files

---

## 🆘 Getting Help

### **Before asking for help, try:**

1. **Check Docker is running:**
   ```bash
   docker compose ps    # Should show running containers
   ```

2. **Test your project works:**
   - Visit: http://localhost:8080/lab1/
   - Does everything work as expected?

3. **Check project structure:**
   ```
   your-project/
   ├── php/
   │   ├── lab1/          ← Your project files here
   │   │   ├── index.php
   │   │   └── ...
   │   └── shared/
   └── backup-database.php ← Backup script here
   ```

### **Common Error Solutions:**

**"Command not found" or "php not recognized":**
- Make sure Docker containers are running
- Try: `docker compose up -d`

**"No such file or directory":**
- Double-check you're in the right folder
- Use `ls` (Mac/Linux) or `dir` (Windows) to see current files

**Zip file won't create:**
- Try the graphical method (right-click in file explorer)
- Make sure you have write permissions in the folder

---

## 🎯 Final Checklist

**Before submitting, ensure:**

- [ ] Your project works correctly at http://localhost:8080/lab1/
- [ ] All required features are implemented
- [ ] Database backup created (if project uses database)
- [ ] Zip file named correctly: `LastName_FirstName_ProjectName.zip`
- [ ] Zip file contains your project folder with all files
- [ ] File size is reasonable (under 10MB unless told otherwise)
- [ ] You've tested by extracting the zip to make sure everything is there

**You're ready to submit!** 🚀

---

*Need more help? Check the main dashboard at http://localhost:8080/ for additional tools and resources.*