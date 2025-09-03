# DMIT2025 - Complete PHP Development Environment

**Version 1.0** | **For DMIT2025 Students**

A complete, isolated PHP and MySQL development environment using Docker. This setup provides everything you need for all labs, assignments, and your final project - with zero configuration headaches.

---

## 🎯 What Is This?

This is your **complete development environment** for DMIT2025. Instead of installing PHP, MySQL, and a web server directly on your computer, we use **Docker** - a tool that packages everything into an isolated, portable environment.

### Why Docker?
- **🔒 Isolated:** Won't interfere with your computer's existing software
- **⚡ Easy Reset:** Can completely reset the environment in seconds
- **🎯 Consistent:** Everyone gets exactly the same setup
- **💾 Resource Friendly:** Only uses resources when you're actually working
- **🚀 Simple:** Start/stop everything with one command

Think of Docker like having a **virtual computer inside your computer** that's perfectly set up for web development, but much lighter and faster than a traditional virtual machine.

---

## 📦 Part 1: Install Docker

### For Windows Users

1. **Download Docker Desktop for Windows**
   - Go to: https://www.docker.com/products/docker-desktop/
   - Click "Download for Windows"
   - Make sure to download the version for your system (most newer computers use 64-bit)

2. **Install Docker Desktop**
   - Run the downloaded installer
   - Accept the default settings during installation
   - **Important:** You may need to enable WSL 2 (Windows Subsystem for Linux) if prompted

3. **Restart Your Computer**
   - This is required for Docker to work properly

4. **Verify Installation**
   - Open PowerShell or Command Prompt
   - Type: `docker --version`
   - You should see something like "Docker version 24.x.x"
   - Type: `docker compose version`
   - You should see version information

**Troubleshooting Windows:**
- If you get "WSL 2" errors, follow the prompts to install WSL 2
- Make sure Virtualization is enabled in your BIOS (usually enabled by default on newer computers)
- Docker Desktop should show a green "Engine running" status in the system tray

### For Mac Users

1. **Download Docker Desktop for Mac**
   - Go to: https://www.docker.com/products/docker-desktop/
   - **Important:** Choose the right version for your Mac:
     - **Apple Silicon (M1/M2/M3 chips):** Download "Mac with Apple Chip"
     - **Intel Macs:** Download "Mac with Intel Chip"
   - If unsure, click the Apple menu → "About This Mac" to check your chip

2. **Install Docker Desktop**
   - Open the downloaded `.dmg` file
   - Drag Docker to your Applications folder
   - Open Docker from Applications

3. **Verify Installation**
   - Open Terminal (Applications → Utilities → Terminal)
   - Type: `docker --version`
   - Type: `docker compose version`
   - Both should return version information

**Troubleshooting Mac:**
- Make sure to drag Docker to Applications folder, don't run it from the .dmg
- Docker Desktop should show "Engine running" in the menu bar (whale icon)

---

## 🚀 Part 2: Get Your Development Environment

### Step 1: Download This Repository

1. **Download the Environment**
   ```bash
   git clone https://github.com/ileswade/DMIT2025.git
   cd DMIT2025
   ```
   
   **Don't have Git?** That's fine! Go to the GitHub page and click the green "Code" button, then "Download ZIP". Extract the ZIP file to your desired location.

2. **Open Terminal/Command Prompt in the Project Folder**
   - **Windows:** Navigate to the folder, then Shift+Right-click and choose "Open PowerShell window here"
   - **Mac:** Navigate to the folder in Finder, then right-click and choose "Services → New Terminal at Folder"

### Step 2: Start Your Environment

1. **Start Everything** (this will take a few minutes the first time)
   ```bash
   docker compose up -d
   ```
   
   The first time you run this, Docker will download PHP, MySQL, and phpMyAdmin. This is normal and only happens once.

2. **Verify It's Working**
   - Open your web browser
   - Go to: http://localhost:8080
   - You should see your "PHP Development Environment" dashboard

🎉 **That's it!** Your complete development environment is now running.

---

## 🏗️ Part 3: Understanding Your Environment

### What Just Happened?

Docker created three "containers" (think of them as mini-computers) for you:

1. **Web Server (PHP)** - Runs your PHP code at http://localhost:8080
2. **Database (MySQL)** - Stores your data, accessible via phpMyAdmin at http://localhost:8081
3. **phpMyAdmin** - Web interface to manage your databases

### Your Project Structure

```
DMIT2025/
├── php/                    ← 🎯 This is where ALL your work goes
│   ├── sb/                 ← Sandbox for experiments
│   ├── lab1/               ← Your Lab 1 work
│   ├── lab2/               ← Your Lab 2 work
│   ├── lab3/               ← Your Lab 3 work
│   ├── lab4/               ← Your Lab 4 work
│   ├── project/            ← Your final project
│   └── shared/             ← Helper utilities (don't modify)
├── docker-compose.yaml     ← Docker configuration
├── init-scripts/           ← Database setup scripts
└── docs/                   ← Additional documentation
```

**🔥 Important:** The `php/` folder is what you'll backup, version control, and submit. Everything else is just setup.

---

## 📚 Part 4: Working With Your Environment

### Starting and Stopping

**To Start Your Environment:**
```bash
docker compose up -d
```

**To Stop Your Environment:**
```bash
docker compose down
```

**To Reset Everything (fresh start):**
```bash
docker compose down -v
rm -rf mysql_data  # Only if you want to reset databases too
docker compose up -d
```

### Accessing Your Work

- **Project Dashboard:** http://localhost:8080
- **phpMyAdmin (Database):** http://localhost:8081 (username: `student`, password: `student`)
- **Your Projects:** http://localhost:8080/sb/, http://localhost:8080/lab1/, etc.

### Creating Databases

**You don't need databases for every lab!** Only create them when your lab specifically requires database work.

1. Go to any project (e.g., http://localhost:8080/sb/)
2. If you need a database, click "🛠️ DB Maintenance"
3. Click "✅ Create Database" (green button)
4. Your isolated database is ready!

Each project gets its own database:
- Sandbox: `php_course_sb`
- Lab 1: `php_course_lab1`
- Lab 2: `php_course_lab2` 
- etc.

---

## 💾 Part 5: Backing Up and Submitting Your Work

### What to Back Up

**Always back up your `php/` folder!** This contains:
- All your lab work
- Your final project
- Your database schemas
- Everything you need to recreate your environment

### For Version Control (Optional)
```bash
cd php/lab1
git init
git add .
git commit -m "Lab 1 initial commit"
```

### For Submission

1. **Export Your Database** (if the lab uses one):
   - Go to your lab (e.g., http://localhost:8080/lab1/)
   - Click "🛠️ DB Maintenance"
   - Click "📦 Export Database" (blue button)
   - This creates a `.sql` file in your lab folder

2. **Create Your Submission**:
   - Zip your entire lab folder: `LastName_FirstName_Lab1.zip`
   - The zip should contain:
     - Your PHP files (`index.php`, `process.php`, etc.)
     - Your database backup (e.g., `database-backup-lab1.sql`)
     - Any CSS, images, or other assets

3. **Submit the Zip File**

### Why This Works

Your instructor can:
1. Extract your zip file
2. Import your `.sql` file into phpMyAdmin
3. Test your PHP code against your exact database
4. Grade your work in the same environment you developed it

---

## 🆘 Troubleshooting

### Common Issues

**"Cannot connect to Docker daemon"**
- Make sure Docker Desktop is running (should show green "Engine running")
- Restart Docker Desktop if needed

**"Port already in use"**
- Something else is using ports 8080, 8081, or 3306
- Close other web servers or change ports in `docker-compose.yaml`

**"Database connection failed"**
- Make sure containers are running: `docker compose ps`
- Try restarting: `docker compose restart`

**Pages won't load**
- Check if Docker containers are running: `docker compose ps`
- Make sure you're accessing http://localhost:8080 (not https)

### Getting Help

1. **Check Container Status:** `docker compose ps`
2. **View Logs:** `docker compose logs`
3. **Restart Services:** `docker compose restart`
4. **Complete Reset:** `docker compose down -v && docker compose up -d`

---

## 🎓 For Instructors

This environment provides:
- ✅ Consistent development environment across all students
- ✅ Easy grading with exportable databases
- ✅ Isolated projects that don't interfere with each other
- ✅ Professional workflow preparation
- ✅ Simple backup/restore for assignments
- ✅ No "it works on my machine" issues

Students submit zip files containing both code and database backups, making grading straightforward and reproducible.

---

## 🔗 Additional Resources

- **[Student Submission Guide](docs/STUDENT-SUBMISSION-GUIDE.md)** - Detailed submission process
- **[Project Setup Guide](docs/NEW-PROJECT-SETUP.md)** - Creating new projects
- **[Claude Code Guide](docs/CLAUDE.md)** - For AI development assistance

---

**Need Help?** Check the `docs/` folder for additional guides or ask your instructor.

**Happy Coding!** 🚀