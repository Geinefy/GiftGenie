@echo off
echo Fixing Python dependencies for GiftGenie AI...
echo.

REM Activate virtual environment
call venv\Scripts\activate.bat

echo Uninstalling problematic packages...
pip uninstall -y undetected-chromedriver selenium webdriver-manager

echo Installing updated requirements...
pip install -r requirements.txt

echo.
echo ✅ Dependencies updated successfully!
echo.
echo You can now run: python app.py
pause