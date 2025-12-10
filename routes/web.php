
<?php

use App\Models\Task;
use App\Http\Middleware\ValidUser;
use App\Http\Middleware\ValidAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use GuzzleHttp\Psr7\Request;

// ================= TEST ROUTES =================

// ================= END TEST ROUTES =================

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
// ================= TEST PATIENT SIGNUP =================
// ================= TEST PATIENT SIGNUP =================


Route::get('/', [PatientController::class, 'homepage'])->name('patient.homepage');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/confirm-reset/{token}', [AuthController::class, 'confirmReset']);


Route::get('/user/dashboard',[UserController::class,'dashboard'])->middleware(ValidUser::class);
Route::post('/user/logout', [UserController::class,'logout'])->name('user.logout');

Route::get('/admin/register',[AdminController::class,'registerPage']);
Route::post('/admin/register',[AdminController::class,'register']);
Route::get('/admin/verify-email/{token}', [AdminController::class, 'verifyEmail'])->name('admin.verify.email');
Route::post('/admin/create-user', [AdminController::class, 'createUser'])->name('admin.users.store');
Route::post('/admin/assign-task',[AdminController::class,'assignTask']);
Route::post('/admin/update-status/{task}', [AdminController::class, 'updateStatus']);

Route::middleware([ValidAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/users', [AdminController::class, 'userManagement']);
    Route::get('/admin/tasks', [AdminController::class, 'taskManagement']);
});
Route::middleware([ValidAdmin::class])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'userManagement'])->name('admin.users');
});
Route::post('/admin/logout', [AdminController::class,'logout1']);
Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->middleware(ValidAdmin::class);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('/admin/users/toggle-status/{id}', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
Route::post('/admin/users/update/{id}', [AdminController::class, 'updateUser'])
    ->name('admin.users.update');

Route::get('/tasks/comment/{task}', [TaskController::class, 'coment'])->name('tasks.comment');
Route::post('/tasks/comment/{task}', [TaskController::class, 'storeComment'])->name('tasks.comment.store');
Route::get('/task/create', [TaskController::class, 'create']);
Route::post('/task/store', [TaskController::class, 'store']);
Route::get('/task/edit/{task}', [TaskController::class, 'edit']);
Route::get('/task/comment/{task}', [TaskController::class, 'comment'])->name('task.comment');
Route::post('/task/comment/{task}', [TaskController::class, 'storeComment'])->name('task.comment.store');
Route::put('/task/update/{task}', [TaskController::class, 'update']);
Route::delete('/task/delete/{task}', [TaskController::class, 'destroy']);

Route::get('/receptionist/dashboard', [ReceptionistController::class, 'dashboard'])->middleware('auth');
Route::post('/receptionist/send-to-doctor/{appointmentId}', [ReceptionistController::class, 'sendToDoctor'])->middleware('auth')->name('receptionist.send.to.doctor');

Route::get('/nurse/dashboard', function () {
    return view('dashboard.nurse');
})->middleware('auth');


Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

Route::get('/patient/verify-email/{token}', [PatientController::class, 'verifyEmail'])->name('patient.verify.email');

// Patient Password Reset Routes
Route::post('/patient/forgot-password', [PatientController::class, 'forgotPassword'])->name('patient.forgot.password');
Route::get('/patient/confirm-reset/{token}', [PatientController::class, 'confirmReset'])->name('patient.confirm.reset');





Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])
    ->name('patient.dashboard');

Route::get('/patient/signup', function () {
    return redirect()->route('signup.terms');
})->name('patient.signup');

Route::get('/patient/signup-form', [PatientController::class, 'showSignupForm'])->name('patient.signup.form');
Route::post('/patient/signup', [PatientController::class, 'signUp'])->name('patient.signup.post');

Route::get('/signup/complete', function() {
    return redirect()->route('patient.signup.form');
})->name('signup.complete');

Route::get('/patient/signin', [PatientController::class, 'showSignIn'])->name('patient.signin');
Route::post('/patient/signin', [PatientController::class, 'signIn'])->name('patient.signin.post');
Route::post('/patient/logout', [PatientController::class, 'logout'])->name('patient.logout');
Route::get('/patient/appointments', [PatientController::class, 'appointmentDashboard'])->name('patient.appointments');

// Appointment Wizard Routes
Route::get('/patient/appointments/new', [PatientController::class, 'wizardStep1'])->name('patient.appointments.new');
Route::get('/patient/appointments/new/step1', [PatientController::class, 'wizardStep1'])->name('patient.appointments.wizard.step1');
Route::post('/patient/appointments/new/step1', [PatientController::class, 'processWizardStep1'])->name('patient.appointments.wizard.step1.post');
Route::get('/patient/appointments/new/step2', [PatientController::class, 'wizardStep2'])->name('patient.appointments.wizard.step2');
Route::post('/patient/appointments/new/step2', [PatientController::class, 'processWizardStep2'])->name('patient.appointments.wizard.step2.post');
Route::get('/patient/appointments/new/step3', [PatientController::class, 'wizardStep3'])->name('patient.appointments.wizard.step3');
Route::post('/patient/appointments/new/step3', [PatientController::class, 'processWizardStep3'])->name('patient.appointments.wizard.step3.post');
Route::get('/patient/appointments/new/step4', [PatientController::class, 'wizardStep4'])->name('patient.appointments.wizard.step4');
Route::post('/patient/appointments/new/step4', [PatientController::class, 'processWizardStep4'])->name('patient.appointments.wizard.step4.post');

// Appointment Routes
Route::get('/patient/appointment-dashboard', [PatientController::class, 'appointmentDashboard'])->name('patient.appointment.dashboard');
Route::post('/patient/book-appointment', [PatientController::class, 'bookAppointment'])->name('patient.book.appointment');
Route::post('/patient/cancel-appointment/{id}', [PatientController::class, 'cancelAppointment'])->name('patient.cancel.appointment');
// Payment endpoint for Stripe token charging
use App\Http\Controllers\PatientPaymentController;
use App\Http\Controllers\InsuranceController;
Route::post('/patient/appointments/pay', [PatientPaymentController::class, 'charge'])->name('patient.appointments.pay');

// Insurance Routes
Route::middleware(['auth:patient'])->group(function () {
    Route::post('/api/insurance', [InsuranceController::class, 'store'])->name('insurance.store');
    Route::get('/api/insurance', [InsuranceController::class, 'getInsurances'])->name('insurance.get');
    Route::put('/api/insurance/{id}', [InsuranceController::class, 'update'])->name('insurance.update');
    Route::delete('/api/insurance/{id}', [InsuranceController::class, 'destroy'])->name('insurance.destroy');
});

// Family Members Routes
use App\Http\Controllers\FamilyMembersController;
// Route::middleware(['auth:patient'])->group(function () {
//     Route::post('/api/family-members', [FamilyMembersController::class, 'store'])->name('family-members.store');
//     Route::get('/api/family-members', [FamilyMembersController::class, 'getFamilyMembers'])->name('family-members.get');
//     Route::get('/api/family-members/{id}', [FamilyMembersController::class, 'show'])->name('family-members.show');
//     Route::put('/api/family-members/{id}', [FamilyMembersController::class, 'update'])->name('family-members.update');
//     Route::delete('/api/family-members/{id}', [FamilyMembersController::class, 'destroy'])->name('family-members.destroy');
// });
Route::post('/api/family-members', [FamilyMembersController::class, 'store'])->name('family-members.store');
Route::get('/api/family-members', [FamilyMembersController::class, 'getFamilyMembers'])->name('family-members.get');
Route::get('/api/family-members/{id}', [FamilyMembersController::class, 'show'])->name('family-members.show');
Route::put('/api/family-members/{id}', [FamilyMembersController::class, 'update'])->name('family-members.update');
Route::delete('/api/family-members/{id}', [FamilyMembersController::class, 'destroy'])->name('family-members.destroy');

Route::get('/patient/profile', [PatientController::class, 'showProfile'])->name('patient.profile');
Route::post('/patient/profile', [PatientController::class, 'updateProfile'])->name('patient.profile.update');
Route::get('/patient/visits', [PatientController::class, 'visits'])->name('patient.visits');
Route::get('/patient/walkin', [PatientController::class, 'walkin'])->name('patient.walkin');
Route::get('/patient/notes', [PatientController::class, 'notes'])->name('patient.notes');
Route::get('/patient/insurance', [PatientController::class, 'insurance'])->name('patient.insurance');
Route::get('/patient/faqs', [PatientController::class, 'faqs'])->name('patient.faqs');
Route::get('/patient/contact-us', [PatientController::class, 'contactUs'])->name('patient.contact-us');
Route::get('/patient/forgot-password', [PatientController::class, 'showForgotPasswordForm'])->name('patient.forgot.password.form');
Route::get('/patient/family-member', [PatientController::class, 'familyMember'])->name('patient.family.member');






// Signup Flow Routes
Route::post('/signup/accept-terms', [SignupController::class, 'acceptTerms'])->name('signup.accept-terms');
Route::post('/signup/confirm-prerequisites', [SignupController::class, 'confirmPrerequisites'])->name('signup.confirm-prerequisites');
Route::post('/signup/submit-age-verification', [SignupController::class, 'submitAgeVerification'])->name('signup.submit-age-verification');
Route::get('/signup/terms', [SignupController::class, 'terms'])->name('signup.terms');
Route::get('/signup/prerequisites', [SignupController::class, 'prerequisites'])->name('signup.prerequisites');
Route::get('/signup/age-verification', [SignupController::class, 'ageVerification'])->name('signup.age-verification');

// Back routes
Route::get('/signup/back-to-terms', [SignupController::class, 'backToTerms'])->name('signup.back.to.terms');
Route::get('/signup/back-to-prerequisites', [SignupController::class, 'backToPrerequisites'])->name('signup.back.to.prerequisites');
// Back routes
Route::get('/signup/back-to-terms', [SignupController::class, 'backToTerms'])->name('signup.back.to.terms');
Route::get('/signup/back-to-prerequisites', [SignupController::class, 'backToPrerequisites'])->name('signup.back.to.prerequisites');

// Provider Routes
Route::post('/provider/login', [AuthController::class, 'providerLogin'])->name('provider.login');
// Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->middleware('auth');

// Doctor Appointment Actions
Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/appointment/{id}', [DoctorController::class, 'showAppointmentDetail'])->name('doctor.appointment.detail');
    Route::post('/doctor/confirm-appointment/{id}', [DoctorController::class, 'confirmAppointment'])->name('doctor.confirm.appointment');
    Route::post('/doctor/cancel-appointment/{id}', [DoctorController::class, 'cancelAppointment'])->name('doctor.cancel.appointment');
});




Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/appointments/upcoming', [DoctorController::class, 'upcomingAppointments'])->name('doctor.appointments.upcoming');
    Route::get('/doctor/appointments/finished', [DoctorController::class, 'finishedAppointments'])->name('doctor.appointments.finished');
    Route::get('/doctor/appointments/unconfirmed', [DoctorController::class, 'unconfirmedAppointments'])->name('doctor.appointments.unconfirmed');
    Route::get('/doctor/appointments/follow-up', [DoctorController::class, 'followUpAppointments'])->name('doctor.appointments.follow-up');
    Route::get('/doctor/appointments/walk-in', [DoctorController::class, 'walkInAppointments'])->name('doctor.appointments.walk-in');
    Route::get('/doctor/appointments/cancelled', [DoctorController::class, 'cancelledAppointments'])->name('doctor.appointments.cancelled');
    Route::get('/doctor/appointments/unfinished', [DoctorController::class, 'unfinishedAppointments'])->name('doctor.appointments.unfinished');
});





Route::post('/patient/appointments/pay', [PatientPaymentController::class, 'pay'])
    ->name('patient.appointments.pay');
