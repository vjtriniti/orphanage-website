<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\ChildController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReportExportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\VolunteerController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\RecurringDonationController as AdminRecurringDonationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationReceiptController;
use App\Http\Controllers\DonorDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentCheckoutController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\RecurringDonationController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\VolunteerPortalController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsurePermission;
use App\Http\Middleware\EnsureTwoFactor;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about','about')->name('about');
Route::view('/programs','programs')->name('programs');
Route::view('/contact','contact')->name('contact');
Route::view('/donate','donate')->name('donate');
Route::post('/donate',[DonationController::class,'store'])->name('donations.store');
Route::post('/donate/checkout',[PaymentCheckoutController::class,'initialize'])->name('payments.initialize');
Route::get('/donate/callback',[PaymentCheckoutController::class,'callback'])->name('payments.callback');
Route::post('/contact',[ContactController::class,'store'])->name('contact.store');
Route::post('/newsletter',[\App\Http\Controllers\Admin\NewsletterSubscriberController::class,'store'])->name('newsletter.store');
Route::post('/payments/webhook',[PaymentWebhookController::class,'handle'])->name('payments.webhook');

Route::middleware('guest')->group(function(){
    Route::get('/login',[AuthController::class,'showLogin'])->name('login'); Route::post('/login',[AuthController::class,'login'])->name('login.store');
    Route::get('/register',[AuthController::class,'showRegister'])->name('register'); Route::post('/register',[AuthController::class,'register'])->name('register.store');
    Route::get('/forgot-password',[AuthController::class,'showForgot'])->name('password.request'); Route::post('/forgot-password',[AuthController::class,'sendReset'])->name('password.email');
    Route::get('/reset-password/{token}',[AuthController::class,'showReset'])->name('password.reset'); Route::post('/reset-password',[AuthController::class,'reset'])->name('password.update');
});

Route::middleware(['auth',EnsureTwoFactor::class])->group(function(){
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::get('/email/verify',[VerificationController::class,'notice'])->name('verification.notice'); Route::get('/email/verify/{id}/{hash}',[VerificationController::class,'verify'])->middleware('signed')->name('verification.verify'); Route::post('/email/verification-notification',[VerificationController::class,'resend'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('/dashboard',[DonorDashboardController::class,'index'])->name('dashboard'); Route::view('/profile','profile')->name('profile');
    Route::get('/donor/recurring',[RecurringDonationController::class,'index'])->name('donor.recurring'); Route::post('/donor/recurring',[RecurringDonationController::class,'store'])->name('donor.recurring.store'); Route::delete('/donor/recurring/{recurringDonation}',[RecurringDonationController::class,'cancel'])->name('donor.recurring.cancel');
    Route::get('/donations/{donation}/receipt',[DonationReceiptController::class,'download'])->name('donations.receipt');
    Route::get('/volunteer',[VolunteerPortalController::class,'index'])->name('volunteer.dashboard'); Route::get('/volunteer/apply',[VolunteerPortalController::class,'apply'])->name('volunteer.apply'); Route::post('/volunteer/apply',[VolunteerPortalController::class,'storeApplication'])->name('volunteer.application.store'); Route::post('/volunteer/check-in',[VolunteerPortalController::class,'checkIn'])->name('volunteer.checkin'); Route::patch('/volunteer/hours/{hour}/check-out',[VolunteerPortalController::class,'checkOut'])->name('volunteer.checkout');
    Route::get('/2fa/setup',[TwoFactorController::class,'setup'])->name('twofactor.setup'); Route::post('/2fa/setup',[TwoFactorController::class,'confirm'])->name('twofactor.confirm'); Route::post('/2fa/disable',[TwoFactorController::class,'disable'])->name('twofactor.disable');
});
Route::middleware('auth')->group(function(){ Route::get('/2fa/challenge',[TwoFactorController::class,'challenge'])->name('twofactor.challenge'); Route::post('/2fa/challenge',[TwoFactorController::class,'verify'])->name('twofactor.challenge.verify'); });

Route::middleware(['auth',EnsureAdmin::class,EnsureTwoFactor::class])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/',fn()=>redirect()->route('admin.dashboard'))->name('index');
    Route::get('/dashboard',[DashboardController::class,'index'])->middleware(EnsurePermission::class.':dashboard.view')->name('dashboard');
    Route::get('/donations',[AdminDonationController::class,'index'])->middleware(EnsurePermission::class.':donations.view')->name('donations.index'); Route::patch('/donations/{donation}/status',[AdminDonationController::class,'updateStatus'])->middleware(EnsurePermission::class.':donations.manage')->name('donations.status'); Route::get('/recurring-donations',[AdminRecurringDonationController::class,'index'])->middleware(EnsurePermission::class.':donations.view')->name('recurring.index'); Route::patch('/recurring-donations/{recurringDonation}/cancel',[AdminRecurringDonationController::class,'cancel'])->middleware(EnsurePermission::class.':donations.manage')->name('recurring.cancel');
    Route::get('/children',[ChildController::class,'index'])->middleware(EnsurePermission::class.':children.view')->name('children.index'); Route::post('/children',[ChildController::class,'store'])->middleware(EnsurePermission::class.':children.manage')->name('children.store'); Route::delete('/children/{child}',[ChildController::class,'destroy'])->middleware(EnsurePermission::class.':children.manage')->name('children.destroy');
    Route::resource('campaigns',CampaignController::class)->except(['show','create','edit'])->middleware(EnsurePermission::class.':campaigns.manage'); Route::resource('expenses',ExpenseController::class)->except(['show','create','edit'])->middleware(EnsurePermission::class.':expenses.manage');
    Route::get('/volunteers',[VolunteerController::class,'index'])->middleware(EnsurePermission::class.':volunteers.view')->name('volunteers.index'); Route::patch('/volunteers/{volunteer}/status',[VolunteerController::class,'updateStatus'])->middleware(EnsurePermission::class.':volunteers.manage')->name('volunteers.status');
    Route::get('/inventory',[InventoryController::class,'index'])->middleware(EnsurePermission::class.':inventory.view')->name('inventory.index'); Route::post('/inventory/{item}/move',[InventoryController::class,'move'])->middleware(EnsurePermission::class.':inventory.manage')->name('inventory.move');
    Route::resource('events',EventController::class)->except(['show','create','edit'])->middleware(EnsurePermission::class.':events.manage');
    Route::get('/education',[EducationController::class,'index'])->middleware(EnsurePermission::class.':education.view')->name('education.index'); Route::post('/education',[EducationController::class,'store'])->middleware(EnsurePermission::class.':education.manage')->name('education.store'); Route::patch('/education/{record}',[EducationController::class,'update'])->middleware(EnsurePermission::class.':education.manage')->name('education.update'); Route::delete('/education/{record}',[EducationController::class,'destroy'])->middleware(EnsurePermission::class.':education.manage')->name('education.destroy');
    Route::get('/healthcare',[MedicalRecordController::class,'index'])->middleware(EnsurePermission::class.':healthcare.view')->name('healthcare.index'); Route::post('/healthcare',[MedicalRecordController::class,'store'])->middleware(EnsurePermission::class.':healthcare.manage')->name('healthcare.store'); Route::patch('/healthcare/{record}',[MedicalRecordController::class,'update'])->middleware(EnsurePermission::class.':healthcare.manage')->name('healthcare.update'); Route::delete('/healthcare/{record}',[MedicalRecordController::class,'destroy'])->middleware(EnsurePermission::class.':healthcare.manage')->name('healthcare.destroy');
    Route::resource('posts',PostController::class)->except(['show','create','edit','update'])->middleware(EnsurePermission::class.':content.manage'); Route::get('/gallery',[GalleryController::class,'index'])->middleware(EnsurePermission::class.':gallery.view')->name('gallery.index'); Route::post('/gallery',[GalleryController::class,'store'])->middleware(EnsurePermission::class.':gallery.manage')->name('gallery.store'); Route::post('/gallery/{gallery}/images',[GalleryController::class,'upload'])->middleware(EnsurePermission::class.':gallery.manage')->name('gallery.images.upload'); Route::delete('/gallery/images/{image}',[GalleryController::class,'destroyImage'])->middleware(EnsurePermission::class.':gallery.manage')->name('gallery.images.destroy');
    Route::get('/messages',[ContactMessageController::class,'index'])->middleware(EnsurePermission::class.':messages.view')->name('messages.index'); Route::patch('/messages/{message}/read',[ContactMessageController::class,'read'])->middleware(EnsurePermission::class.':messages.manage')->name('messages.read'); Route::delete('/messages/{message}',[ContactMessageController::class,'destroy'])->middleware(EnsurePermission::class.':messages.manage')->name('messages.destroy');
    Route::get('/newsletter',[NewsletterController::class,'index'])->middleware(EnsurePermission::class.':newsletter.view')->name('newsletter.index'); Route::delete('/newsletter/{subscriber}',[NewsletterController::class,'destroy'])->middleware(EnsurePermission::class.':newsletter.manage')->name('newsletter.destroy');
    Route::get('/notifications',[NotificationController::class,'index'])->middleware(EnsurePermission::class.':notifications.view')->name('notifications.index'); Route::patch('/notifications/{id}/read',[NotificationController::class,'read'])->middleware(EnsurePermission::class.':notifications.manage')->name('notifications.read');
    Route::get('/reports',[ReportController::class,'index'])->middleware(EnsurePermission::class.':reports.view')->name('reports.index'); Route::get('/reports/donations.csv',[ReportExportController::class,'donationsCsv'])->middleware(EnsurePermission::class.':reports.export')->name('reports.donations.csv'); Route::get('/reports/expenses.csv',[ReportExportController::class,'expensesCsv'])->middleware(EnsurePermission::class.':reports.export')->name('reports.expenses.csv'); Route::get('/reports/donations.pdf',[ReportExportController::class,'donationsPdf'])->middleware(EnsurePermission::class.':reports.export')->name('reports.donations.pdf'); Route::get('/reports/expenses.pdf',[ReportExportController::class,'expensesPdf'])->middleware(EnsurePermission::class.':reports.export')->name('reports.expenses.pdf');
    Route::get('/audit-logs',[AuditLogController::class,'index'])->middleware(EnsurePermission::class.':audit.view')->name('audit.index'); Route::get('/settings',[SettingsController::class,'edit'])->middleware(EnsurePermission::class.':settings.manage')->name('settings.edit'); Route::put('/settings',[SettingsController::class,'update'])->middleware(EnsurePermission::class.':settings.manage')->name('settings.update');
    Route::get('/roles',[RoleController::class,'index'])->middleware(EnsurePermission::class.':roles.manage')->name('roles.index'); Route::post('/roles',[RoleController::class,'store'])->middleware(EnsurePermission::class.':roles.manage')->name('roles.store'); Route::put('/roles/{role}',[RoleController::class,'update'])->middleware(EnsurePermission::class.':roles.manage')->name('roles.update'); Route::delete('/roles/{role}',[RoleController::class,'destroy'])->middleware(EnsurePermission::class.':roles.manage')->name('roles.destroy'); Route::get('/users/{user}/roles',[UserRoleController::class,'edit'])->middleware(EnsurePermission::class.':roles.manage')->name('users.roles.edit'); Route::put('/users/{user}/roles',[UserRoleController::class,'update'])->middleware(EnsurePermission::class.':roles.manage')->name('users.roles.update');
});
