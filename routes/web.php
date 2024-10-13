<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\teacherController;
use App\Http\Controllers\adminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'login'])->name('login-user');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// STUDENT CONTROLLER
Route::get('/studentMain', [studentController::class, 'showStudentMain'])->name('studentMain');
Route::get('/studentMain/{program}', [studentController::class, 'showProgram']);
Route::get('/studentProfile', [studentController::class, 'showStudentProfile'])->name('studentProfile');
Route::get('/studentResult', [studentController::class, 'showStudentResult'])->name('studentResult');
Route::get('/studentResult/result/{studentId}/{examType}', [studentController::class, 'result'])->name('result');


// TEACHER CONTROLLER
Route::get('/teacherMain', [teacherController::class, 'showTeacherMain'])->name('teacherMain');
Route::get('/marks', [teacherController::class, 'showTeacherMarks'])->name('teacher-marks');
Route::get('/marks/{studentId}', [teacherController::class, 'selectMarkStudent']);
Route::get('/teacherProfile', [teacherController::class, 'showTeacherProfile'])->name('teacher-profile');
Route::get('/studentOfClass/{classid}', [teacherController::class, 'showStudentOfClass'])->name('studentOfClass');

Route::post('/submit/{subjectCode}', [teacherController::class, 'submitMark'])->name('submit-mark');


// ADMIN CONTROLLER
Route::get('/adminMain', [adminController::class, 'showAdminMain'])->name('adminMain');
Route::get('/adminMain/{program}', [adminController::class, 'showAdminProgram']);
Route::get('/adminProfile', [adminController::class, 'showAdminProfile'])->name('admin-profile');
Route::post('/adminProfile/edit/{adminId}', [adminController::class, 'editProfileAdmin'])->name('edit-admin-profile');
Route::get('/showStudentOfClassAdmin/{classid}', [adminController::class, 'showStudentOfClass'])->name('showStudentOfClass-admin');

// CLASS
Route::get('/manageClass', [adminController::class, 'showManageClass'])->name('manageClass');
Route::post('/editClass/{classCode}', [adminController::class, 'editClass'])->name('edit-class');

// render manage student
Route::get('/manageStudent', [adminController::class, 'showManageStudent'])->name('manageStudent');
// ADD student
Route::post('/addStudent', [adminController::class, 'addStudent'])->name('add-student');
// EDIT STUDENT
Route::get('/edit/student/{studentIc}', [adminController::class, 'editStudent'])->name('edit-student');
Route::post('/update/student/{studentIc}', [adminController::class, 'updateStudent'])->name('update-student');

// EDIT TECHER
Route::get('/edit/teacher/{teacheric}', [adminController::class, 'editTeacher'])->name('edit-teacher');
Route::post('/update/teacher/{teacheric}', [adminController::class, 'updateTeacher'])->name('update-teacher');



// render manage teacher
Route::get('/manageTeacher', [adminController::class, 'showManageTeacher'])->name('manageTeacher');
// add teacher
Route::post('/addTeacher', [adminController::class, 'addTeacher'])->name('add-teacher');
