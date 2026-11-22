# Database Fix Notes

## Issue: Field 'user_id' doesn't have a default value

**Error Message:**
```
Illuminate\Database\QueryException
SQLSTATE[HY000]: General error: 1364 Field 'user_id' doesn't have a default value
```

**Location:** When sending a comment or viewing a post that has comments
**URL:** `POST http://localhost:8000/reports/{report}/comments`

### Root Cause

The `RepsComment` model at `app/Models/RepsComment.php` was missing `user_id` from its `$fillable` array.

When `RepsComment::create()` was called with `user_id` from the session (`session('auth_user_id')`), Laravel's mass assignment protection blocked the `user_id` assignment because it wasn't listed as fillable. Since the `user_id` column in the `report_comments` database table has no default value, MySQL threw the error: `Field 'user_id' doesn't have a default value`.

### The Problem Code

In `routes/web.php` (line 197-206):
```php
Route::post('/reports/{report}/comments', function ($report) {
    $report = Reps::findOrFail($report);
    RepsComment::create([
        'report_id'   => $report->report_id,
        'user_id'     => session('auth_user_id'),  // <- This was being blocked
    ]);
    return back()->with('success', 'Komentar berhasil ditambahkan');
});
```

The `RepsComment::create()` call included `user_id`, but the model's `$fillable` array did not list it, so Laravel silently ignored it.

### Database Migration

The `report_comments` table migration at `database/migrations/2026_10_25_000005_create_report_comments_table.php` defines:
- `user_id` as `unsignedInteger` with a foreign key constraint to `users` table
- No default value specified for `user_id`

### Fix Applied

**File:** `app/Models/RepsComment.php`

**Changed lines 20-21 from:**
```php
#[Fillable(['report_id', 'body', 'created_at'])]
protected $fillable = ['report_id', 'body', 'created_at'];
```

**To:**
```php
#[Fillable(['report_id', 'body', 'created_at', 'user_id'])]
protected $fillable = ['report_id', 'body', 'created_at', 'user_id'];
```

Now when `RepsComment::create()` is called with `user_id`, Laravel's mass assignment protection allows it, and the value is properly inserted into the database.

### Prevention

Future developers should always include any field that will be passed to `Model::create()` in the model's `$fillable` array. If a field is missing from `$fillable`, Laravel will silently ignore it during mass assignment, which can cause database constraint errors if the column doesn't have a default value.