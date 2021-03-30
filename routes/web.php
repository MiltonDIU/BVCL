<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\ProfilesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\BusinessCategoryController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\ServiceStatusController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\AnswersController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\ServiceHistoryController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Admin\TrainingApplyController;
use App\Http\Controllers\Admin\AttendanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    return redirect()->route('admin.home');
});

Route::get('not-allowed', function (){
    return view('admin.not-allowed');
})->name('not-allowed');


Auth::routes(['register' => true]);
Route::get('userVerification/{token}', [UserVerificationController::class ,'approve'])->name('userVerification');
// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::resources([
        'permissions' => PermissionsController::class,
        'roles' => RolesController::class,
        'users' => UsersController::class,
        'countries' => CountriesController::class,
        'profiles' => ProfilesController::class,
        'business-categories' => BusinessCategoryController::class,
        'businesses' => BusinessController::class,
        'service-statuses' => ServiceStatusController::class,
        'services' => ServiceController::class,
        'questions' => QuestionsController::class,
        'answers' => AnswersController::class,
        'service-histories' => ServiceHistoryController::class,
    ]);
    // Attendances
    Route::resources(['attendances' => AttendanceController::class],['except' => ['destroy']]);


    Route::resources(['assessments' => AssessmentController::class],['except' => ['edit', 'update']]);
    Route::resources(['audit-logs' => AuditLogsController::class],['except' => ['create', 'update','delete','edit']]);
    //trainings
    Route::resources(['trainings' => TrainingController::class]);
    Route::post('trainings/apply', [TrainingController::class,'apply'])->name('trainings.apply');
    Route::post('trainings/approved', [TrainingController::class,'approved'])->name('trainings.approved');
    Route::get('trainings/attendance/{id}', [TrainingController::class,'attendance'])->name('trainings.attendance');
    Route::post('trainings/attendance', [TrainingController::class,'attendanceStore'])->name('trainings.attendance.store');

    // Training Applies
    Route::resources(['training-applies' => TrainingApplyController::class]);
    Route::delete('training-applies/destroy', [TrainingApplyController::class, 'massDestroy'])->name('training-applies.massDestroy');
    // Settings
//    Route::resources(['permissions' => SettingsController::class],['except' => ['create', 'store', 'show', 'destroy']]);
    Route::post('settings/media', [SettingsController::class, 'storeMedia'])->name('settings.storeMedia');
    Route::post('settings/ckmedia', [SettingsController::class, 'storeCKEditorImages'])->name('settings.storeCKEditorImages');

    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    // Business Categories
    Route::delete('business-categories/destroy', [BusinessCategoryController::class, 'massDestroy'])->name('business-categories.massDestroy');

    // Businesses
    Route::delete('businesses/destroy', [BusinessController::class, 'massDestroy'])->name('businesses.massDestroy');
    Route::post('businesses/media', [BusinessController::class, 'storeMedia'])->name('businesses.storeMedia');
    Route::post('businesses/ckmedia', [BusinessController::class, 'storeCKEditorImages'])->name('businesses.storeCKEditorImages');
    // service assign to
    Route::get('services/{id}/assign-to', [ServiceController::class,'assignTo'])->name('service.assign');
    Route::get('services/{id}/history', [ServiceController::class,'history'])->name('service.history');
    Route::post('services/assign-to', [ServiceController::class,'assignToPost'])->name('service.assign-to');

    // service status change
    Route::get('services/{id}/service-status', [ServiceController::class,'serviceStatus'])->name('service.status');
    Route::post('services/service-status-change', [ServiceController::class,'serviceStatusChange'])->name('service.service-status-change');

    // service comments
    Route::get('services/{id}/comments', [ServiceController::class,'comments'])->name('service.comments');
    Route::post('services/comments', [ServiceController::class,'serviceComments'])->name('service.service-comments');



    Route::get('/', [HomeController::class, 'index']);
    Route::delete('service-histories/destroy', [ServiceHistoryController::class, 'massDestroy'])->name('service-histories.massDestroy');
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::delete('countries/destroy', [CountriesController::class, 'massDestroy'])->name('countries.massDestroy');
    Route::delete('profiles/destroy', [ProfilesController::class, 'massDestroy'])->name('profiles.massDestroy');
    Route::delete('service-statuses/destroy', [ServiceStatusController::class, 'massDestroy'])->name('service-statuses.massDestroy');
    Route::delete('services/destroy', [ServiceController::class, 'massDestroy'])->name('services.massDestroy');
    // Questions
    Route::delete('questions/destroy', [QuestionsController::class, 'massDestroy'])->name('questions.massDestroy');
    // Assessments
    Route::delete('assessments/destroy', [AssessmentController::class, 'massDestroy'])->name('assessments.massDestroy');

    // Answers
    Route::delete('answers/destroy', [AnswersController::class, 'massDestroy'])->name('answers.massDestroy');

    // Trainings
    Route::delete('trainings/destroy', [TrainingController::class, 'massDestroy'])->name('trainings.massDestroy');
    Route::post('trainings/media', [TrainingController::class, 'storeMedia'])->name('trainings.storeMedia');
    Route::post('trainings/ckmedia', [TrainingController::class, 'storeCKEditorImages'])->name('trainings.storeCKEditorImages');



//profile
    Route::post('profiles/media', [ProfilesController::class, 'storeMedia'])->name('profiles.storeMedia');
    Route::post('profiles/ckmedia', [ProfilesController::class, 'storeCKEditorImages'])->name('profiles.storeCKEditorImages');


// Service Statuses
    Route::post('service-statuses/media', [ServiceStatusController::class, 'storeMedia'])->name('service-statuses.storeMedia');
    Route::post('service-statuses/ckmedia', [ServiceStatusController::class, 'storeCKEditorImages'])->name('service-statuses.storeCKEditorImages');

//// Services
    Route::post('services/media', [ServiceController::class, 'storeMedia'])->name('services.storeMedia');
    Route::post('services/ckmedia', [ServiceController::class, 'storeCKEditorImages'])->name('services.storeCKEditorImages');

    // Service Histories
    Route::post('service-histories/media', [ServiceHistoryController::class, 'storeMedia'])->name('service-histories.storeMedia');
    Route::post('service-histories/ckmedia', [ServiceHistoryController::class, 'storeCKEditorImages'])->name('service-histories.storeCKEditorImages');
//Audit Logs
    Route::resources(['audit-logs' => ServiceHistoryController::class],['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class,'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class,'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class,'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class,'destroy'])->name('password.destroyProfile');
        Route::get('my-profile', [ProfilesController::class, 'edit'])->name('my-profile.edit');
        Route::put('my-profile', [ProfilesController::class, 'update'])->name('my-profile.update');
    }
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return redirect()->back()->with('message','Cache facade value cleared');
});
