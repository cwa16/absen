<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\AttTraining;
use App\Models\DrugTestInput;
use App\Models\MedicalCheckInput;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use PDF;
use Redirect;
use App\Imports\JudulTrainingImport;
use App\Imports\AttTrainingImport;
use Maatwebsite\Excel\Facades\Excel;

class TrainingController extends Controller
{
    public function index()
    {
        $data = DB::table('trainings')
            ->join('users', 'trainings.trainer', '=', 'users.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->select('trainings.*', 'users.name as trainer_name', DB::raw('COUNT(att_trainings.nik) as att'))
            ->groupBy('att_trainings.id_training')
            ->orderBy('trainings.from_date', 'desc')
            ->get();

        return view('admin.pages.training-data', ['data' => $data]);
    }

    public function summary_actual_training()
    {
        $data = Training::all();
        $training = Training::groupBy('trainer')->get();

        return view('admin.pages.training-actual-summary', ['data' => $data,
            'training' => $training,
        ]);
    }

    public function trainingAtt()
    {
        $user = User::all();
        $training = Training::all();
        $no_id = Training::pluck('id')->latest();
        $now = Carbon::now();
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('y');

        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $rom = '';
        while ($month > 0) {
            foreach ($map as $roman => $int) {
                if ($month >= $int) {
                    $month -= $int;
                    $rom .= $roman;
                    break;
                }
            }
        }

        return view('admin.pages.training-att', ['year' => $year, 'user' => $user, 'training' => $training, 'rom' => $rom, 'no_id' => $no_id]);
    }

    public function store(Request $request)
    {
        $no = $request->no;
        $kind = $request->kind;
        $id_data = $request->id_data;
        $topic = $request->topic;
        $trainer = $request->trainer;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $place = $request->place;
        $category = $request->category;
        $summary = $request->summary;
        $comment = $request->comment;

        $storeTraining = Training::firstOrCreate([
            'no' => $no,
            'kind' => $kind,
            'id_data' => $id_data,
            'topic' => $topic,
        ],
            [
                'no' => $no,
                'kind' => $kind,
                'id_data' => $id_data,
                'topic' => $topic,
                'trainer' => $trainer,
                'from_date' => $dateFrom,
                'to_date' => $dateTo,
                'place' => $place,
                'category' => $category,
                'summary' => $summary,
                'comment' => $comment,
            ]);

        foreach ($request->nik as $key => $value) {
            AttTraining::firstOrCreate([
                'id_training' => $id_data,
                'nik' => $request->get('nik')[$key],
                'score' => $request->get('score')[$key],
                'ket' => $request->get('ket')[$key],
            ],
                [
                    'id_training' => $id_data,
                    'nik' => $request->get('nik')[$key],
                    'ket' => $request->get('ket')[$key],
                ]);
        }

        Alert::success('Berhasil', 'Data Training Tersimpan!!!');
        return redirect()->route('master-training');
    }

    public function view($id_data)
    {
        $tr = Training::where('id_data', $id_data)->get();
        $trAtt = AttTraining::where('id_training', $id_data)->get();

        $dept = Training::where('id_data', $id_data)->first();
        $nik = $dept->nik;

        return view('admin.pages.training-detail', ['tr' => $tr, 'trAtt' => $trAtt, 'dept' => $dept]);
    }

    public function edit($id_data)
    {
        $user = User::all();
        $training = Training::where('id_data', $id_data)->first();
        $user_att = AttTraining::where('id_training', $id_data)->get();

        return view('admin.pages.training-edit', [
            'user' => $user,
            'user_att' => $user_att,
            'training' => $training]);
    }

    public function update(Request $request)
    {
        $no = $request->no;
        $kind = $request->kind;
        $id_data = $request->id_data;
        $topic = $request->topic;
        $trainer = $request->trainer;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $place = $request->place;
        $category = $request->category;
        $summary = $request->summary;
        $comment = $request->comment;

        $storeTraining = Training::where('id_data', $id_data)->update([
            'no' => $no,
            'kind' => $kind,
            'id_data' => $id_data,
            'topic' => $topic,
            'trainer' => $trainer,
            'from_date' => $dateFrom,
            'to_date' => $dateTo,
            'place' => $place,
            'category' => $category,
            'summary' => $summary,
            'comment' => $comment,
        ]);

        foreach ($request->nik as $key => $value) {
            AttTraining::updateOrCreate([
                'id_training' => $id_data,
                'nik' => $request->get('nik')[$key],
            ],
                [
                    'id_training' => $id_data,
                    'nik' => $request->get('nik')[$key],
                    'score' => $request->get('score')[$key],
                    'ket' => $request->get('ket')[$key],
                ]);
        }

        Alert::success('Berhasil', 'Data Training Terupdate!!!');
        return redirect()->route('master-training');
    }

    public function delete($id)
    {
        Training::where('id_data', $id)->delete();
        Alert::success('Berhasil', 'Data Training Terhapus!!!');
        return Redirect::back();
    }

    public function delete_item($id_data, $nik)
    {
        $data = AttTraining::where('id_training', $id_data)->where('nik', $nik)->delete();
        return Redirect::back();
    }

    public function indexEmp(Request $request)
    {
        if ($request->ajax()) {
            $data = User::has('trainings')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'admin.includes.action-master-training-emp')
                ->make(true);
        }

        return view('admin.pages.training-data-emp');
    }

    public function viewEmp($nik)
    {
        $user = User::where('nik', $nik)->first();
        $data = AttTraining::where('nik', $nik)->get();

        $medic = MedicalCheckInput::with('medical')->where('nik', $nik)->get()->groupBy(function ($item) {
            return $item->medical->date;
        });

        $drug = DrugTestInput::with('drug')->where('nik', $nik)->get()->groupBy(function ($item) {
            return $item->drug->date;
        });

        $trAtt = DB::table('att_trainings')
            ->join('trainings', 'att_trainings.id_training', '=', 'trainings.id_data')
            ->join('users', 'trainings.trainer', '=', 'users.nik')
            ->select('att_trainings.nik', 'att_trainings.score', 'att_trainings.ket', 'trainings.*', 'users.name')
            ->where('att_trainings.nik', '=', $nik)
            ->get();
        return view('admin.pages.training-detail-emp', ['drug' => $drug, 'medic' => $medic, 'user' => $user, 'data' => $data, 'trAtt' => $trAtt]);
    }

    public function chooseDept(Request $request)
    {
        $dept = User::groupBy('jabatan')->get();

        return view('admin.pages.training-data-choose', ['dept' => $dept]);
    }

    public function loadDept(Request $request)
    {
        $user = User::all();
        $training = Training::all();
        $now = Carbon::now();
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('y');

        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $rom = '';
        while ($month > 0) {
            foreach ($map as $roman => $int) {
                if ($month >= $int) {
                    $month -= $int;
                    $rom .= $roman;
                    break;
                }
            }
        }

        $user1 = User::all();
        if ($request->dept != null) {
            $user_att = User::whereIn('jabatan', $request->jabatan)->whereIn('dept', $request->dept)->get();
        } else {
            $user_att = User::whereIn('jabatan', $request->jabatan)->get();
        }

        $training = Training::all();
        $now = Carbon::now();return view('admin.pages.training-att', ['year' => $year,
            'user' => $user,
            'user1' => $user1,
            'user_att' => $user_att,
            'training' => $training,
            'rom' => $rom]);
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('y');

    }

    function print($id) {
        $data = Training::where('id_data', $id)->with(['attTrainings', 'user'])->get();
        $imagePath = public_path("assets/img/logo.png");
        $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.pages.training-data-print', ['data' => $data,
            'image' => $image,
        ]);
        $pdf->set_option("isPhpEnabled", true);
        return $pdf->stream();

    }

    public function select_emp(Request $request)
    {
        $jabatan = User::whereIn('jabatan', $request->jabatan)->groupBy('dept')
            ->pluck('dept');
        return response()->json($jabatan);
    }

    public function detail_training()
    {
        $data = DB::table('trainings')
            ->join('users as trainer_name', 'trainings.trainer', '=', 'trainer_name.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->join('users as att', 'att_trainings.nik', '=', 'att.nik')
            ->select('trainer_name.name as trainers', 'att.name as name',
                'att.nik as nik', 'att.dept as dept', 'att.jabatan as jabatan', 'att_trainings.score as score', 'trainings.*')
            ->get();

        $category = DB::table('trainings')
            ->join('users as trainer_name', 'trainings.trainer', '=', 'trainer_name.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->join('users as att', 'att_trainings.nik', '=', 'att.nik')
            ->select('trainings.category')
            ->groupBy('trainings.category')
            ->get();

        return view('admin.pages.training-data-detail', ['data' => $data,
            'category' => $category]);
    }

    public function filter_detail_training(Request $request)
    {
        $data = DB::table('trainings')
            ->join('users as trainer_name', 'trainings.trainer', '=', 'trainer_name.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->join('users as att', 'att_trainings.nik', '=', 'att.nik')
            ->select('trainer_name.name as trainers', 'att.name as name',
                'att.nik as nik', 'att.dept as dept', 'att.jabatan as jabatan', 'att_trainings.score as score', 'trainings.*')
            ->where('trainings.category', $request->category)
            ->where('trainings.topic', $request->topic)
            ->whereIn('att.dept', $request->dept)
            ->get();

        $category = DB::table('trainings')
            ->join('users as trainer_name', 'trainings.trainer', '=', 'trainer_name.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->join('users as att', 'att_trainings.nik', '=', 'att.nik')
            ->select('trainings.category')
            ->groupBy('trainings.category')
            ->get();

        return view('admin.pages.training-data-detail', ['data' => $data,
            'category' => $category]);
    }

    public function select_training(Request $request)
    {
        $topic = DB::table('trainings')
            ->join('users as trainer_name', 'trainings.trainer', '=', 'trainer_name.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->join('users as att', 'att_trainings.nik', '=', 'att.nik')
            ->select('trainer_name.name as trainers', 'att.name as name',
                'att.nik as nik', 'att.dept as dept', 'att.jabatan as jabatan', 'att_trainings.score as score', 'trainings.*')
            ->where('trainings.category', $request->category)
            ->groupBy('trainings.topic')
            ->pluck('trainings.topic');

        return response()->json(['topic' => $topic]);
    }

    public function filter_detail_training_jquery(Request $request)
    {
        $data = DB::table('trainings')
            ->join('users as trainer_name', 'trainings.trainer', '=', 'trainer_name.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->join('users as att', 'att_trainings.nik', '=', 'att.nik')
            ->select('trainer_name.name as trainers', 'att.name as name',
                'att.nik as nik', 'att.dept as dept', 'att.jabatan as jabatan', 'att_trainings.score as score', 'trainings.*')
            ->where('trainings.category', $request->category)
            ->where('trainings.topic', $request->topic)
            ->get();

        $category = DB::table('trainings')
            ->join('users as trainer_name', 'trainings.trainer', '=', 'trainer_name.nik')
            ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
            ->join('users as att', 'att_trainings.nik', '=', 'att.nik')
            ->select('trainings.category')
            ->groupBy('trainings.category')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function index_import()
    {
        // $data = DB::table('trainings')
        //     ->join('users', 'trainings.trainer', '=', 'users.nik')
        //     ->join('att_trainings', 'trainings.id_data', '=', 'att_trainings.id_training')
        //     ->where('trainings.comment', '2')
        //     ->select('trainings.*', 'users.name as trainer_name')
        //     ->get();
        $data = DB::table('trainings')
            ->join('users', 'trainings.trainer', '=', 'users.nik')
            ->where('trainings.comment', 'imported')
            ->select('trainings.*', 'users.name as trainer_name')
            ->get();

        return view('admin.pages.training-data-import', ['data' => $data]);
    }

    public function import_excel_judul(Request $request)
    {
      // validasi
      $this->validate($request, [
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      // menangkap file excel
      $file = $request->file('file');

      // membuat nama file unik
      $nama_file = rand().$file->getClientOriginalName();

      // upload ke folder file_siswa di dalam folder public
      $file->move('files',$nama_file);

      // import data
      Excel::import(new JudulTrainingImport, public_path('/files/'.$nama_file));

      // notifikasi dengan session
      Alert::success('Berhasil', 'Judul Training Terimport');

      // alihkan halaman kembali
      return Redirect::back();
    }

    public function import_excel_peserta(Request $request)
    {
      // validasi
      $this->validate($request, [
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      // menangkap file excel
      $file = $request->file('file');

      // membuat nama file unik
      $nama_file = rand().$file->getClientOriginalName();

      // upload ke folder file_siswa di dalam folder public
      $file->move('files',$nama_file);

      // import data
      Excel::import(new AttTrainingImport, public_path('/files/'.$nama_file));

      // notifikasi dengan session
      Alert::success('Berhasil', 'Peserta Training Terimport');

      // alihkan halaman kembali
      return Redirect::back();
    }
}
