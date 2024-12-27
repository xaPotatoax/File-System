@echo off
cd "C:\xampp"  // Change this path if your XAMPP is installed in a different location
start xampp-control.exe
timeout /t 5 /nobreak > NUL  // Wait for 5 seconds to allow the control panel to open
start "" "C:\xampp\apache\bin\httpd.exe" -k start
start "" "C:\xampp\mysql\bin\mysqld.exe" --console