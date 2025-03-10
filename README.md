<h1 style="display: flex; align-items: center; justify-content: center;">
<img src="public/frontend/assets/img/logo/logo-default.png" alt="Pen-It Logo" style="margin-left: 10px; height: 40px;">
    Pen-It 
</h1>

## About Pen-It
<p>Pen-It is a full-stack, feature-rich blog management system designed for admins, authors, and readers. Built using the MVC architecture, it ensures scalability, maintainability, and ease of use.</p>

## Features:

### Core Features:
- ___Secure Authentication___: <br>Ensures reliable access control for users.

- ___Admin Tools___: <br>Efficient user and content management with category and tag creation.

- ___Analytics for Authors___: <br>Provides detailed insights like total views, most engaging posts, and AI-generated article tracking.

- ___Public Interface___: <br>Intuitive UI supporting browsing, commenting, and advanced search filters by categories, tags, or authors.

- ___Stripe Integration___: <br>Enables subscription-based access to premium features such as AI-powered article generation.

- ___Newsletter System___: <br>Engages users with timely updates on trending posts and new content.

### Technical Implementations:

- Built using the MVC architecture to maintain separation of concerns.

- Policies for role-based access control and resource management.

- Uses Schedulers and queues for seamless asynchronous email notifications without needing to wait for the subscribers to receive the notification.
  
- Observer Pattern to automate repetitive tasks like updating analytics and sending notifications.

- Chain Of Responsibility Pattern to manage and validate the user's request.

- Global Context to manage shared data and states across the application.

- Secured the app with CSRF Protection for robust security against malicious attacks.

## Installation

### Prerequisites:

- PHP 8.0+
- Laravel
- Composer
- MySQL
- NPM

### Steps to setup:

1. Clone the repository

```bash
    git clone https://github.com/Mani-G21/blog-cms
```
2. Install the dependancies

```bash
    composer install
    npm install
```

3. configure the `.env` file with the help of `.env.example`

4. Run database migrations

```bash
    php artisan migrate
```
5. Start the development server

```bash
    php artisan serve
```

6. Start the front-end server for auth

```bash
    npm run dev
```

7. Start the Queue in order listen for any jobs

```bash
    php artisan queue:work
```
<br>

## Usage

### Admin Role
- Manage users, categories, tags, and blogs.
  
### Author Role
- Write and publish blog posts.
- View post performance via analytics.
- Subscriber for premium features to generate blog posts with AI-Powered Assistance

### Reader Role
- Explore blogs, authors, comment on posts, and subscribe for newsletters.

## Overview of the folder structure:
- `app/Helpers/` : Helper functions.
- `app/Http/Controllers`: To implement the business logic and to return the views.
- `app/Jobs/`: Jobs to send the email notifications
- `app/Models/`: Models to communicate with the database
- `app/Observers/`: To observe on the changes being made to the database and take suitable actions on it.
- `app/policies/`: To implement access on the models based on the role of the user.
- `database/`: To provide the seeders, factories and migrations for the database tables.
- `resources/views/`: To provide the UI for the frontend.
- `routes/`: Provides routes for navigation
- `storage/app/public/` Provides the assets for the blogs or to store the assets in the project ___(A softlink points to this directory for accessing these assets with the help of public url)___.

## Screenshots
<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/homePage.png" alt="Home Page" width="500px">
        <p>Home Page</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/userProfile.png" alt="Author Details" width="500px">
        <p>Author Details</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/blogHero.png" alt="Blog Hero Section" width="500px">
        <p>Blog Hero Section</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/blog.png" alt="Blog Details" width="500px">
        <p>Blog Details</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/leaveComment.png" alt="Comments" width="500px">
        <p>Reader Comments</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/register.png" alt="Registration" width="500px">
        <p>Registration</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/dashboard.png" alt="Dashboard" width="500px">
        <p>Dashboard</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/postManagement.png" alt="Posts Management" width="500px">
        <p>Posts Management</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/subscriptionPlans.png" alt="Subscription Plans" width="500px">
        <p>Subscription Plans</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/categoryManagement.png" alt="Categories Management" width="500px">
        <p>Categories Management</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/createPost.png" alt="Post Creation" width="500px">
        <p>Creating a Post</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/manageUsers.png" alt="User Management" width="500px">
        <p>User Management</p>
    </div>
    <div style="flex: 1 1 45%; max-width: 45%; text-align: center;">
        <img src="storage/app/public/appScreenshots/Tags.png" alt="Tags Management" width="500px">
        <p>Tags Management</p>
    </div>
    
    
</div>
