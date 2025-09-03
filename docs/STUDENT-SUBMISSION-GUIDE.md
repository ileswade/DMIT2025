# Student Submission Guide

**DMIT2025 - Complete Submission Workflow**

This guide shows you exactly how to prepare and submit your lab work and assignments with both your PHP code and database.

---

## 🎯 Quick Overview

When you submit lab work, you'll provide:
1. **Your PHP files** (all the code you wrote)
2. **Your database backup** (if the lab uses a database)
3. **Any other assets** (CSS, images, etc.)

All packaged in a single zip file that your instructor can easily test and grade.

---

## 📋 Step-by-Step Submission Process

### Step 1: Complete Your Lab Work

Work normally in your lab folder:
- Write your PHP code in `php/lab1/` (or lab2, lab3, etc.)
- Create and populate your database using the DB Maintenance tools
- Test everything thoroughly

### Step 2: Export Your Database (If Used)

**Only do this if your lab requires a database.**

1. **Navigate to your lab**
   - Go to http://localhost:8080/lab1/ (or your specific lab)

2. **Open Database Maintenance**
   - Click the "🛠️ DB Maintenance" button

3. **Export Your Database**
   - Click the blue "📦 Export Database" button
   - This downloads a `.sql` file to your Downloads folder

4. **Move the Database File**
   - Move the downloaded `.sql` file into your lab folder
   - Rename it to something clear like `database-backup-lab1.sql`

### Step 3: Organize Your Lab Folder

Your lab folder should contain:
```
lab1/
├── index.php              ← Your main PHP file
├── process.php            ← Any processing scripts
├── styles.css             ← Your CSS (if any)
├── images/                ← Any images you used
├── database-backup-lab1.sql ← Your database export
└── any other files you created
```

### Step 4: Create Your Submission Zip

1. **Navigate to your php folder**
   ```bash
   cd path/to/DMIT2025/php
   ```

2. **Create the zip file**
   ```bash
   # Replace with your actual name and lab number
   zip -r LastName_FirstName_Lab1.zip lab1/
   ```
   
   **On Windows:** You can also right-click the lab1 folder and choose "Send to → Compressed folder"
   
   **On Mac:** You can right-click the lab1 folder and choose "Compress lab1"

3. **Rename the zip file**
   - Use the format: `LastName_FirstName_Lab1.zip`
   - Example: `Smith_John_Lab1.zip`

### Step 5: Verify Your Submission

Before submitting, double-check your zip file:

1. **Extract it to a test location**
2. **Verify it contains:**
   - All your PHP files
   - Your database backup file (if applicable)
   - All CSS, images, and other assets
3. **Check file sizes are reasonable** (not empty files)

---

## 🔍 What Your Instructor Will Do

Your instructor will:

1. **Extract your zip file**
2. **Import your database backup** into phpMyAdmin
3. **Test your PHP code** against your exact database
4. **Grade based on the working system**

This ensures they're testing exactly what you built, with your data.

---

## 💡 Pro Tips

### For Database Work
- **Test your export:** After exporting, try importing it into a fresh database to make sure it works
- **Include sample data:** Make sure your database has enough data to demonstrate your features
- **Document special requirements:** If your code needs specific data, mention it in a comment

### For PHP Code
- **Clean up debug code:** Remove any `echo` statements used for debugging
- **Test on fresh environment:** If possible, test your code after restarting Docker containers
- **Include comments:** Comment your complex logic so instructor can understand your approach

### File Organization
- **Use clear filenames:** `process-form.php` is better than `temp.php`
- **Organize assets:** Put images in an `images/` folder, CSS in a `css/` folder
- **No unnecessary files:** Don't include `.DS_Store`, `thumbs.db`, or other system files

---

## 🚨 Common Mistakes to Avoid

### Database Issues
- ❌ **Forgot to export database** - PHP code won't work without the data
- ❌ **Empty database export** - Make sure your database actually has tables and data
- ❌ **Wrong database exported** - Double-check you're exporting the right lab's database

### File Issues
- ❌ **Missing files** - Forgot to include CSS or image files
- ❌ **Wrong folder structure** - Zipped the wrong folder level
- ❌ **Absolute paths in code** - Don't hard-code paths to your specific computer

### Submission Format
- ❌ **Wrong filename format** - Use exactly `LastName_FirstName_LabX.zip`
- ❌ **Multiple submissions** - Submit one zip file, not individual files
- ❌ **Corrupted zip** - Test your zip file before submitting

---

## 🛠️ Alternative: Using the Web Export Tool

Instead of manually downloading and organizing files, you can also:

1. Go to http://localhost:8080/shared/export-database.php
2. Select your project
3. Download the organized export

This tool creates a properly named SQL file automatically.

---

## 🔧 Troubleshooting

**"Export Database button is disabled"**
- Your database doesn't exist yet - create it first using "✅ Create Database"

**"Downloaded SQL file is empty"**
- Your database exists but has no tables/data
- Check phpMyAdmin to verify your database content

**"PHP code doesn't work for instructor"**
- Make sure all files are in the zip
- Verify your database export contains all necessary tables and data
- Test your submission by extracting and importing it yourself

**"Zip file too large"**
- Remove any unnecessary files (logs, temp files, etc.)
- Compress images if they're very large
- Contact instructor if your legitimate project files are causing size issues

---

## ✅ Submission Checklist

Before you submit, verify:

- [ ] All PHP files are included and working
- [ ] Database backup file is included (if lab uses database)
- [ ] All CSS, images, and assets are included  
- [ ] Zip file is properly named: `LastName_FirstName_LabX.zip`
- [ ] You can extract and test your own submission
- [ ] No unnecessary or system files included
- [ ] File sizes are reasonable (no empty files)

---

**Need Help?** Ask your instructor or check the main README.md for troubleshooting tips.

**Remember:** The goal is to provide everything needed for your instructor to run and test your work exactly as you built it!