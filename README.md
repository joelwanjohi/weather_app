# Weather Application

This weather application provides real-time weather data and forecasts using the OpenWeatherMap API. The project follows a decoupled architecture.

## Overview

The application is built with:
- **Frontend**: NextJS with TypeScript, styled using Tailwind CSS and RippleUI components
- **Backend**: Laravel API serving as a proxy to the OpenWeatherMap API

## Features

- Real-time weather data for any location
- 3-day weather forecast
- Temperature unit conversion (°C/°F)
- Detailed weather information (wind speed, humidity, etc.)
- Responsive design for all devices
- Dynamic weather icons based on conditions
- City search functionality

## Tech Stack

### Frontend
- NextJS (React framework)
- TypeScript
- Tailwind CSS with RippleUI components
- Fetch API for AJAX requests

### Backend
- Laravel (latest version)
- PHP HTTP client for external API requests
- RESTful API architecture

## Project Structure

### Frontend Structure
```
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
```

### Backend Structure
```
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
```

## Getting Started

### Prerequisites
- Node.js (v18+)
- PHP (v8.1+)
- Composer
- OpenWeatherMap API key
  - Sign up at OpenWeatherMap to get a free API key
- Git

### Installation

#### Frontend Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/joelwanjohi/weather_app
   cd weather-app/weather-app-frontend
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Create a .env.local file**
   ```
   NEXT_PUBLIC_API_URL=http://localhost:8000/api
   ```

4. **Start the development server**
   ```bash
   npm run dev
   ```
   The frontend will be available at http://localhost:3000

#### Backend Setup

1. **Navigate to the backend directory**
   ```bash
   cd ../weather-app-backend
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Create a .env file by copying .env.example**
   ```bash
   cp .env.example .env
   ```

4. **Configure your .env file with your OpenWeatherMap API key**
   ```
   OPENWEATHERMAP_API_KEY=your_api_key_here
   ```

5. **Generate an application key**
   ```bash
   php artisan key:generate
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```
   The Laravel API will be available at http://localhost:8000

## API Endpoints

### Backend API Endpoints

| Endpoint | Method | Description | Parameters |
|----------|--------|-------------|------------|
| `/api/weather/current` | GET | Get current weather | city (string) |
| `/api/weather/forecast` | GET | Get weather forecast | city (string) |
| `/api/weather/search` | GET | Search for a city | query (string) |

## Usage

1. Enter a city name in the search bar
2. View the current weather conditions
3. Check the 3-day forecast
4. Toggle between Celsius and Fahrenheit using the unit switcher

## OpenWeatherMap API

This application uses the following OpenWeatherMap API endpoints:

- Current Weather Data: https://api.openweathermap.org/data/2.5/weather
- 5 Day / 3 Hour Forecast: https://api.openweathermap.org/data/2.5/forecast
