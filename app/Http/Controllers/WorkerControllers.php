<?php

namespace App\Http\Controllers;

use \App\Models\Worker;
use Illuminate\Http\Request;
use Alert;
use App\Exports\WorkerExport;
use App\Imports\WorkerImport;
use Session;
use Maatwebsite\Excel\Facades\Excel;

class WorkerControllers extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = Worker::orderBy('pangkat', 'desc')->paginate(5000);
        return view('data', compact('workers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required|max:255',
            'nrp' => 'required|unique:workers',
            'pangkat'=> 'required|max:255',
            'jabatan' => 'required|max:255',
            'email' => 'required'
        ],[
            'nama.required'          => 'Nama wajib diisi.',
            'nrp.required'      => 'nrp Wajib diisi.',
            'nrp.min'           => 'nrp minimal diisi dengan 21 karakter.',
            'pangkat.required'         => 'pangkat Wajib diisi.',
            'jabatan.required'            => 'jabatan Wajib Diisi.',
            'nrp.unique'           => 'nrp sudah terdaftar.',
        ]);

        $workers = Worker::create([
            'nama' => $request->nama,
            'nrp' => $request->nrp,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'email' => $request->email
        ]);

        Alert::success('Data Pegawai Berhasil Dibuat');
        return redirect('/pegawai')->with('success', 'Pegawai Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Worker $worker)
    {
        return view('edit', compact('worker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'nrp' => 'required',
            'pangkat'=> 'required|max:255',
            'jabatan' => 'required|max:255',
            'email' => 'required'
        ],[
            'nama.required'          => 'Nama wajib diisi.',
            'nrp.required'      => 'nrp Wajib diisi.',
            'nrp.min'           => 'nrp minimal diisi dengan 21 karakter.',
            'pangkat.required'         => 'pangkat Wajib diisi.',
            'jabatan.required'            => 'jabatan Wajib Diisi.',
            'nrp.unique'           => 'nrp sudah terdaftar.',
        ]);


        $workers = Worker::find($id)->update([
            'nama' => $request->nama,
            'nrp' => $request->nrp,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'email' => $request->email
        ]);

        Alert::success('Data Pegawai Berhasil Diganti');

        return redirect('/pegawai')->with('success', 'Data Berhasil Diganti.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workers = Worker::find($id);
        $workers->delete();

        Alert::success('Data Pegawai Berhasil Dihapus');
        return redirect('/pegawai');
    }
    public function export_excel()
	{
		return Excel::download(new WorkerExport, 'pegawai.xlsx');
	}
    public function import_excel(Request $request)
	{
		// validasi
		$validated = $request->validate([
			'file' => 'required|mimes:csv,xls,xlsx'
        ],[
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Ekstensi File Tidak Valid'
        ]);

		// menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('file_excel',$nama_file);

		// import data
		Excel::import(new WorkerImport, public_path('/file_excel/'.$nama_file));


        Session::flash('success', 'Data Berhasil Diimport');

		// alihkan halaman kembali
		return redirect('/pegawai')->with('success', 'Data Berhasil Diimport.');
	}
}
