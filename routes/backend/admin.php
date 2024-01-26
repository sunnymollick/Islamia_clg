<?php

use App\Http\Controllers\EducationalFeeController;
use App\Models\Transaction;

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Admin
Route::get('/profile', 'AdminController@profile')->name('profile');
Route::get('/edit_profile', 'AdminController@edit')->name('edit');
Route::patch('/edit_profile', 'AdminController@update')->name('update');
Route::get('/change_password', 'AdminController@change_password')->name('password_change');
Route::patch('/change_password', 'AdminController@update_password')->name('change_password');


/* ===== Blog Start =========== */

// Blog Controller
Route::resource('blogs', 'BlogController');
Route::get('/allBlogs', 'BlogController@getAll')->name('allBlogs');

/* ===== Blog End =========== */


/* ===== Access Management Start =========== */
Route::resource('users', 'UserController');
Route::get('/allUser', 'UserController@getAll')->name('allUser.users');
Route::get('/export', 'UserController@export')->name('export');

Route::resource('permissions', 'PermissionController');
Route::get('/allPermissions', 'PermissionController@getAll')->name('allPermissions');

Route::resource('roles', 'RoleController');
Route::get('/allRoles', 'RoleController@getAll')->name('allRoles');

/* ===== Settings Start =========== */

// Settings Controller
Route::resource('settings', 'SettingsController');
Route::get('/allSettings', 'SettingsController@getAll')->name('allSettings');

/* ===== Settings End =========== */

/* ===== Backup Start =========== */

Route::get('backups', 'BackupController@index');
Route::get('allBackups', 'BackupController@getAll')->name('allBackups');
Route::post('backups/db_backup', 'BackupController@db_backup');
Route::post('backups/full_backup', 'BackupController@full_backup');
Route::get('backups/download/{file_name}', 'BackupController@download');
Route::delete('backups/delete/{file_name}', 'BackupController@delete');

/* ===== Backup End =========== */


// Examples
// Examples

Route::get('/barcode', 'AdminController@barcode');
Route::get('/passport', 'AdminController@passport');



/* ===== Student Start =========== */

// Student Controller

Route::get('students/getStudents', 'StudentController@getStudents');
Route::get('students/smsCreate', 'StudentController@smsCreate');
Route::post('students/smsSend', 'StudentController@smsSend');

Route::resource('students', 'StudentController');

Route::post('/allStudents', 'StudentController@getAll')->name('allStudents');

Route::post('/allStudentsList', 'StudentController@getAllStudentList')->name('allStudentsList');

Route::post('/allStudentsForSubject', 'StudentController@allStudentsForSubject')->name('allStudentsForSubject');

Route::post('/allStudentsForOptionalSubject', 'StudentController@allStudentsForOptionalSubject')->name('allStudentsForOptionalSubject');

Route::get('/importStudents', 'StudentController@import')->name('importStudents.import');
Route::post('/importStudents', 'StudentController@importStore')->name('importStudents.import');

Route::post('/compulsorySubject', 'StudentController@compulsorySubject');


Route::get('/importStudentsImage', 'StudentController@importImages')->name('importStudentsImage.import');
Route::get('/selectCompulsorySubject', 'StudentController@selectCompulsorySubject')->name('selectCompulsorySubject');
Route::post('/insertStudentImages','StudentController@storeStudentImages');

Route::get('/getSection/{std_class_id}', 'StudentController@getSection')->name('getSection');
Route::get('/checkOptionalSubject/{std_class_id}', 'StudentController@checkOptionalSubject')->name('checkOptionalSubject');
// Route::get('/getAllSection/{class_id}', 'StudentController@getAllSection')->name('accounts');
Route::get('/std_change_password/{student_id}', 'StudentController@change_password')->name('std_change_password');
Route::patch('/std_change_password', 'StudentController@update_password')->name('std_change_password');
/* ===== Student End =========== */

// Staff Controller
Route::resource('staffs', 'StaffController');
Route::get('/allStaffs', 'StaffController@allStaffs')->name('allStaffs.staffs');


// Class Room Controller
Route::resource('classrooms', 'ClassRoomController');
Route::get('/allClassrooms', 'ClassRoomController@allClassrooms')->name('allClassrooms.classrooms');
/* ===== Class Room End =========== */

/* ===== Session Start =========== */

// Session Controller
Route::resource('sessions', 'SessionController');
Route::get('/allSessions', 'SessionController@getAll')->name('allSessions');

/* ===== Session End =========== */

/* ===== Class Start =========== */

// Class Controller
Route::resource('std_classes', 'StdClassController');
Route::get('/allStdClasses', 'StdClassController@getAll')->name('allStdClasses');

/* ===== Class End =========== */

// Online Application
Route::resource('admissionApplication', 'AdmissionApplicationController');
Route::get('/allApplications', 'AdmissionApplicationController@allApplications');
Route::get('/cancelledAdmissionApplicationList', 'AdmissionApplicationController@cancelledAdmissionApplicationList');
Route::get('/exportAdmissionStudentPdf', 'AdmissionApplicationController@exportAdmissionStudentPdf');
Route::get('/admissionApplicationSoftDelete/{admissionApplication}','AdmissionApplicationController@admissionApplicationSoftDelete');

Route::get('/cancelledAdmissionApplication', 'AdmissionApplicationController@cancelledAdmissionApplication');


/* ===== Section Start =========== */

// Section Controller
Route::get('sections/classes/{class}/getSections', 'SectionController@getSections')->name('getSections');

Route::get('sections/classes/{class}/getSectionsForSms', 'SectionController@getSectionsForSms')->name('getSectionsForSms');

Route::resource('sections', 'SectionController');
Route::get('/allSections', 'SectionController@getAll')->name('allSections');

Route::get('/getSections/{class_id}', 'SectionController@getSections')->name('getSections');

Route::get('/deleteSections/{section_array}/{subject_id}', 'SectionController@deleteSections');

/* ===== Section End =========== */

/* ===== Subject Start =========== */

// Subject Controller
Route::resource('subjects', 'SubjectController');
Route::post('/allSubjects', 'SubjectController@getAll')->name('allSubjects.subjects');
Route::get('/getSubjects/{class_id}', 'SubjectController@getSubjects')->name('getSubjects');
Route::get('/getOptionalSubjects/{class_id}', 'SubjectController@getSubjects')->name('getOptionalSubjects');

/* ===== Subject End =========== */

// Academic Calender Controller
Route::resource('academiccalenders', 'AcademicCalenderController');
Route::get('/allAcademicCalender', 'AcademicCalenderController@allAcademicCalender')->name('allAcademicCalender.calender');

// Event Controller
Route::resource('events', 'EventController');
Route::get('/allEvents', 'EventController@allEvents')->name('allEvents.events');
Route::get('/viewCalender', 'EventController@viewCalender')->name('viewCalender');


// Class Routine Controller
Route::resource('classroutines', 'ClassRoutineController');
Route::post('/getClassroutines', 'ClassRoutineController@getClassroutines')->name('getClassroutines');

// Syllabus Controller
Route::resource('syllabus', 'SyllabusController');
Route::post('/allSyllabus', 'SyllabusController@allSyllabus')->name('allSyllabus.syllabus');
/* ===== Teacher Start =========== */

// Teacher Controller
Route::get('teachers/smsCreate', 'TeacherController@smsCreate')->name('teachers.smsCreate');
Route::post('/teachers/smsSend', 'TeacherController@smsSend')->name('teachers.smsSend');
Route::resource('teachers', 'TeacherController');
Route::get('/allTeachers', 'TeacherController@getAll')->name('allTeachers');
Route::get('/importTeachers', 'TeacherController@import')->name('importTeachers.import');
Route::post('/importTeachers', 'TeacherController@importStore')->name('importTeachers.import');
/* ===== Teacher End =========== */


Route::get('tests/smsCreate', 'TestController@smsCreate');
Route::post('tests/smsSend', 'TestController@smsSend');
Route::resource('tests', 'TestController');

Route::get('/allTests', 'TestController@getAll')->name('allTests');
// Test Controller end

/* ===== Promotion Start =========== */

// Promotion Controller
// Route::resource('promotions', 'PromotionController');
// Route::get('/allPromotions', 'PromotionController@getAll')->name('allPromotions');
Route::get('/importPromotions', 'PromotionController@import')->name('importPromotions.import');
Route::post('/importPromotions', 'PromotionController@importStore')->name('importPromotions.import');
/* ===== Promotion End =========== */


/* ===== Exam Start =========== */

// Exam Controller
Route::resource('exams', 'ExamController');
Route::post('/allExams', 'ExamController@getAll')->name('allExams');
Route::get('/getExams/{class_id}', 'ExamController@getExams')->name('exams');
// Route::get('/assignExaminee', 'ExamController@assignExaminee')->name('exams');
// Route::get('/allAssignedExaminee', 'ExamController@allAssignedExaminee')->name('allAssignedExaminee.exams');

/* ===== Exam End =========== */

// Attendance Controller
Route::resource('attendancestudents','AttendanceStudentController');
Route::get('importStdAttendance','AttendanceStudentController@importStdAttendance');
Route::post('/importStdattendances', 'AttendanceStudentController@importStdattendancesProcess')->name('attendance');

Route::get('getAllStudentsForAttendance','AttendanceStudentController@getAllStudentForAttendance');
Route::get('studentDailyAttendanceReport', 'AttendanceStudentController@studentDailyAttendanceReport');
Route::post('studentDailyAttendanceReport', 'AttendanceStudentController@getStudentDailyAttendanceReport');


// Teacher Attendance Controller
Route::resource('attendanceteachers', 'AttendanceTeacherController');
Route::get('importTeacherattendances', 'AttendanceTeacherController@importTeacherAttendance');
Route::post('importTeacherattendances', 'AttendanceTeacherController@importTeacherAttendanceProcess');
Route::get('teacherDailyAttendanceReport', 'AttendanceTeacherController@teacherDailyAttendanceReport');
Route::post('teacherDailyAttendanceReport', 'AttendanceTeacherController@getTeacherDailyAttendanceReport');


/* ===== Parent Start =========== */

// Parent Controller
Route::resource('std_parents', 'StdParentController');
Route::get('/allStdParents', 'StdParentController@getAll')->name('allParents');
Route::get('/importStdParents', 'StdParentController@import')->name('importStdParents.import');
Route::post('/importStdParents', 'StdParentController@importStore')->name('importStdParents.import');
/* ===== Parent End =========== */

/* ===== Marks Start =========== */
// Marks Controller
Route::resource('marks', 'MarkController');
Route::post('/getMarks', 'MarkController@getMarks')->name('getMarks');
Route::get('/importMarks', 'MarkController@import')->name('importMarks.import');
Route::post('/importMarks', 'MarkController@importStore')->name('importMarks.import');
Route::get('/exportExcelMarks', 'MarkController@exportExcelMarks')->name('exportExcelMarks');
Route::get('/exportPdfMarks', 'MarkController@exportPdfMarks')->name('exportPdfMarks');

Route::get('/getExam/{std_class_id}', 'MarkController@getExam')->name('getExam');
Route::get('/getSubject/{std_class_id}', 'MarkController@getSubject')->name('getSubject');
/* ===== Marks End =========== */


// Marksheet 6, 7, 8 half yearly exam
Route::get('/jrhalfYearlyExam', 'MarkSheetController@jrhalfYearlyExamSummery');
Route::post('/jrhalfSummeryResult', 'MarkSheetController@jrhalfSummeryResult');
Route::post('/jrhalfExamMarksheet', 'MarkSheetController@jrhalfExamMarksheet');

// Marksheet 9, 10
Route::get('/srResult', 'MarkSheetController@srResult');
Route::get('/srResultPublish', 'MarkSheetController@srResultPublish');
Route::post('/srSummeryResult', 'MarkSheetController@srSummeryResult');
Route::post('/srSummeryResultPublish', 'MarkSheetController@srSummeryResultPublish');
Route::post('/srMarksheet', 'MarkSheetController@srMarksheet');
Route::post('/srTranscript', 'MarkSheetController@srTranscript');

// Test Result Route
Route::get('testResult','MarkSheetController@testResult');


Route::get('/jrfullMarksheet', 'MarkSheetController@jrfullMarksheet')->name('jrfullMarksheet');
Route::post('/jrfinalSummeryResult', 'MarkSheetController@jrfinalSummeryResult')->name('jrfinalSummeryResult');
Route::post('/jrfinalMarksheet', 'MarkSheetController@jrfinalMarksheet')->name('jrfinalMarksheet');


Route::get('/srfullMarksheet', 'MarkSheetController@srfullMarksheet')->name('srfullMarksheet');
Route::post('/srfinalSummeryResult', 'MarkSheetController@srfinalSummeryResult')->name('srfinalSummeryResult');
Route::post('/srfinalMarksheet', 'MarkSheetController@srfinalMarksheet')->name('srfinalMarksheet');


// TabulationSheet Controller
Route::resource('tabulations', 'TabulationSheetController');
Route::post('/summeryResult', 'TabulationSheetController@summeryResult')->name('summeryResult');
Route::post('/viewMarksheet', 'TabulationSheetController@viewMarksheet')->name('viewMarksheet');


// admit card routes
Route::get('/admitCard', 'ExamController@admitCard')->name('exams');
Route::get('/generateAdmitCard', 'ExamController@generateAdmitCard')->name('exams');
Route::get('/getAllStudents', 'StudentController@getAllStudents')->name('students');

// Certificates routes
Route::resource('certificates', 'CertificateController');

// Seat Plan routes
Route::get('/seatPlan', 'ExamController@seatPlan')->name('seatPlan');
Route::get('/generateSeatPlan', 'ExamController@generateSeatPlan')->name('generateSeatPlan');

/* ===== Frontend Start =========== */
// Notice Board & Lateset News Controller
Route::resource('pages', 'PageController');
Route::get('/allPages', 'PageController@allPages')->name('allPages.pages');


// Notice Board & Lateset News Controller
Route::resource('news', 'NewsController');
Route::get('/allNews', 'NewsController@allNews')->name('allNews.news');

// Slider Controller
Route::resource('sliders', 'SliderController');
Route::get('/allSliders', 'SliderController@allSliders')->name('allSliders.sliders');

// Download Controller
Route::resource('downloads', 'DownloadController');
Route::get('/allDownloads', 'DownloadController@allDownloads')->name('allDownloads.downloads');


// Gallery Controller
Route::resource('galleries', 'GalleryController');
Route::get('/allGalleries', 'GalleryController@allGalleries')->name('allGalleries.galleries');



// QrCode Routes
Route::get('/qrcode/{id}','QrCodeController@index');
Route::get('/student-info/{id}','QrCodeController@getInfo');

// Barcode Routes
Route::get('/barcode/{id}','BarcodeController@index')->name('home.index');

// Income head 
Route::resource('income-heads', 'IncomeHeadController');


// Expenses Head
Route::resource('expenses-heads', 'ExpensesHeadController');

// Assign eductanal_fees
Route::resource('educational-fees', 'EducationalFeeController');

// Assign bill for students

Route::delete('bills/billDetails', 'BillController@bilDetailsDestroy');
Route::resource('bills', 'BillController');
Route::post('bills/{bill}', 'BillController@update');
Route::get('allBills', 'BillController@allBills')->name('allBills');
Route::put('billDetails/{billDetail}', 'BillController@updateBillDetails');

Route::get('massBills/index', 'MassBIllController@index');
Route::resource('transactions', 'TransactionController');
Route::get('transactions/{transaction}', 'TransactionController@makeInvoice')->name('transactions.makeInvoice');
Route::get('allTransactions', 'TransactionController@allTransactions')->name('allTransactions');



