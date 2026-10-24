<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Report;
use App\Models\ReportMedia;
use App\Models\ReportComment;
use App\Models\ReportActivity;

echo "=== Testing User ===\n";
$user = User::create([
    'username' => 'testuser_' . uniqid(),
    'email' => 'test' . uniqid() . '@test.com',
    'password_hash' => password_hash('secret', PASSWORD_DEFAULT),
    'role' => 'super_admin',
]);
echo "Created user: {$user->username} (ID: {$user->user_id}, Role: {$user->role})\n";

echo "\n=== Testing Category ===\n";
$suffix = uniqid();
$category = Category::create(['name' => 'Infrastructure_' . $suffix]);
echo "Created category: {$category->name} (ID: {$category->category_id})\n";

echo "\n=== Testing SubCategory ===\n";
$subCategory = SubCategory::create([
    'category_id' => $category->category_id,
    'name' => 'Roads_' . $suffix,
]);
echo "Created sub category: {$subCategory->name} (ID: {$subCategory->sub_category_id})\n";

echo "\n=== Testing Report ===\n";
$report = Report::create([
    'reference_code' => 'RPT-' . substr($suffix, -8),
    'title' => 'Test Report',
    'description' => 'Test description',
    'category_id' => $category->category_id,
    'sub_category_id' => $subCategory->sub_category_id,
    'reporter_name' => 'John Doe',
    'reporter_location' => 'Jakarta',
    'reporter_rt' => 5,
    'submitted_at' => now(),
]);
echo "Created report: {$report->title} (ID: {$report->report_id})\n";

echo "\n=== Testing ReportMedia ===\n";
$media = ReportMedia::create([
    'report_id' => $report->report_id,
    'media_url' => 'https://example.com/photo_' . $suffix . '.jpg',
    'media_type' => 'image',
    'uploaded_at' => now(),
]);
echo "Created media: {$media->media_url} (ID: {$media->media_id})\n";

echo "\n=== Testing ReportComment ===\n";
$comment = ReportComment::create([
    'report_id' => $report->report_id,
    'body' => 'Great report!',
    'created_at' => now(),
]);
echo "Created comment: {$comment->body} (ID: {$comment->comment_id})\n";

echo "\n=== Testing ReportActivity ===\n";
$activity = ReportActivity::create([
    'report_id' => $report->report_id,
    'user_id' => $user->user_id,
    'action' => 'created',
    'new_value' => 'Report submitted',
    'created_at' => now(),
]);
echo "Created activity: {$activity->action} (ID: {$activity->activity_id})\n";

echo "\n=== Testing Relationships ===\n";
echo "User assigned reports count: " . $user->assignedReports()->count() . "\n";
echo "Category sub categories count: " . $category->subCategories()->count() . "\n";
echo "Category reports count: " . $category->reports()->count() . "\n";
echo "Report category name: " . $report->category->name . "\n";
echo "Report sub category name: " . $report->subCategory->name . "\n";
echo "Report media count: " . $report->media()->count() . "\n";
echo "Report comments count: " . $report->comments()->count() . "\n";
echo "Report activities count: " . $report->activities()->count() . "\n";
echo "Activity user username: " . $activity->user->username . "\n";

echo "\n=== All tests passed! ===\n";