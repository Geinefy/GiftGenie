@echo off
echo ===============================================
echo    GiftGenie Setup Script
echo ===============================================
echo.

echo [1/5] Setting up Python Backend...
cd ai-part

REM Check if Python is available
python --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Python is not installed or not in PATH
    echo Please install Python 3.8+ from https://python.org
    pause
    exit /b 1
)

REM Create virtual environment if it doesn't exist
if not exist "venv" (
    echo Creating Python virtual environment...
    python -m venv venv
)

REM Activate virtual environment
echo Activating virtual environment...
call venv\Scripts\activate.bat

REM Install Python dependencies
echo Installing Python dependencies...
pip install -r requirements.txt

REM Create .env file if it doesn't exist
if not exist ".env" (
    echo Creating .env file...
    copy .env.example .env
    echo.
    echo ⚠️  IMPORTANT: Please edit ai-part\.env and add your GEMINI_API_KEY
    echo    You can get one from: https://makersuite.google.com/app/apikey
    echo.
)

cd ..

echo [2/5] Setting up Frontend...
cd frontend

REM Check if Node.js is available
node --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Node.js is not installed or not in PATH
    echo Please install Node.js from https://nodejs.org
    pause
    exit /b 1
)

REM Install frontend dependencies
echo Installing frontend dependencies...
npm install

cd ..

echo [3/5] Setup complete!
echo.
echo [4/5] Quick test of Python API...
cd ai-part
call venv\Scripts\activate.bat
timeout /t 2 /nobreak >nul
python -c "
try:
    from app import app
    from gemini_service import GeminiService
    print('✅ Python imports working')
except ImportError as e:
    print(f'❌ Import error: {e}')
except Exception as e:
    print(f'⚠️  Check your .env file: {e}')
"

cd ..

echo.
echo [5/5] 🎉 Setup Complete!
echo.
echo To start the system:
echo.
echo 1. Start the Python API server:
echo    cd ai-part
echo    start_server.bat
echo.
echo 2. In a new terminal, start the frontend:
echo    cd frontend  
echo    npm run dev
echo.
echo 3. Open your browser to: http://localhost:5173
echo.
echo 📚 For detailed documentation, see: SYSTEM_DOCUMENTATION.md
echo.

pause