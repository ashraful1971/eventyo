# Eventyo - Event Management System

## Overview

Eventyo is a simple, web-based application that allows users to create, manage, and view events, as well as register attendees and generate event reports. It is built using pure PHP with a custom minimal MVC-like framework structure, designed for simplicity, extendability, and future scalability.

### [Live Demo](https://eventyo.mohammadashraful.com/)

## Features

1. **User Authentication**

   - Secure user registration and login with password hashing.
   - Middleware to handle authentication and authorization.

2. **Event Management**

   - Authenticated users can create, update, view, and delete events.
   - Event details include name, description, date, and maximum capacity.

3. **Attendee Registration**

   - Users can register for events through a dedicated form.
   - Registration is restricted if the maximum capacity is reached or after the event ended.
   - Seamless user experience during event registration via AJAX.

4. **Event Dashboard**

   - Paginated, sortable, and filterable event listings for better user experience.
   - Search across events and attendees.

5. **Event Reports**

   - Admins can download attendee lists for specific events in CSV format.

6. **JSON API Endpoint**

   - Fetch all events programmatically via a JSON API .
   - Fetch specific event details along with attendees list programmatically via a JSON API.

## Technical Details

- Minimal and simple MVC-like framework inspired by Laravel.
- Routing with dynamic parameters support.
- Service Container & Service Provider for future extendability.
- Utilizes PHP Reflection for automatic dependency resolution.
- Middleware for authentication and authorization.
- Models for data mapping and interaction with the database.
- Service classes for business logic (e.g., authentication).
- Views for presenting UI.
- Custom console command to run database migrations easily.
- Comprehensive client-side and server-side validation.
- Designed using MySQL.
- Secure interaction with prepared statements to prevent SQL injection.
- Responsive design implemented using Tailwindcss for accessibility across devices.

## Hosting

The project is hosted on a shared hosting and is accessible through the following link:
**[Live Demo Link](https://eventyo.mohammadashraful.com/)**

### Login Credentials for Testing

- Email: `john@gmail.com`
- Password: `123456`

## Setup Instructions

### Prerequisites

- PHP 7.4 or higher
- MySQL
- Composer
- A web server (e.g., Apache, Nginx)

### Installation Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/ashraful1971/eventyo
   ```
2. Run:
   ```bash
   composer install
   ```
3. Configure the database from `src/Config/app.php` file
4. Run the migration and seeder using console
   ```bash
   php ./artisan.php
   ```
5. Start the server
   ```bash
   php -S localhost:8000
   ```
6. Access the application in your browser at: http://localhost:8000

## API Endpoints

### 1. Get All Events

**Endpoint:** `GET /api/events`  
**Description:** Retrieves a list of all events.  
**Response:**

```json
[
   {
   "id": 25,
   "user_id": 1,
   "name": "Ollyo Conf",
   "description": "Lorem Ipsum is simply dummy text",
   "date": "2025-10-10",
   "time": "10:00 AM - 03:30 PM",
   "location": "Dhaka, Banlgadesh",
   "attendees_count": 0,
   "capacity": 100,
   "created_at": "2025-01-27 16:34:53",
   "updated_at": "2025-01-27 16:34:53"
   },
]

```

### 2. Get Event Details

**Endpoint:** `GET /api/events/{id}`  
**Description:** Retrieves the details of a specific event by its ID.  
**Parameters:** `id` (integer): The ID of the event.
 
**Response:**

```json
{
    "id": 25,
    "user_id": 1,
    "name": "Ollyo Conf",
    "description": "Lorem Ipsum is simply dummy text.",
    "date": "2025-10-10",
    "time": "10:00 AM - 03:30 PM",
    "location": "Dhaka, Banlgadesh",
    "attendees_count": 2,
    "capacity": 100,
    "created_at": "2025-01-27 16:34:53",
    "updated_at": "2025-01-27 18:20:38",
    "attendees": [
        {
            "id": 3,
            "event_id": 25,
            "name": "Md. Ashraful",
            "phone": "0170000000",
            "email": "ashraful@gmail.com",
            "created_at": "2025-01-27 18:20:18",
            "updated_at": "2025-01-27 18:20:18"
        },
        {
            "id": 4,
            "event_id": 25,
            "name": "John Doe",
            "phone": "0170000001",
            "email": "john@gmail.com",
            "created_at": "2025-01-27 18:20:38",
            "updated_at": "2025-01-27 18:20:38"
        }
    ]
}

```

### 3. Get Attendees for an Event

**Endpoint:** `GET /api/events/{id}/attendees`  
**Description:** Retrieves a list of attendees registered for a specific event by its ID.  
**Parameters:** `id` (integer): The ID of the event.  
**Response:**

```json
[
    {
        "id": 3,
        "event_id": 25,
        "name": "Md. Ashraful",
        "phone": "0170000000",
        "email": "ashraful@gmail.com",
        "created_at": "2025-01-27 18:20:18",
        "updated_at": "2025-01-27 18:20:18"
    },
    {
        "id": 4,
        "event_id": 25,
        "name": "John Doe",
        "phone": "0170000001",
        "email": "john@gmail.com",
        "created_at": "2025-01-27 18:20:38",
        "updated_at": "2025-01-27 18:20:38"
    },
]

```
