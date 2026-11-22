# Sapa Trantib Project Documentation

## Overview

**Sapa Trantib** is a Laravel 13.37.0 application (PHP 8.5.7) that appears to be a community/reporting platform. The project name "sapa-trantib" is Indonesian/Malay phrasing, and the application supports reporting functionality with comments.

**Current Version:** Laravel 13.37.0
**PHP Version:** 8.5.7
**Database:** MySQL (Host: 127.0.0.1, Port: 3306, Database: sapatrantib)
## Project Structure

### Key Directories

```
app/                    # Application core
  Models/               # Eloquent models
    RepsComment.php     # Comment model (subject of recent fix)
    Reps.php            # Report model
    User.php            # User model
    OtpVerification.php # OTP verification model

database/
  migrations/           # Database schema migrations
    2026_10_25_000005_create_report_comments_table.php  # Comments table

routes/
  web.php               # Web routes (contains comment posting logic)

docs/                   # Project documentation (this folder)
  database-fix-notes.md # Database fix records
  project-documentation.md # This file
```
## Key Features

### Reporting System

Users can create reports and add comments to them. The core functionality includes:

- **Create reports** - Users can submit reports
- **Add comments** - Users can comment on reports (POST `/reports/{report}/comments`)
- **View reports** - Display reports with their comments
## Routes (from `routes/web.php`)
## Models
## Database
## Known Issues & Fixes
## Development Setup
## Code Conventions
## Recent Changes
## TODO / Future Work

- [ ] Add unit tests for comment functionality
- [ ] Implement API authentication for comment posting
- [ ] Add comment editing/deletion features
- [ ] Implement comment pagination for long discussions
- [ ] Add validation for comment body length
- [ ] Create admin dashboard for managing reports
```

### Fix: user_id fillable (2026-11-18)

- **File:** `app/Models/RepsComment.php`
- **Change:** Added `user_id` to `$fillable` array
- **Purpose:** Resolve "Field 'user_id' doesn't have a default value" error when posting comments

### Initial Project Setup

- Laravel 13.37.0 application
- MySQL database `sapatrantib`
- Authentication system with admin and warga guards
- Reporting and comment functionality
- RT (Rukun Tetangga) management features

### Naming Conventions

- **Models:** PascalCase, e.g., `RepsComment`, `Reps`, `User`
- **Migration files:** `YYYY_MM_DD_HHMMSS_create_table_name_table.php`
- **Route names:** Use dot notation, e.g., `reports.show`, `reports.comments.store`
- **Directory structure:** Follow Laravel conventions (App\Http\Controllers, App\Models, etc.)

### Database

- All models use explicit `$fillable` (no `guarded` mass assignment)
- Timestamps disabled on `RepsComment` (`public $timestamps = false`)
- Foreign key constraints with `onDelete('cascade')`
- UUID primary keys in some tables (`comment_id` in `report_comments`)

### Routes

- Web routes in `routes/web.php`
- API routes grouped under `/api/` prefix
- Resource routes for CRUD operations
- Route names used for navigation and redirects
### Model Relationships

This section documents the Eloquent relationships defined across the application's models.

#### `RepsComment` Model Relationships

**`report()` - BelongsTo Relationship**
- **Target:** `App\Models\Reps` model
- **Foreign Key:** `report_id` on `report_comments` table
- **Parent Key:** `report_id` on `reports` table
- **Purpose:** A comment belongs to a report/post
- **Usage:** `$comment->report`, `$comment->report()->find()`
- **Cascade Delete:** Yes - when a report is deleted, its comments are also deleted (defined in migration)

**`user()` - BelongsTo Relationship**
- **Target:** `App\Models\User` model
- **Foreign Key:** `user_id` on `report_comments` table
## API Documentation

## Authentication Flow

The application uses Laravel's default authentication system with custom guards for different user types.

### Guards Configuration

From `.env`:
- `SESSION_DRIVER=database` - Session data stored in database table
- No `SESSION_GUARD` specified - defaults to `web` guard

### Guard Types

#### 1. `web` Guard (Default)
- Used for traditional browser sessions
- Authenticated via login form
- Uses `RememberCookie` for persistent login
- Configured for admin and warga access

**Login Routes (Admin):**
- `GET /admin/login` - Login form
- `POST /admin/login` - Login credentials (AdminLoginController)
- `GET /admin/register` - Registration form
- `POST /admin/register` - Register account (AdminRegisterController)

**Login Routes (Warga):**
- `GET /warga/login` - Login form
- `POST /warga/login` - Login credentials (WargaLoginController)
- `GET /warga/register` - Registration form
- `POST /warga/register` - Register account (WargaRegisterController)

#### 2. Custom Session Management
The logout route manually manages custom session variables:

```php
// routes/web.php line 282-295
Route::post('/logout', function () {
    if (auth()->guard('web')->check()) {
        auth()->guard('web')->logout();
    }
    session()->forget(['auth_user_id', 'auth_user_role', 'auth_user_name']);
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('logout');
```

**Custom Session Variables Cleared:**
- `auth_user_id` - User's ID
- `auth_user_role` - User role (admin/warga)
- `auth_user_name` - User's name

### OTP (One-Time Password) Verification

**OTP Routes (Admin):**
- `GET /otp` - OTP verification form
- `POST /otp/request` - Request OTP code (OtpController)
- `POST /otp/verify` - Verify OTP code
- `POST /otp/resend` - Resend OTP if needed

**Purpose:** Email verification for admin registration using OTP system

### User Roles

Based on route patterns and session variables:
- **Admin** - Full access to admin routes (`/admin/*`), manages users, categories, reports
- **Warga** - Community member access (`/warga/*`), can create reports and comment
- **Guest** - Unauthenticated users can view reports but limited functionality

### Authentication Middleware

- `auth` middleware protects routes requiring login
- `guest` middleware protects login/registration routes
- Custom middleware may be applied to specific feature routes

### Password Reset

- Standard Laravel `forgot-password` and `reset-password` flows
- May be customized based on application requirements
- Uses email sent to `MAIL_MAILER=smtp` configuration
The application includes API routes grouped under the `/api/` prefix (defined in `routes/api.php` or via `Route::apiResource`).

### API Resources

#### `api/users`
- Standard Laravel resource controller for user management
- CRUD operations on user entities

#### `api/cats`
- Category management API
- Operations: index, show, store, update, destroy

#### `api/s-cats` (Sub Categories)
- Sub-category management API
- Operations: index, show, store, update, destroy

#### `api/reps` (Reports)
- Report management API
- **Key Endpoints:**
  - `GET /api/reps` - List all reports
  - `POST /api/reps` - Create a new report
  - `GET /api/reps/{id}` - Show a specific report
  - `PUT/PATCH /api/reps/{id}` - Update a report
  - `DELETE /api/reps/{id}` - Delete a report
  - Includes relationships: `category`, `subCategory`, `comments`, `media`

#### `api/rep-media`
- Media attachment management API
- Operations for uploading and managing report attachments
- Related to `RepMedia` model

#### `api/rep-comments`
- Comment management API
- Operations for managing comments on reports
- Related to `RepsComment` model
- **Note:** The `user_id` fillable fix applies here as well

#### `api/rep-activity`
- Activity logging API
- Operations for tracking user activities within the system

### API Authentication

- The API routes may use Laravel's default authentication guards
- Some routes may be protected by `auth:api` middleware
- Others may be public (like the comment posting endpoint at `/reports/{report}/comments`)

### Example API Request: Posting a Comment

```http
POST /api/reports/{report}/comments
Content-Type: application/json

{
    "report_id": 1,
    "user_id": 123,
    "body": "This is a test comment"
}
```

**Note:** The web route at `routes/web.php:197-206` uses a different approach (closures with session data) rather than the API route, but both ultimately create `RepsComment` records.

### API Testing

- Tests can be run with `vendor/bin/pest`
- API routes are testable using Pest's `actingAs()` authentication helper
- Ensure `user_id` is included in `$fillable` when testing comment creation via API
- **Parent Key:** `user_id` on `users` table
- **Purpose:** A comment is authored by a user
- **Usage:** `$comment->user`, `$comment->user()->find()`
- **Note:** The `user_id` was recently added to `$fillable` to fix a database error (see Known Issues section)

#### `Reps` Model Relationships

**`category()` - BelongsTo Relationship**
- **Target:** Category model (likely `App\Models\Cat` based on API routes)
- **Purpose:** A report belongs to a category
- **Usage:** `$report->category`

**`subCategory()` - BelongsTo Relationship**
- **Target:** SubCategory model (likely `App\Models\SCat` based on API routes)
- **Purpose:** A report belongs to a sub-category
- **Usage:** `$report->subCategory`

**`comments()` - HasMany Relationship**
- **Target:** `App\Models\RepsComment` model
- **Foreign Key:** `report_id` on `report_comments` table
- **Parent Key:** `report_id` on `reports` table
- **Purpose:** A report has many comments
- **Usage:** `$report->comments`, `$report->comments()->latest()`
- **Eager Loaded:** Frequently loaded with `->with('comments.user')` in routes

**`media()` - HasMany Relationship**
- **Target:** `App\Models\RepsMedia` model (implied by `rep-media` API resource)
- **Purpose:** A report can have multiple media attachments (images, files)
- **Usage:** `$report->media`

#### `User` Model Relationships

**`comments()` - HasMany Relationship**
- **Target:** `App\Models\RepsComment` model
- **Foreign Key:** `user_id` on `report_comments` table
- **Parent Key:** `user_id` on `users` table
- **Purpose:** A user has many comments
- **Usage:** `$user->comments`

**`otpVerifications()` - HasMany Relationship**
- **Target:** `App\Models\OtpVerification` model
- **Purpose:** User OTP verification records
- **Usage:** `$user->otpVerifications`

### Prerequisites

- PHP ^8.3
- Composer
- Laravel ^13.17
- MySQL 5.7+ or MariaDB 10.2+

### Installation

1. Run `composer install`
2. Copy `.env.example` to `.env` and configure database settings
3. Run `php artisan key:generate`
4. Run `php artisan migrate --force`
5. Run `npm install && npm run build`
6. Start the development server: `php artisan serve`

### Default Configuration

From `.env`:
- `APP_NAME=Laravel`
- `APP_ENV=local`
- `APP_DEBUG=true`
- `APP_URL=http://localhost:8000`
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=sapatrantib`
- `DB_USERNAME=root`
- `DB_PASSWORD=` (empty)
- `SESSION_DRIVER=database`
- `BROADCAST_CONNECTION=log`

### Issue: Field 'user_id' doesn't have a default value

**Error:** `SQLSTATE[HY000]: General error: 1364 Field 'user_id' doesn't have a default value`

**Location:** When posting comments via `POST /reports/{report}/comments`

**Root Cause:** The `RepsComment` model was missing `user_id` from its `$fillable` array. When `RepsComment::create(['user_id' => session('auth_user_id')])` was called, Laravel's mass assignment protection blocked the `user_id` assignment. Since the database column had no default value, MySQL threw the error.

**Fix Applied:** Added `user_id` to the `$fillable` array in `app/Models/RepsComment.php`:

```php
// Before
#[Fillable(['report_id', 'body', 'created_at'])]
protected $fillable = ['report_id', 'body', 'created_at'];

// After  
#[Fillable(['report_id', 'body', 'created_at', 'user_id'])]
protected $fillable = ['report_id', 'body', 'created_at', 'user_id'];
```

**Documentation:** See `docs/database-fix-notes.md` for detailed explanation.

### Migrations

#### `2026_10_25_000005_create_report_comments_table.php`

```php
Schema::create('report_comments', function (Blueprint $table) {
    $table->unsignedInteger('comment_id')->primary()->autoIncrement();
    $table->unsignedInteger('report_id');
    $table->unsignedInteger('user_id');
    $table->text('body');
    $table->timestamp('created_at');

    $table->foreign('report_id')->references('report_id')->on('reports')->onDelete('cascade');
    $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
});
```

**Note:** Both `report_id` and `user_id` have foreign key constraints with `onDelete('cascade')`. The `user_id` column has **no default value**, which was the cause of the original error.

### Key Tables

| Table | Key Columns | Description |
|-------|-------------|-------------|
| `reports` | `report_id` (primary) | Main reports/posts |
| `users` | `user_id` (primary) | System users |
| `report_comments` | `comment_id`, `report_id`, `user_id`, `body` | Comments on reports |
```

### `RepsComment` (app/Models/RepsComment.php)

```php
class RepsComment extends Model
{
    use HasFactory;
    protected $primaryKey = 'comment_id';
    protected $table = 'report_comments';
    public $timestamps = false;

    #[Fillable(['report_id', 'body', 'created_at', 'user_id'])]
    protected $fillable = ['report_id', 'body', 'created_at', 'user_id'];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Reps::class, 'report_id', 'report_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
```

**Important:** The `user_id` was recently added to `$fillable` to fix a database error (see `docs/database-fix-notes.md`).

### Report Routes

```php
// Display a specific report with comments
Route::get('/reports/{report}', function ($report) {
    $report = Reps::with('category', 'subCategory', 'comments.user', 'media')
        ->findOrFail($report);
    return view('reports.report-show', compact('report'));
})->name('reports.show');

// Post a comment on a report
Route::post('/reports/{report}/comments', function ($report) {
    $report = Reps::findOrFail($report);
    RepsComment::create([
        'report_id'   => $report->report_id,
        'user_id'     => session('auth_user_id'),
        'body'        => $request->body,  // implied from context
    ]);
    return back()->with('success', 'Komentar berhasil ditambahkan');
})->name('reports.comments.store');
```