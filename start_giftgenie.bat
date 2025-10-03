@echo off
title GiftGenie - AI Gift Recommendation System

echo.
echo  ╔══════════════════════════════════════════╗
echo  ║        🎁 GiftGenie System 🎁            ║
echo  ║     AI-Powered Gift Recommendations      ║
echo  ╚══════════════════════════════════════════╝
echo.

echo Choose an option:
echo.
echo [1] Start Full System (Backend + Frontend)
echo [2] Start Backend Only (Python API)
echo [3] Start Frontend Only (React App)
echo [4] Run Setup (First time setup)
echo [5] Test API Endpoints
echo [6] Exit
echo.

set /p choice="Enter your choice (1-6): "

if "%choice%"=="1" goto :start_full
if "%choice%"=="2" goto :start_backend
if "%choice%"=="3" goto :start_frontend
if "%choice%"=="4" goto :setup
if "%choice%"=="5" goto :test_api
if "%choice%"=="6" goto :exit
goto :invalid

:start_full
echo Starting full system...
echo.

echo [1/2] Starting Python Backend...
start "GiftGenie API" cmd /k "cd ai-part && call venv\Scripts\activate.bat && python app.py"

timeout /t 3 /nobreak >nul

echo [2/2] Starting React Frontend...
start "GiftGenie Frontend" cmd /k "cd frontend && npm run dev"

echo.
echo ✅ Both servers are starting!
echo 🌐 Frontend: http://localhost:5173
echo 🔗 Backend API: http://localhost:5000
echo.
pause
goto :main

:start_backend
echo Starting Python Backend only...
cd ai-part
call venv\Scripts\activate.bat
python app.py
pause
goto :main

:start_frontend
echo Starting React Frontend only...
cd frontend
npm run dev
pause
goto :main

:setup
echo Running setup script...
call setup.bat
pause
goto :main

:test_api
echo Testing API endpoints...
cd ai-part
call venv\Scripts\activate.bat
python test_api.py
pause
goto :main

:invalid
echo Invalid choice. Please try again.
timeout /t 2 /nobreak >nul
goto :main

:exit
echo Thank you for using GiftGenie! 🎁
timeout /t 2 /nobreak >nul
exit

:main
cls
goto :main