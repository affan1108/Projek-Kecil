<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;
class AuthController extends Controller
{
    public function welcome()
    {
        if(Auth::check()){
            return view('welcome');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function index()
    {
        return view('login');
    }
    
    public function login_admin()
    {
        return view('login_admin');
    }

    public function processLoginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);
 
        $credential = ['email' => $request->email, 'password' => $request->password];
        $login = Auth::attempt($credential);
        if ($login) {
            // dd(Auth::check());
            return redirect()->route('mahasiswa');
        }else{
            return redirect()->back()->withInput()->withErrors("Invalid Credential");
        }
    }

    public function diagram()
    {
        return view('diagram');
    }

    public function list()
    {
        $data = Mahasiswa::all();
        return view("list_mahasiswa")->with(['mahasiswa' => $data]);
    }

    public function registration()
    {
        return view('register');
    }  
    
    public function logout() 
    {
        Auth::logout();
  
        return view('welcome');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);
 
        $credential = ['email' => $request->email, 'password' => $request->password];
        $login = Auth::attempt($credential);
        if ($login) {
            // dd(Auth::check());
            return redirect()->route('home');
        }else{
            return redirect()->back()->withInput()->withErrors("Invalid Credential");
        }
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed',
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
           
        if($user->save()){
            return redirect()->route('login')->with("success", "Register Success");
        }else{
            return redirect()->back()->withInput()->withErrors("Something Error !");
        }
    }

    public function layoutMain()
    {
        return view('layout_main');
    }

    public function home()
    {
        return view("home");
    }

    public function home_admin()
    {
        return view("home_admin");
    }

    public function mahasiswa()
    {
        $data = Mahasiswa::all();
        return view("mahasiswa")->with(['mahasiswa' => $data]);
    }

    public function add()
    {
        return view("mahasiswa_add");
    }

    public function processAdd(Request $request)
    {
        $request->validate([
            'mahasiswa_nama' => 'required',
            'mahasiswa_kelas' => 'required',
            'mahasiswa_nrp' => 'required',
        ]);
        $inserting = mahasiswa::create($request->except('_token'));
        if($inserting){
            return redirect()->back()->with("success", "data berhasil ditambahkan");
        }else{
            return redirect()->back()->withInput()->withErrors("Terjadi kesalahan");
        }
    }

    public function update($id)
    {
        $data = mahasiswa::findOrFail($id);
        return view("mahasiswa_update")->with(['mahasiswa' => $data]);
    }

    public function processUpdate(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_nama' => 'required',
            'mahasiswa_kelas' => 'required',
            'mahasiswa_nrp' => 'required',
        ]);
        $process = mahasiswa::findOrFail($id)->update($request->except('_token'));
        if($process){
            return redirect()->back()->with("success", "data berhasil diperbarui");
        }else{
            return redirect()->back()->withInput()->withErrors("Terjadi kesalahan");
        }
    }

    public function delete($id)
    {
        $process = mahasiswa::findOrFail($id)->delete();
        if($process){
            return redirect()->back()->with("success", "data berhasil dihapus");
        }else{
            return redirect()->back()->withErrors("Terjadi kesalahan saat menghapus data");
        }
    }

    public function pdf()
    {
        $data = mahasiswa::all();
        view()->share('data',$data);
        $pdf = PDF::loadview('mahasiswa_pdf');
        return $pdf->download('data.pdf');
    }

    public function upload()
    {
		return view('upload');
	}
 
	public function proses_upload(Request $request)
    {
		$data = new product();
        $file = $request->file;
        $filename = time().'.'.$file->getClientOriginalExtension();
        $request->file->move('assets',$filename);
        $data->file = $filename;
        $data->keterangan = $request->keterangan;

        if($data->save()){
            return redirect()->route('dokumen')->with("success", "Upload Success");
        }else{
            return redirect()->back()->withInput()->withErrors("Something Error !");
        }
	}

    public function dokumen()
    {
        $data = Product::all();
        return view("dokumen")->with(['product' => $data]);
    }

    public function download(Request $request, $file)
    {
        return response()->download(public_path('assets/'.$file));
    }

    public function view($id)
    {
        $data = product::findOrFail($id);

        return view('view',compact('data'));
    }

    public function hapus($id)
    {
        $process = product::findOrFail($id)->delete();
        if($process){
            return redirect()->back()->with("success", "data berhasil dihapus");
        }else{
            return redirect()->back()->withErrors("Terjadi kesalahan saat menghapus data");
        }
    }
}
