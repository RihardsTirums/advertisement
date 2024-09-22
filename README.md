
# Project Name: Advertisement portal

## Overview

This project is an advertisement platform where users can post ads for selling items such as electronics, cars, real estate, etc. The system is built using **Laravel**, **PostgreSQL** for data storage, and **Solr** for fast searching and indexing. We use **Jetstream** for authentication and **Telescope** for monitoring the app's performance during development.

---

## Table of Contents

- [Configuration](#configuration)
- [Database Schema](#database-schema)
- [Solr Integration](#solr-integration)
  - [Solr Indexing Command](#solr-indexing-command)
  - [Design Pattern](#design-pattern)
- [Language Switching](#language-switching)
  - [How It Works](#how-it-works)
  - [Design Pattern](#design-pattern)
- [Solr and Database Workflow](#solr-and-database-workflow)

---

## Configuration

### `.env` Configuration

Add your **PostgreSQL** and **Solr** configurations in the `.env` file:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

SOLR_HOST=127.0.0.1
SOLR_PORT=8983
SOLR_CORE=advertisement_portal_core
```

### Solarium Configuration (`config/solarium.php`)

The Solr client is configured using `config/solarium.php`. This configuration file defines the host, port, and core for connecting to Solr.

```php
return [
    'endpoint' => [
        'localhost' => [
            'host' => env('SOLR_HOST', '127.0.0.1'),
            'port' => env('SOLR_PORT', 8983),
            'path' => '/',
            'core' => env('SOLR_CORE', 'advertisement_portal_core'),
        ],
    ],
];
```

---

## Database Schema

The database schema is set up using **PostgreSQL**. Categories and subcategories are stored in a **nested parent-child structure**. The `categories` table contains translations for names and slugs in three languages (Latvian, English, Russian).

### Categories Table Structure

- `id`: Primary key
- `parent_id`: Foreign key referencing the parent category
- `name_lv`, `name_en`, `name_ru`: Translated category names
- `slug_lv`, `slug_en`, `slug_ru`: Translated slugs for URLs
- `created_at`, `updated_at`: Timestamps

---

## Solr Integration

### Indexing Categories to Solr

Categories and subcategories are stored in **PostgreSQL** but indexed in **Solr** for fast searching. To index all categories from the database into Solr, use the provided command:

#### Indexing Command

```bash
php artisan solr:index-categories
```

This command:
1. **Fetches categories** and their subcategories from the database.
2. **Indexes them** into Solr recursively.
3. **Commits the changes** to Solr for fast searching.

#### Design Pattern

We used the **Factory Method** pattern to decouple the logic for connecting to Solr and managing category indexing. The `SolrService` handles Solr-related operations such as fetching, updating, and indexing data.

- **SolrService**: A service class responsible for interacting with Solr.
- **Factory Method**: Used to abstract the creation of Solr clients and services, making it easier to change Solr configurations in the future.

---

## Language Switching

### How It Works

The application supports language switching between Latvian, English, and Russian. The user can change the language using a dropdown menu, and the language is stored in the session to persist across pages.

The session-based language switching is implemented using the **Strategy Pattern**. This allows for flexibility in how the language preference is stored (e.g., sessions, cookies, etc.).

### Design Pattern

We implemented the **Strategy Pattern** for language switching to separate the logic for how the language preference is stored from the controller logic.

- **LanguageStrategy Interface**: Defines how the locale should be set and stored.
- **SessionLanguageStrategy**: Implements the strategy for storing the locale in the session.
- **LocalizationController**: Handles requests to change the language and delegates the storage logic to the strategy.
- **Middleware**: Ensures the locale is applied on every request based on the session data.

---

## Solr and Database Workflow

1. **PostgreSQL**: All categories, subcategories, and listings are stored in the database.
2. **Solr**: Data from the database is indexed into Solr for fast searching.
3. **Indexing**: After any changes to the categories in the database, run `php artisan solr:index-categories` to update Solr.
4. **Monitoring**: Use Laravel Telescope to monitor indexing performance and query execution during development.

---
