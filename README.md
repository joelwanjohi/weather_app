Overview
This weather application provides real-time weather data and forecasts using the OpenWeatherMap API. The project follows a decoupled architecture with:

Frontend: NextJS with TypeScript, styled using Tailwind CSS and RippleUI components
Backend: Laravel API serving as a proxy to the OpenWeatherMap API


Features

Real-time weather data for any location
3-day weather forecast
Temperature unit conversion (°C/°F)
Detailed weather information (wind speed, humidity, etc.)
Responsive design for all devices
Dynamic weather icons based on conditions
City search functionality

Tech Stack
Frontend

NextJS (React framework)
TypeScript
Tailwind CSS with RippleUI components
Fetch API for AJAX requests

Backend

Laravel (latest version)
PHP HTTP client for external API requests
RESTful API architecture

Project Structure
Frontend Structure
weather-app-frontend/
├── .env.local             # Environment variables
├── components/            # React components
│   ├── CurrentWeather.tsx # Current weather display
│   ├── ForecastCard.tsx   # Individual forecast card
│   ├── ForecastList.tsx   # 3-day forecast container
│   ├── SearchBar.tsx      # City search bar
│   ├── UnitToggle.tsx     # Temperature unit toggle
│   ├── WeatherInfo.tsx    # Wind/Humidity display
│   └── WeatherIcon.tsx    # Weather icon component
├── pages/                 # Next.js pages
│   ├── _app.tsx           # App wrapper
│   ├── _document.tsx      # Document wrapper
│   └── index.tsx          # Main page
├── services/              # API services
│   └── weatherService.ts  # Weather API client
├── types/                 # TypeScript types
│   └── weather.ts         # Weather data types
├── styles/                # CSS styles
│   └── globals.css        # Global CSS
├── public/                # Static assets
├── tailwind.config.js     # Tailwind configuration
└── package.json           # Dependencies

Backend Structure
weather-app-backend/
├── .env                   # Environment variables
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       └── WeatherController.php  # Weather API controller
│   │   └── Middleware/
│   │       └── Cors.php                   # CORS middleware
│   └── Services/
│       └── WeatherService.php             # OpenWeatherMap service
├── routes/
│   └── api.php            # API routes
├── config/
│   └── weather.php        # Weather API configuration
└── composer.json          # Dependencies
Getting Started
Prerequisites

Node.js (v18+)
PHP (v8.1+)
Composer
OpenWeatherMap API key

Sign up at OpenWeatherMap to get a free API key


Git

Installation
Frontend Setup

Clone the repository
bashgit clone https://github.com/yourusername/weather-app.git
cd weather-app/weather-app-frontend

Install dependencies
bashnpm install

Create a .env.local file
NEXT_PUBLIC_API_URL=http://localhost:8000/api

Start the development server
bashnpm run dev
The frontend will be available at http://localhost:3000

Backend Setup

Navigate to the backend directory
bashcd ../weather-app-backend

Install dependencies
bashcomposer install

Create a .env file by copying .env.example
bashcp .env.example .env

Configure your .env file with your OpenWeatherMap API key
OPENWEATHERMAP_API_KEY=your_api_key_here

Generate an application key
bashphp artisan key:generate

Start the development server
bashphp artisan serve
The Laravel API will be available at http://localhost:8000

API Endpoints
Backend API Endpoints
EndpointMethodDescriptionParameters/api/weather/currentGETGet current weathercity (string)/api/weather/forecastGETGet weather forecastcity (string)/api/weather/searchGETSearch for a cityquery (string)

Usage

Enter a city name in the search bar
View the current weather conditions
Check the 3-day forecast
Toggle between Celsius and Fahrenheit using the unit switcher



This application uses the following OpenWeatherMap API endpoints:

Current Weather Data: https://api.openweathermap.org/data/2.5/weather
5 Day / 3 Hour Forecast: https://api.openweathermap.org/data/2.5/forecast
