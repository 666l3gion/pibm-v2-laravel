<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassStudentController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MajorSubjectController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectTeacherController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Models\ClassTeacher;
use App\Models\Clazss;
use App\Models\Question;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('/')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::resource('/users', UserController::class)->only(['edit', 'update'])->middleware('can:update,user');
    });

    // hanya bisa diakses oleh superadmin
    Route::middleware(['role:superadmin'])->group(function () {
        Route::prefix('/')->name('dashboard.')->group(function () {
            Route::resource('/users', UserController::class)->only(['index', 'destroy']);
        });
    });

    // hanya bisa diakses oleh superadmin dan admin
    Route::middleware(['role:superadmin,admin'])->group(function () {

        Route::prefix('/master')->name('master.')->group(function () {
            Route::resource('/teachers', TeacherController::class)->except('show');
            Route::post('/teachers/active/{teacher}', [TeacherController::class, 'active'])->name('teachers.active');

            Route::resource('/students', StudentController::class)->except('show');
            Route::post('/students/active/{student}', [StudentController::class, 'active'])->name('students.active');

            Route::resource('/majors', MajorController::class)->except('show');
            Route::resource('/classes', ClassController::class)->except('show');
            Route::resource('/subjects', SubjectController::class)->except('show');
        });

        Route::prefix('/relations')->name('relations.')->group(function () {
            // fix class-teacher always load Teacher explicit model binding in app\Providers\RouteServiceProvider.php
            Route::model('class-teacher', Teacher::class);
            Route::resource('/class-teacher', ClassTeacherController::class)->except('show');

            Route::model('class-student', Clazss::class);
            Route::resource('/class-student', ClassStudentController::class)->except('show');

            Route::model('major-subject', Subject::class);
            Route::resource('/major-subject', MajorSubjectController::class)->except('show');

            Route::model('subject-teacher', Teacher::class);
            Route::resource('/subject-teacher', SubjectTeacherController::class)->except('show');
        });

        Route::resource('/exam-types', ExamTypeController::class)->except('show');
    });

    Route::middleware(['role:guru,siswa'])->group(function () {
        Route::resource('/exams', ExamController::class);
    });

    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/exams/{exam}/sheet', [ExamController::class, 'sheet'])->name('exams.sheet');
        Route::post('/exams/{exam}/save-one', [ExamController::class, 'saveOneQuestion'])->name('exams.save-one-question');
        Route::post('/exams/{exam}/save', [ExamController::class, 'saveExam'])->name('exams.save-exam');
        Route::get('/exams/{exam}/result', [ExamController::class, 'result'])->name('exams.result');
    });

    Route::middleware(['role:superadmin,admin,guru'])->group(function () {
        Route::resource('/questions', QuestionController::class);
        Route::get('/exams/{exam}/save', [ExamController::class, 'saveExam'])->name('exams.save-exam');
    });

    // auth
    Route::put('/change-password', [AuthController::class, 'changePassword'])->name('auth.change-password');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    // auth
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});
