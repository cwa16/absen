<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsenManualController;
use App\Http\Controllers\AbsenRegulerController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardCutiController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\SummaryRegController;
use App\Http\Controllers\SummaryPerDeptController;
use App\Http\Controllers\SummaryPerDeptRegController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilterDashboardController;
use App\Http\Controllers\MandorController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\MedicalCheckController;
use App\Http\Controllers\DrugTestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterAbsenController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\SummaryCutiController;
use App\Http\Controllers\SummaryPerKategoriController;
use App\Http\Controllers\TestingAbsenController;
use App\Http\Controllers\DashboardAllController;
use App\Http\Controllers\MasterShiftController;
use App\Http\Controllers\HolidaysNewController;

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    // Dashboard Admin
    Route::get('/dashboard-regular-admin', [DashboardAdminController::class, 'index'])->name('dashboard-regular-admin');

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-regular', [AdminController::class, 'indexRegular'])->name('dashboard-regular');
    Route::get('/attendance', [AdminController::class, 'attendance'])->name('attendance');
    Route::get('/attendance-input', [AdminController::class, 'attendance_input'])->name('attendance-input');
    Route::get('/attendance-now', [AdminController::class, 'attendance_now'])->name('attendance-now');
    Route::get('/attendance-approval', [AdminController::class, 'index_approval'])->name('attendance-approval');
    Route::get('/attendance-checked', [AdminController::class, 'index_checked'])->name('attendance-checked');
    Route::post('edit-hrd', [AdminController::class, 'edit_hrd']);
    Route::post('show-att', [AdminController::class, 'show_att']);
    Route::post('show-att-start', [AdminController::class, 'show_att_start']);
    Route::post('update-att', [AdminController::class, 'update_att']);
    Route::post('update-approve-batch', [AdminController::class, 'update_approve_batch'])->name('update-approve-batch');
    Route::post('update-unapprove-batch', [AdminController::class, 'update_unapprove_batch'])->name('update-unapprove-batch');
    Route::get('/attendance-summary', [AdminController::class, 'index_summary'])->name('attendance-summary');
    Route::post('/update-approval/{id}', [AdminController::class, 'update_approve'])->name('update-approval');
    Route::post('/update-approved/{id}', [AdminController::class, 'update_approved'])->name('update-approved');
    Route::post('/update-checked/{id}', [AdminController::class, 'update_checked'])->name('update-checked');
    Route::post('/update-unchecked/{id}', [AdminController::class, 'update_unchecked'])->name('update-unchecked');

    Route::get('/add-emp', [AdminController::class, 'add_emp'])->name('add-emp');
    Route::post('store-emp', [AdminController::class, 'store_emp'])->name('store-emp');
    Route::post('update-emp', [AdminController::class, 'update_emp'])->name('update-emp');
    Route::post('delete-emp', [AdminController::class, 'delete_emp'])->name('delete-emp');

    Route::get('/view-emp/{id}', [AdminController::class, 'view_emp'])->name('view-emp');
    Route::get('/edit-emp/{id}', [AdminController::class, 'edit_emp'])->name('edit-emp');

    Route::get('/master-employee', [AdminController::class, 'master_employee'])->name('master-employee');
    Route::get('absen-export', [AdminController::class, 'export'])->name('absen-export');

    Route::get('/summary-per-emp', [SummaryController::class, 'index'])->name('summary-per-emp');
    Route::get('/view-summary-emp/{id}', [SummaryController::class, 'view'])->name('view-summary-emp');
    Route::post('/view-summary-emp-filter', [SummaryController::class, 'view_filter'])->name('view-summary-emp-filter');

    Route::get('/summary-per-dept', [SummaryPerDeptController::class, 'index'])->name('summary-per-dept');
    Route::get('/summary-per-dept-new', [SummaryPerDeptController::class, 'index_new'])->name('view-summary-shift-testing');
    Route::post('/summary-per-dept-filter', [SummaryPerDeptController::class, 'index_filter'])->name('summary-per-dept-filter');

    Route::get('/input-manual', [AbsenManualController::class, 'index'])->name('input-manual');
    Route::get('/data-user', [AbsenManualController::class, 'fetchData'])->name('data-user');
    Route::post('/store-absen', [AbsenManualController::class, 'store'])->name('store-absen');

    Route::get('/absen-regular', [AbsenRegulerController::class, 'index_reg'])->name('absen-regular');
    Route::get('/attendance-reg', [AbsenRegulerController::class, 'attendance_reg'])->name('attendance-reg');
    Route::post('/store-absen-reg', [AbsenRegulerController::class, 'store'])->name('store-absen-reg');
    Route::get('/input-manual-reg', [AbsenRegulerController::class, 'index'])->name('input-manual-reg');
    Route::get('/absen-regular-import', [AbsenRegulerController::class, 'index_reg_import'])->name('absen-regular-import');

    Route::post('/import-absen-reg', [AbsenRegulerController::class, 'import_excel'])->name('import-excel');
    Route::post('/delete-absen-reg', [AbsenRegulerController::class, 'delete'])->name('delete-import');

    Route::post('store-import', [AbsenRegulerController::class, 'store_import'])->name('store-import');

    // User Controller
    Route::get('/user-master', [UserController::class, 'index'])->name('user-master');
    Route::get('/user-master-input', [UserController::class, 'index_input'])->name('user-master-input');
    Route::post('/update-user', [UserController::class, 'store_user'])->name('update-user');
    Route::post('/edits-user', [UserController::class, 'update_user'])->name('edits-user');
    Route::get('/edit-user/{id}', [UserController::class, 'edit_user'])->name('edit-user');
    Route::post('import-user', [UserController::class, 'import_excel'])->name('user-import');

    // Master Absensi
    Route::get('/master-absen', [MasterAbsenController::class, 'index'])->name('master-absen');
    Route::post('master-absen-view', [MasterAbsenController::class, 'view'])->name('master-absen-view');
    // Route::get('/master-absen-view/{date?}/{dept?}', [MasterAbsenController::class, 'view'])->name('master-absen-view');
    Route::post('master-absen-delete', [MasterAbsenController::class, 'delete'])->name('master-absen-delete');
    Route::get('master-absen-delete/{id}', [MasterAbsenController::class, 'deleteItem'])->name('master-absen-delete-item');
    Route::post('master-absen-update', [MasterAbsenController::class, 'update'])->name('master-absen-update');

    // Summary Reg
    Route::get('/summary-reg', [SummaryRegController::class, 'index'])->name('summary-reg');
    Route::get('/view-summary-emp-reg/{nik}', [SummaryRegController::class, 'view'])->name('view-summary-emp-reg');
    Route::post('/view-summary-emp-filter-reg', [SummaryRegController::class, 'view_filter'])->name('view-summary-emp-filter-reg');

    // Summary per dept Reg
    Route::get('/summary-per-dept-reg', [SummaryPerDeptRegController::class, 'index'])->name('summary-per-dept-reg');
    Route::get('/summary-per-dept-reg-new', [SummaryPerDeptRegController::class, 'index_new'])->name('summary-per-dept-reg-new');
    Route::post('/summary-per-dept-filter-reg', [SummaryPerDeptRegController::class, 'index_filter'])->name('summary-per-dept-filter-reg');
    Route::post('/summary-per-dept-filter-reg-new', [SummaryPerDeptRegController::class, 'index_filter_new'])->name('summary-per-dept-filter-reg-new');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

    // Summary Cuti
    Route::get('/summary-cuti', [SummaryCutiController::class, 'index'])->name('summary-cuti');
    Route::post('load-summary-cuti', [SummaryCutiController::class, 'loadSummaryCuti'])->name('load-summary-cuti');

    // Summary kehadiran per kategori
    Route::get('/summary-kategori', [SummaryPerKategoriController::class, 'index'])->name('summary-kategori');
    Route::post('load-summary-kategori', [SummaryPerKategoriController::class, 'loadSummaryKategori'])->name('load-summary-kategori');
    // chart
    Route::get('/chart-monthly', [ChartController::class, 'chart_monthly']);

    // cuti
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti');
    Route::get('/print/{id}', [CutiController::class, 'print'])->name('print');
    Route::post('check-holiday', [CutiController::class, 'holidayCheck'])->name('check-holiday');

    Route::get('/input-cuti/{nik}', [CutiController::class, 'input_cuti_new'])->name('input-cuti');
    Route::get('/list-emp', [CutiController::class, 'list_emp'])->name('list-emp');

    Route::post('store-cuti', [CutiController::class, 'store'])->name('store-cuti');
    Route::post('update-cuti', [CutiController::class, 'update'])->name('update-cuti');
    Route::post('/delete-cuti/{id}', [CutiController::class, 'delete'])->name('delete-cuti');
    Route::get('/edit-cuti/{id}', [CutiController::class, 'input_cuti_edit'])->name('edit-cuti');

    Route::get('/budget-cuti', [CutiController::class, 'budgetCuti'])->name('budget-cuti');
    Route::post('/budget-cuti-search', [CutiController::class, 'budgetCutiSearch'])->name('budget-cuti-search');
    Route::get('/budget-cuti-new', [CutiController::class, 'inputBudgetCuti'])->name('budget-cuti-new');
    Route::post('store-budget-cuti', [CutiController::class, 'storeBudgetCuti'])->name('store-budget-cuti');
    Route::post('/import-budget-cuti', [CutiController::class, 'import_excel'])->name('import-excel-budget-cuti');

    // Kemandoran
    Route::get('/kemandoran', [MandorController::class, 'index'])->name('kemandoran');
    Route::post('import-kemandoran', [MandorController::class, 'import_excel'])->name('import-kemandoran');
    Route::get('/input-mandor', [MandorController::class, 'inputMandor'])->name('input-mandor');
    Route::post('store-mandor', [MandorController::class, 'storeMandor'])->name('store-mandor');
    Route::post('delete-mandor', [MandorController::class, 'deleteMandor'])->name('delete-mandor');

    // Filter Dashboard
    Route::post('filter-todate', [FilterDashboardController::class, 'filterTodateAtt'])->name('filter-todate');

    // Dashboard Cuti
    Route::get('/dashboard-cuti', [DashboardCutiController::class, 'index'])->name('dashboard-cuti');
    Route::post('dashboard-cuti', [DashboardCutiController::class, 'find'])->name('find-cuti');

    // Holiday
    Route::get('/hari-libur', [HolidayController::class, 'index'])->name('holiday');
    Route::post('simpan', [HolidayController::class, 'store'])->name('store-holiday');
    Route::post('hapus', [HolidayController::class, 'delete'])->name('delete-holiday');

  // Training
  Route::get('/master-training', [TrainingController::class, 'index'])->name('master-training');
  Route::get('/training-att', [TrainingController::class, 'trainingAtt'])->name('training-att');
  Route::post('store-training', [TrainingController::class, 'store'])->name('store-training');
  Route::post('update-training', [TrainingController::class, 'update'])->name('update-training');
  Route::get('delete-training/{id}', [TrainingController::class, 'delete'])->name('delete-training');
  Route::get('delete-training-item/{id_data}/{nik}', [TrainingController::class, 'delete_item'])->name('delete-training-item');
  Route::get('/training-detail/{no}', [TrainingController::class, 'view'])->name('detail-training');
  Route::get('/master-training-emp', [TrainingController::class, 'indexEmp'])->name('master-training-emp');
  Route::get('/training-detail-emp/{nik}', [TrainingController::class, 'viewEmp'])->name('detail-training-emp');
  Route::get('/training-choose', [TrainingController::class, 'chooseDept'])->name('chooseDept');
  Route::post('training-choose', [TrainingController::class, 'loadDept'])->name('loadDept');
  Route::post('select-emp', [TrainingController::class, 'select_emp'])->name('select-emp');
  Route::post('select-cat', [TrainingController::class, 'select_training'])->name('select-cat');
  Route::get('/edit-training/{id}', [TrainingController::class, 'edit'])->name('edit-training');
  Route::get('/print-training/{id}', [TrainingController::class, 'print'])->name('print-training');
  Route::get('/summary-actual-training', [TrainingController::class, 'summary_actual_training'])->name('summary-actual-training');
  Route::get('/data-detail-training', [TrainingController::class, 'detail_training'])->name('data-detail-training');
  Route::post('/data-detail-training-filter', [TrainingController::class, 'filter_detail_training'])->name('filter-data-detail-training');
  Route::post('/data-detail-training-filter-jquery', [TrainingController::class, 'filter_detail_training_jquery'])->name('filter-data-detail-training-jquery');
  Route::get('/data-training-import', [TrainingController::class, 'index_import'])->name('training-import');
  Route::post('/import-judul-training', [TrainingController::class, 'import_excel_judul'])->name('import-excel-judul');
  Route::post('/import-peserta-training', [TrainingController::class, 'import_excel_peserta'])->name('import-excel-peserta');

  // Medical
  Route::get('/medical', [MedicalCheckController::class, 'index'])->name('medical');
  Route::post('store-medical', [MedicalCheckController::class, 'store'])->name('store-medical');
  Route::get('/add-medical/{id}', [MedicalCheckController::class, 'add'])->name('add-medical-input');
  Route::post('store-medical-input', [MedicalCheckController::class, 'storeInput'])->name('store-medical-input');
  Route::get('/view-medical/{id}', [MedicalCheckController::class, 'view'])->name('medical-view');

    // Training
    Route::get('/master-training', [TrainingController::class, 'index'])->name('master-training');
    Route::get('/training-att', [TrainingController::class, 'trainingAtt'])->name('training-att');
    Route::post('store-training', [TrainingController::class, 'store'])->name('store-training');
    Route::post('update-training', [TrainingController::class, 'update'])->name('update-training');
    Route::get('delete-training/{id}', [TrainingController::class, 'delete'])->name('delete-training');
    Route::get('delete-training-item/{id_data}/{nik}', [TrainingController::class, 'delete_item'])->name('delete-training-item');
    Route::get('/training-detail/{no}', [TrainingController::class, 'view'])->name('detail-training');
    Route::get('/master-training-emp', [TrainingController::class, 'indexEmp'])->name('master-training-emp');
    Route::get('/training-detail-emp/{nik}', [TrainingController::class, 'viewEmp'])->name('detail-training-emp');
    Route::get('/training-choose', [TrainingController::class, 'chooseDept'])->name('chooseDept');
    Route::post('training-choose', [TrainingController::class, 'loadDept'])->name('loadDept');
    Route::post('select-emp', [TrainingController::class, 'select_emp'])->name('select-emp');
    Route::post('select-cat', [TrainingController::class, 'select_training'])->name('select-cat');
    Route::get('/edit-training/{id}', [TrainingController::class, 'edit'])->name('edit-training');
    Route::get('/print-training/{id}', [TrainingController::class, 'print'])->name('print-training');
    Route::get('/summary-actual-training', [TrainingController::class, 'summary_actual_training'])->name('summary-actual-training');
    Route::get('/data-detail-training', [TrainingController::class, 'detail_training'])->name('data-detail-training');
    Route::post('/data-detail-training-filter', [TrainingController::class, 'filter_detail_training'])->name('filter-data-detail-training');
    Route::post('/data-detail-training-filter-jquery', [TrainingController::class, 'filter_detail_training_jquery'])->name('filter-data-detail-training-jquery');

    // Medical
    Route::get('/medical', [MedicalCheckController::class, 'index'])->name('medical');
    Route::post('store-medical', [MedicalCheckController::class, 'store'])->name('store-medical');
    Route::get('/index-add/{id}', [MedicalCheckController::class, 'indexAdd'])->name('add-medical');
    Route::post('store-medical-input', [MedicalCheckController::class, 'storeInput'])->name('store-medical-input');


    // Drug
    Route::get('/drug', [DrugTestController::class, 'index'])->name('drug');
    Route::post('store-drug', [DrugTestController::class, 'store'])->name('store-drug');
    Route::get('/index-add/{id}', [DrugTestController::class, 'indexAdd'])->name('add-drug');
    Route::post('store-drug-input', [DrugTestController::class, 'storeInput'])->name('store-drug-input');

    // Testing attedance
    Route::get('/testing', [TestingAbsenController::class, 'index'])->name('testing.index');
    Route::post('/tetsing-update', [TestingAbsenController::class, 'update'])->name('testing.update');
    Route::get('/dash_testing', [TestingAbsenController::class, 'testing_dash'])->name('testing.dash');
    Route::get('/testing/data', [TestingAbsenController::class, 'getData'])->name('testing.data');
    Route::get('/get-date-data', [TestingAbsenController::class, 'getDateData'])->name('get-date-data');

    // Chart
    Route::get('/get-chart-data', [TestingAbsenController::class, 'getChartData'])->name('get-chart-data');

    //log-viewers
    Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

    // Dashboard Admin
    Route::get('/dashboard-regular-admin', [DashboardAdminController::class, 'index'])->name('dashboard-regular-admin');
    //

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-regular', [AdminController::class, 'indexRegular'])->name('dashboard-regular');
    Route::get('/attendance', [AdminController::class, 'attendance'])->name('attendance');
    Route::get('/attendance-input', [AdminController::class, 'attendance_input'])->name('attendance-input');
    Route::get('/attendance-now', [AdminController::class, 'attendance_now'])->name('attendance-now');
    Route::get('/attendance-approval', [AdminController::class, 'index_approval'])->name('attendance-approval');
    Route::get('/attendance-checked', [AdminController::class, 'index_checked'])->name('attendance-checked');
    Route::post('edit-hrd', [AdminController::class, 'edit_hrd']);
    Route::post('show-att', [AdminController::class, 'show_att']);
    Route::post('show-att-start', [AdminController::class, 'show_att_start']);
    Route::post('update-att', [AdminController::class, 'update_att']);
    Route::post('update-approve-batch', [AdminController::class, 'update_approve_batch'])->name('update-approve-batch');
    Route::post('update-unapprove-batch', [AdminController::class, 'update_unapprove_batch'])->name('update-unapprove-batch');
    Route::get('/attendance-summary', [AdminController::class, 'index_summary'])->name('attendance-summary');
    Route::post('/update-approval/{id}', [AdminController::class, 'update_approve'])->name('update-approval');
    Route::post('/update-approved/{id}', [AdminController::class, 'update_approved'])->name('update-approved');
    Route::post('/update-checked/{id}', [AdminController::class, 'update_checked'])->name('update-checked');
    Route::post('/update-unchecked/{id}', [AdminController::class, 'update_unchecked'])->name('update-unchecked');

    Route::get('/add-emp', [AdminController::class, 'add_emp'])->name('add-emp');
    Route::post('store-emp', [AdminController::class, 'store_emp'])->name('store-emp');
    Route::post('update-emp', [AdminController::class, 'update_emp'])->name('update-emp');
    Route::post('delete-emp', [AdminController::class, 'delete_emp'])->name('delete-emp');

    Route::get('/view-emp/{id}', [AdminController::class, 'view_emp'])->name('view-emp');
    Route::get('/edit-emp/{id}', [AdminController::class, 'edit_emp'])->name('edit-emp');

    Route::get('/master-employee', [AdminController::class, 'master_employee'])->name('master-employee');
    Route::get('absen-export', [AdminController::class, 'export'])->name('absen-export');

    Route::get('/summary-per-emp', [SummaryController::class, 'index'])->name('summary-per-emp');
    Route::get('/view-summary-emp/{id}', [SummaryController::class, 'view'])->name('view-summary-emp');
    Route::post('/view-summary-emp-filter', [SummaryController::class, 'view_filter'])->name('view-summary-emp-filter');

    Route::get('/summary-per-dept', [SummaryPerDeptController::class, 'index'])->name('summary-per-dept');
    Route::post('/summary-per-dept-filter', [SummaryPerDeptController::class, 'index_filter'])->name('summary-per-dept-filter');

    Route::get('/input-manual', [AbsenManualController::class, 'index'])->name('input-manual');
    Route::get('/data-user', [AbsenManualController::class, 'fetchData'])->name('data-user');
    Route::post('/store-absen', [AbsenManualController::class, 'store'])->name('store-absen');

    Route::get('/absen-regular', [AbsenRegulerController::class, 'index_reg'])->name('absen-regular');
    Route::get('/attendance-reg', [AbsenRegulerController::class, 'attendance_reg'])->name('attendance-reg');
    Route::post('/store-absen-reg', [AbsenRegulerController::class, 'store'])->name('store-absen-reg');
    Route::get('/input-manual-reg', [AbsenRegulerController::class, 'index'])->name('input-manual-reg');
    Route::get('/absen-regular-import', [AbsenRegulerController::class, 'index_reg_import'])->name('absen-regular-import');

    Route::post('/import-absen-reg', [AbsenRegulerController::class, 'import_excel'])->name('import-excel');
    Route::post('/delete-absen-reg', [AbsenRegulerController::class, 'delete'])->name('delete-import');

    Route::post('store-import', [AbsenRegulerController::class, 'store_import'])->name('store-import');

    // User Controller
    Route::get('/user-master', [UserController::class, 'index'])->name('user-master');
    Route::get('/user-master-input', [UserController::class, 'index_input'])->name('user-master-input');
    Route::post('/update-user', [UserController::class, 'store_user'])->name('update-user');
    Route::post('/edits-user', [UserController::class, 'update_user'])->name('edits-user');
    Route::get('/edit-user/{id}', [UserController::class, 'edit_user'])->name('edit-user');
    Route::post('import-user', [UserController::class, 'import_excel'])->name('user-import');

    // Master Absensi
    Route::get('/master-absen', [MasterAbsenController::class, 'index'])->name('master-absen');
    Route::post('master-absen-view', [MasterAbsenController::class, 'view'])->name('master-absen-view');
    // Route::get('/master-absen-view/{date?}/{dept?}', [MasterAbsenController::class, 'view'])->name('master-absen-view');
    Route::post('master-absen-delete', [MasterAbsenController::class, 'delete'])->name('master-absen-delete');
    Route::get('master-absen-delete/{id}', [MasterAbsenController::class, 'deleteItem'])->name('master-absen-delete-item');
    Route::post('master-absen-update', [MasterAbsenController::class, 'update'])->name('master-absen-update');

    // Summary Reg
    Route::get('/summary-reg', [SummaryRegController::class, 'index'])->name('summary-reg');
    Route::get('/view-summary-emp-reg/{nik}', [SummaryRegController::class, 'view'])->name('view-summary-emp-reg');
    Route::post('/view-summary-emp-filter-reg', [SummaryRegController::class, 'view_filter'])->name('view-summary-emp-filter-reg');

    // Summary per dept Reg
    Route::get('/summary-per-dept-reg', [SummaryPerDeptRegController::class, 'index'])->name('summary-per-dept-reg');
    Route::post('/summary-per-dept-filter-reg', [SummaryPerDeptRegController::class, 'index_filter'])->name('summary-per-dept-filter-reg');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

    // Summary Cuti
    Route::get('/summary-cuti', [SummaryCutiController::class, 'index'])->name('summary-cuti');
    Route::post('load-summary-cuti', [SummaryCutiController::class, 'loadSummaryCuti'])->name('load-summary-cuti');

    // Summary kehadiran per kategori
    Route::get('/summary-kategori', [SummaryPerKategoriController::class, 'index'])->name('summary-kategori');
    Route::post('load-summary-kategori', [SummaryPerKategoriController::class, 'loadSummaryKategori'])->name('load-summary-kategori');
    // chart
    Route::get('/chart-monthly', [ChartController::class, 'chart_monthly']);

    // cuti
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti');
    Route::get('/print/{id}', [CutiController::class, 'print'])->name('print');
    Route::post('check-holiday', [CutiController::class, 'holidayCheck'])->name('check-holiday');

    Route::get('/input-cuti/{nik}', [CutiController::class, 'input_cuti_new'])->name('input-cuti');
    Route::get('/list-emp', [CutiController::class, 'list_emp'])->name('list-emp');

    Route::post('store-cuti', [CutiController::class, 'store'])->name('store-cuti');
    Route::post('update-cuti', [CutiController::class, 'update'])->name('update-cuti');
    Route::post('/delete-cuti/{id}', [CutiController::class, 'delete'])->name('delete-cuti');
    Route::get('/edit-cuti/{id}', [CutiController::class, 'input_cuti_edit'])->name('edit-cuti');

    Route::get('/budget-cuti', [CutiController::class, 'budgetCuti'])->name('budget-cuti');
    Route::post('/budget-cuti-search', [CutiController::class, 'budgetCutiSearch'])->name('budget-cuti-search');
    Route::get('/budget-cuti-new', [CutiController::class, 'inputBudgetCuti'])->name('budget-cuti-new');
    Route::post('store-budget-cuti', [CutiController::class, 'storeBudgetCuti'])->name('store-budget-cuti');
    Route::post('/import-budget-cuti', [CutiController::class, 'import_excel'])->name('import-excel-budget-cuti');

    // Kemandoran
    Route::get('/kemandoran', [MandorController::class, 'index'])->name('kemandoran');
    Route::post('import-kemandoran', [MandorController::class, 'import_excel'])->name('import-kemandoran');
    Route::get('/input-mandor', [MandorController::class, 'inputMandor'])->name('input-mandor');
    Route::post('store-mandor', [MandorController::class, 'storeMandor'])->name('store-mandor');
    Route::post('delete-mandor', [MandorController::class, 'deleteMandor'])->name('delete-mandor');

    // Filter Dashboard
    Route::post('filter-todate', [FilterDashboardController::class, 'filterTodateAtt'])->name('filter-todate');

    // Dashboard Cuti
    Route::get('/dashboard-cuti', [DashboardCutiController::class, 'index'])->name('dashboard-cuti');
    Route::post('dashboard-cuti', [DashboardCutiController::class, 'find'])->name('find-cuti');

    // Holiday
    Route::get('/hari-libur-all-dept', [HolidayController::class, 'indexAllDept'])->name('holiday-all-dept');
    Route::get('/hari-libur', [HolidayController::class, 'index'])->name('holiday');
    Route::post('simpan', [HolidayController::class, 'store'])->name('store-holiday');
    Route::post('hapus', [HolidayController::class, 'delete'])->name('delete-holiday');

    // Training
    Route::get('/master-training', [TrainingController::class, 'index'])->name('master-training');
    Route::get('/training-att', [TrainingController::class, 'trainingAtt'])->name('training-att');
    Route::post('store-training', [TrainingController::class, 'store'])->name('store-training');
    Route::post('update-training', [TrainingController::class, 'update'])->name('update-training');
    Route::get('delete-training/{id}', [TrainingController::class, 'delete'])->name('delete-training');
    Route::get('delete-training-item/{id_data}/{nik}', [TrainingController::class, 'delete_item'])->name('delete-training-item');
    Route::get('/training-detail/{no}', [TrainingController::class, 'view'])->name('detail-training');
    Route::get('/master-training-emp', [TrainingController::class, 'indexEmp'])->name('master-training-emp');
    Route::get('/training-detail-emp/{nik}', [TrainingController::class, 'viewEmp'])->name('detail-training-emp');
    Route::get('/training-choose', [TrainingController::class, 'chooseDept'])->name('chooseDept');
    Route::post('training-choose', [TrainingController::class, 'loadDept'])->name('loadDept');
    Route::post('select-emp', [TrainingController::class, 'select_emp'])->name('select-emp');
    Route::post('select-cat', [TrainingController::class, 'select_training'])->name('select-cat');
    Route::get('/edit-training/{id}', [TrainingController::class, 'edit'])->name('edit-training');
    Route::get('/print-training/{id}', [TrainingController::class, 'print'])->name('print-training');
    Route::get('/summary-actual-training', [TrainingController::class, 'summary_actual_training'])->name('summary-actual-training');
    Route::get('/data-detail-training', [TrainingController::class, 'detail_training'])->name('data-detail-training');
    Route::post('/data-detail-training-filter', [TrainingController::class, 'filter_detail_training'])->name('filter-data-detail-training');
    Route::post('/data-detail-training-filter-jquery', [TrainingController::class, 'filter_detail_training_jquery'])->name('filter-data-detail-training-jquery');
    Route::get('/data-training-import', [TrainingController::class, 'index_import'])->name('training-import');
    Route::post('/import-judul-training', [TrainingController::class, 'import_excel_judul'])->name('import-excel-judul');
    Route::post('/import-peserta-training', [TrainingController::class, 'import_excel_peserta'])->name('import-excel-peserta');

    // Medical
    Route::get('/medical', [MedicalCheckController::class, 'index'])->name('medical');
    Route::post('store-medical', [MedicalCheckController::class, 'store'])->name('store-medical');
    Route::get('/add-medical/{id}', [MedicalCheckController::class, 'add'])->name('add-medical-input');
    Route::post('store-medical-input', [MedicalCheckController::class, 'storeInput'])->name('store-medical-input');
    Route::get('/view-medical/{id}', [MedicalCheckController::class, 'view'])->name('medical-view');

    // Drug
    Route::get('/drug', [DrugTestController::class, 'index'])->name('drug');
    Route::post('store-drug', [DrugTestController::class, 'store'])->name('store-drug');
    Route::get('/index-add/{id}', [DrugTestController::class, 'indexAdd'])->name('add-drug');
    Route::post('store-drug-input', [DrugTestController::class, 'storeInput'])->name('store-drug-input');

    // Testing attendance
    Route::get('/testing', [TestingAbsenController::class, 'index'])->name('testing');
    Route::get('/testing/{nik}', [TestingAbsenController::class, 'view'])->name('view-summary-emp-testing');
    Route::post('/testing-filter', [TestingAbsenController::class, 'view_filter'])->name('view-summary-emp-filter-testing');

    // Summary attendance month
    Route::get('/sum-month', [TestingAbsenController::class, 'index_month'])->name('sum-month');
    Route::get('/sum-month/{nik}', [TestingAbsenController::class, 'view_month'])->name('view-summary-emp-testing-month');
    Route::post('/testing-update', [TestingAbsenController::class, 'update'])->name('testing-update');
    Route::post('/testing-update-calc', [TestingAbsenController::class, 'update_calc'])->name('testing-update-calc');
    Route::post('/testing-update-calc-shift', [TestingAbsenController::class, 'update_calc_shift'])->name('testing-update-calc-shift');

    //  Dashboard Pert Dept
    Route::get('/dashboard-all', [DashboardAllController::class, 'index'])->name('dashboard-all');
    Route::get('/dash-sub-a', [DashboardAllController::class, 'dashA'])->name('dash-a');
    Route::get('/dash-sub-b', [DashboardAllController::class, 'dashB'])->name('dash-b');
    Route::get('/dash-sub-c', [DashboardAllController::class, 'dashC'])->name('dash-c');
    Route::get('/dash-sub-d', [DashboardAllController::class, 'dashD'])->name('dash-d');
    Route::get('/dash-sub-e', [DashboardAllController::class, 'dashE'])->name('dash-e');
    Route::get('/dash-sub-f', [DashboardAllController::class, 'dashF'])->name('dash-f');
    Route::get('/dash-sub-bskp', [DashboardAllController::class, 'bskp'])->name('dash-bskp');
    Route::get('/dash-it', [DashboardAllController::class, 'it'])->name('dash-it');
    Route::get('/dash-factory', [DashboardAllController::class, 'factory'])->name('dash-factory');
    Route::get('/dash-accfin', [DashboardAllController::class, 'accfin'])->name('dash-accfin');

  // Master Shift
  //   Route::get('/shift-add', [MasterShiftController::class, 'insert'])->name('shift-add');
  //   Route::get('/shift-reg', [MasterShiftController::class, 'index_shift'])->name('shift-reg');
  Route::get('/shift', [MasterShiftController::class, 'index'])->name('shift');
  Route::get('/shift_dua', [MasterShiftController::class, 'fact_detail'])->name('shift-dua');
  Route::get('/shift-master', [MasterShiftController::class, 'masterShift'])->name('shift-master');
  Route::get('/shift-detail', [MasterShiftController::class, 'detail'])->name('shift-detail');
  Route::post('/filter-data', [MasterShiftController::class, 'filterData'])->name('filter-data');
  Route::post('/filter-data-emp', [MasterShiftController::class, 'filterDataemp'])->name('filter-data-emp');
  Route::post('/search-data-emp', [MasterShiftController::class, 'searchDataemp'])->name('search-data-emp');
  Route::post('/filter-jabatan-emp', [MasterShiftController::class, 'selectPosition'])->name('filter-position');
  Route::post('/add-shift', [MasterShiftController::class, 'masterShift_store'])->name('shift-master-add');
  Route::get('/shift-master/edit/{id}', [MasterShiftController::class, 'masterShift_edit'])->name('shift-master-edit');
  Route::put('/shift-master/update/{id}', [MasterShiftController::class, 'masterShift_update'])->name('shift-master-update');
  Route::get('/shift-master/delete/{id}', [MasterShiftController::class, 'masterShift_delete'])->name('shift-master-delete');
  Route::post('/update-shift', [MasterShiftController::class, 'update'])->name('updateShift');
  Route::post('/search', [MasterShiftController::class, 'search'])->name('search');
  Route::post('/search_emp', [TestingAbsenController::class, 'search_emp'])->name('search_emp');
  Route::post('/search_emp_month', [TestingAbsenController::class, 'search_emp_month'])->name('search_emp_month');
    // Master Shift
    //   Route::get('/shift-add', [MasterShiftController::class, 'insert'])->name('shift-add');
    //   Route::get('/shift-reg', [MasterShiftController::class, 'index_shift'])->name('shift-reg');
    Route::get('/shift', [MasterShiftController::class, 'index'])->name('shift');
    Route::get('/shift_dua', [MasterShiftController::class, 'fact_detail'])->name('shift-dua');
    Route::get('/shift-master', [MasterShiftController::class, 'masterShift'])->name('shift-master');
    Route::get('/shift-detail', [MasterShiftController::class, 'detail'])->name('shift-detail');
    Route::post('/filter-data', [MasterShiftController::class, 'filterData'])->name('filter-data');
    Route::post('/filter-data-emp', [MasterShiftController::class, 'filterDataemp'])->name('filter-data-emp');
    Route::post('/add-shift', [MasterShiftController::class, 'masterShift_store'])->name('shift-master-add');
    Route::get('/shift-master/edit/{id}', [MasterShiftController::class, 'masterShift_edit'])->name('shift-master-edit');
    Route::put('/shift-master/update/{id}', [MasterShiftController::class, 'masterShift_update'])->name('shift-master-update');
    Route::get('/shift-master/delete/{id}', [MasterShiftController::class, 'masterShift_delete'])->name('shift-master-delete');
    Route::post('/update-shift', [MasterShiftController::class, 'update'])->name('updateShift');
    Route::post('/search', [MasterShiftController::class, 'search'])->name('search');
    Route::post('/search_emp', [TestingAbsenController::class, 'search_emp'])->name('search_emp');
    Route::post('/search_emp_month', [TestingAbsenController::class, 'search_emp_month'])->name('search_emp_month');

    Route::get('/shift-new', [MasterShiftController::class, 'index_detail'])->name('shift-new');
    Route::get('/shift-new/{nik}', [MasterShiftController::class, 'detail_emp_shift'])->name('shift-new-detail');
    Route::put('/update-shift-emp', [MasterShiftController::class, 'updateDetail'])->name('updateShiftEmp');

    Route::get('/change-ta-desc', [TestingAbsenController::class, 'changeTADesc'])->name('change-ta-desc');
    Route::get('/change-ta-desc/{nik}', [TestingAbsenController::class, 'changeTADescDetail'])->name('change-ta-desc-detail');
    Route::put('/update-ta-desc', [TestingAbsenController::class, 'updateTADescDetail'])->name('updateTaDesc');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/send-event', function () {
    broadcast(new \App\Events\TestingEvent());
});
