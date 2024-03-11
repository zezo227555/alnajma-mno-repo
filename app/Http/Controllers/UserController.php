<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreate;
use App\Http\Requests\UserUpdate;
use App\Models\Deposet_Dissmisal;
use App\Models\Stores;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', '=', 1)->paginate(3);
        return view('users.all_users', ['users' => $users]);
    }

    public function all_admins()
    {
        $users = User::where('role', '=', 2)->paginate(3);
        return view('users.all_users', ['users' => $users]);
    }

    public function all_accounters()
    {
        $users = User::where('role', '=', 3)->first();
        $deposets = Deposet_Dissmisal::where('users_id', '=', 1)->where('repo_id', '=', 1)->latest()->take(10)->get();
        $last_deposet = Deposet_Dissmisal::where('users_id', '=', 1)->where('repo_id', '=', 1)->where('type', '=', 1)->latest()->take(1)->first();
        return view('users.alnajma_account', ['users' => $users, 'deposets' => $deposets, 'last_deposet' => $last_deposet]);
    }

    public function admins_account()
    {
        $users = Auth::user();
        $deposets = Deposet_Dissmisal::where('users_id', '=', 1)->where('repo_id', '=', $users->id)->latest()->take(10)->get();
        $last_deposet = Deposet_Dissmisal::where('users_id', '=', 1)->where('repo_id', '=', $users->id)->latest()->take(1)->first();
        $repo = User::where('role', '=', 1)->get();
        return view('users.admin_acccount', ['users' => $users, 'deposets' => $deposets, 'last_deposet' => $last_deposet, 'repo' => $repo]);
    }

    public function repos_account()
    {
        $users = Auth::user();

        $store_topup = Stores::where('users_id', '=', $users->id)->with('Ricept', function($q){
            $currentMonth = Carbon::now()->month;
            $q->whereMonth('created_at', $currentMonth)->where('type', '=', 0);
        })->get();
        $topup_co = 0;
        $store_ammount = 0;
        $stores_value = [];
        $repo_salary = 0;
        $class_A = 0;
        $class_B = 0;

        foreach($store_topup as $store){
            foreach($store->Ricept as $re){
                if(isset($re->ammount)){
                    $store_ammount += $re->ammount;
                }
            }
            array_push($stores_value, $store_ammount);
            $store_ammount = 0;
        }

        foreach($stores_value as $s){
            if($s != 0){
                $topup_co++;
            }
            if($s >= 6000){
                $class_B += $s;
            }elseif($s >= 15000){
                $class_A += $s;
            }
        }

        if($topup_co >= 10 && $topup_co <= 14){
            $repo_salary = 450;
        }elseif($topup_co >= 15 && $topup_co <= 19){
            $repo_salary = 560;
        }elseif($topup_co >= 20 && $topup_co <= 25){
            $repo_salary = 680;
        }elseif($topup_co >= 26){
            $repo_salary = 950;
        }

        $salary_A = $class_A * 0.001;
        $salary_B = ($class_B / 2)*0.001;
        

        $deposets = Deposet_Dissmisal::where('repo_id', '=', $users->id)->latest()->take(20)->get();
        $last_deposet = Deposet_Dissmisal::where('repo_id', '=', $users->id)->where('type', '=', 0)->latest()->take(1)->first();
        $last_dissmisal = Deposet_Dissmisal::where('repo_id', '=', $users->id)->where('type', '=', 1)->latest()->take(1)->first();

        return view('users.repo_acccount', [
            'users' => $users,
            'deposets' => $deposets,
            'last_dissmisal' => $last_dissmisal,
            'last_deposet' => $last_deposet,
            'topup_co' => $topup_co,
            'class_A' => $class_A,
            'class_B' => $class_B,
            'salary_A' => $salary_A,
            'salary_B' => $salary_B,
            'repo_salary' => $repo_salary,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.add_user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreate $re)
    {
        try{

        $user = new User();

        if($re->hasfile('user_photo')){   
            $file = $re->file('user_photo');
            $ecxtntion = $file->getClientOriginalExtension();
            $filename = time().'.'.$ecxtntion;
            $file->move('images/user_photos', $filename);
            $user->photo = $filename;
        }
        $user->name = $re->input('name');
        $user->username = $re->input('username');
        $user->password = Hash::make($re->input('password'));
        $user->role = $re->input('role');
        $user->phone = $re->input('phone');

        if($re->input('balance' != '')){
            $user->balance = $re->input('balance');
        }
        $user->save();
        return redirect(route('user.create'))->with('message', 'تمت الاضافة بنجاح');
    }catch(ValidationException){
        return back()->withInput();
    }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show_user', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit_user', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdate $re, User $user)
    {
        if($re->hasfile('user_photo')){
            unlink('images/user_photos/'.$user->photo);
            $file = $re->file('user_photo');
            $ecxtntion = $file->getClientOriginalExtension();
            $filename = time().'.'.$ecxtntion;
            $file->move('images/user_photos', $filename);
            $user->photo = $filename;
        }
        if($re->input('name') != $user->name){
            $user->name = $re->input('name');
        }
        if($re->input('username') != $user->name){
            $user->username = $re->input('username');
        }
        if($re->input('password') != $user->password){
            $user->password = Hash::make($re->input('password'));
        }
        if($re->input('role') != $user->role){
            $user->role = $re->input('role');
        }
        if($user->phone != $re->input('phone')){
            $user->phone = $re->input('phone');
        }
        $user->save();
        return redirect(route('user.edit', $user))->with('message', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        unlink('images/user_photos/'.$user->photo);
        $user->delete();
        return redirect(route('user.index'))->with(['massege' => 'تم حذف المستخدم']);
    }

    public function user_dissmisal_form($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        return view('users.user_dissmisal_form', ['user' => $user]);
    }

    public function user_deposet_form($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        return view('users.user_deposet_form', ['user' => $user]);
    }

    public function user_deposet(Request $re ,$user_id)
    {
        try{
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required',
            'data_file' => 'mimes:pdf',
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'info.required' => 'الوصف مطلوب',
            'data_file.required' => 'ملف الايداع مطلوب',
            'data_file.mimes' => 'ملف الايداع يجب ان يكون نوع PDF',
        ]);

        if($re->input('ammuont') == 0){
            return redirect()->back()->withErrors(['zero_ammount' => 'القيمة صفر'])->withInput();
        }

        $user = User::where('id', '=', 1)->first();
        $repo = User::where('id', '=', $user_id)->first();
        if($re->input('ammount') > $repo->store_balance){
            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
        }
        $deposet_dissmisal = new Deposet_Dissmisal();

        if($re->hasfile('data_file')){   
            $file = $re->file('data_file');
            $ecxtntion = $file->getClientOriginalExtension();
            $filename = time().'.'.$ecxtntion;
            $file->move('deposet_files/repo_files/', $filename);
            $deposet_dissmisal->file = $filename;
        }

        $deposet_dissmisal->ammount = $re->input('ammount');
        $deposet_dissmisal->info = $re->input('info');
        $deposet_dissmisal->type = true;
        $deposet_dissmisal->users_id = $user->id;
        $deposet_dissmisal->repo_id = $repo->id;
        
        $user->store_balance += $re->input('ammount');
        $repo->balance -= $re->input('ammount');
        $repo->store_balance -= $re->input('ammount');

        $deposet_dissmisal->save();
        $user->save();
        $repo->save();

        return redirect(route('user.user_deposet_form', $user_id))->with('messege', 'تم اضافة الايصال بنجاح');
    }catch(ValidationException){
        return back()->withInput();
    }
    }

    public function user_dissmisal(Request $re ,$user_id)
    {
        try{
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required'
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'info.required' => 'الوصف مطلوب'
        ]);

        if($re->input('ammuont') == 0){
            return redirect()->back()->withErrors(['zero_ammount' => 'القيمة صفر'])->withInput();
        }

        $id = Auth::user();

        $user = User::where('id', '=', $id->id)->first();
        $repo = User::where('id', '=', $user_id)->first();

        if($user->role == 2 || $user->role == 3){
            if($re->input('ammount') > $user->balance){
                return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
            }
        }elseif($user->role == 1){
            if($re->input('ammount') > $user->store_balance){
                return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
            }
        }

        $deposet_dissmisal = new Deposet_Dissmisal();

        $deposet_dissmisal->ammount = $re->input('ammount');
        $deposet_dissmisal->info = $re->input('info');
        $deposet_dissmisal->type = false;
        $deposet_dissmisal->users_id = $user->id;
        $deposet_dissmisal->repo_id = $repo->id;
        
        $user->balance -= $re->input('ammount');
        $repo->balance += $re->input('ammount');
        if($repo->role == 1){
            $repo->portal_balance += $re->input('ammount');
        }

        $deposet_dissmisal->save();
        $user->save();
        $repo->save();

        return redirect(route('user.user_dissmisal_form', $user_id))->with('messege', 'تم اضافة الايصال بنجاح');
    }catch(ValidationException){
        return back()->withInput();
    }
    }

    public function alnajma_topup(Request $re, $id)
    {
        try{
        $user = User::where('id', '=', $id)->first();
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required',
            'data_file' => 'required|mimes:pdf'
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'ammount.min' => 'القيمة يجب ان تكون موجبة',
            'info.required' => 'الوصف مطلوب',
            'data_file.required' => 'ملف الايداع مطلوب',
            'data_file.mimes' => 'ملف الايداع يجب ان يكون نوع PDF',
        ]);
        $deposet = new Deposet_Dissmisal();

        if($re->hasfile('data_file')){   
            $file = $re->file('data_file');
            $ecxtntion = $file->getClientOriginalExtension();
            $filename = time().'.'.$ecxtntion;
            $file->move('deposet_files/', $filename);
            $deposet->file = $filename;
        }
        $deposet->ammount = $re->input('ammount');
        $deposet->info = $re->input('info');
        $deposet->type = true;
        $deposet->users_id = 1;
        $deposet->repo_id = 1;

        $user->balance += $re->input('ammount');

        $deposet->save();
        $user->save();

        return redirect(route('user.all_accounters', $user->id))->with('messege', 'تم حفظ الايصال بنجاح');
    }catch(ValidationException){
        return back()->withInput();
    }
    }

    public function alnajma_dissmisal(Request $re, $id)
    {
        try{
        $user = User::where('id', '=', $id)->first();
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required',
            'data_file' => 'mimes:pdf'
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'ammount.min' => 'القيمة يجب ان تكون موجبة',
            'info.required' => 'الوصف مطلوب',
            'data_file.mimes' => 'ملف الصرف يجب ان يكون نوع PDF',
        ]);
        $deposet = new Deposet_Dissmisal();

        if($re->input('ammount') > $user->store_balance){
            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
        }

        if($re->hasfile('data_file')){   
            $file = $re->file('data_file');
            $ecxtntion = $file->getClientOriginalExtension();
            $filename = time().'.'.$ecxtntion;
            $file->move('deposet_files/', $filename);
            $deposet->file = $filename;
        }
        $deposet->ammount = $re->input('ammount');
        $deposet->info = $re->input('info');
        $deposet->type = false;
        $deposet->users_id = 1;
        $deposet->repo_id = 1;

        $user->store_balance -= $re->input('ammount');

        $deposet->save();
        $user->save();

        return redirect(route('user.all_accounters', $user->id))->with('messege', 'تم حفظ الايصال بنجاح');
    }catch(ValidationException){
        return back()->withInput();
    }
    }

    public function repo_deposet_search(Request $re, $id)
    {
        try{
        $re->validate([
            'date_from' => 'required',
            'date_to' => 'required',
        ], [
            'date_from.required' => 'التاريخ مطلوب',
            'date_to.required' => 'التاريخ مطلوب',
        ]);

        $date_from = new DateTime($re->input('date_from'));
        $date_to = new DateTime($re->input('date_to'));

        $date_from = $date_from->format('Y-m-d H:i:s');
        $date_to = $date_to->format('Y-m-d H:i:s');

        $deposet_dissmisal = Deposet_Dissmisal::where('repo_id', '=', $id)->whereBetween('created_at', [$date_from, $date_to])->get();

        return view('reports.repo_deposets_report', ['deposet_dissmisal' => $deposet_dissmisal]);
    }catch(ValidationException){
        return back()->withInput();
    }
    }

    public function admins_deposet_search(Request $re, $id)
    {
        try{
        $re->validate([
            'date_from' => 'required',
            'date_to' => 'required',
        ], [
            'date_from.required' => 'التاريخ مطلوب',
            'date_to.required' => 'التاريخ مطلوب',
        ]);

        $date_from = new DateTime($re->input('date_from'));
        $date_to = new DateTime($re->input('date_to'));

        $date_from = $date_from->format('Y-m-d H:i:s');
        $date_to = $date_to->format('Y-m-d H:i:s');

        $deposet_dissmisal = Deposet_Dissmisal::where('repo_id', '=', $id)->where('users_id', '=', 1)->whereBetween('created_at', [$date_from, $date_to])->get();

        return view('reports.admins_deposets_report', ['deposet_dissmisal' => $deposet_dissmisal]);
    }catch(ValidationException){
        return back()->withInput();
    }
    }

    public function alnajma_deposet_search(Request $re)
    {
        try{
        $re->validate([
            'date_from' => 'required',
            'date_to' => 'required',
        ], [
            'date_from.required' => 'التاريخ مطلوب',
            'date_to.required' => 'التاريخ مطلوب',
        ]);

        $date_from = new DateTime($re->input('date_from'));
        $date_to = new DateTime($re->input('date_to'));

        $date_from = $date_from->format('Y-m-d H:i:s');
        $date_to = $date_to->format('Y-m-d H:i:s');

        $deposet_dissmisal = Deposet_Dissmisal::where('users_id', '=', 1)->whereBetween('created_at', [$date_from, $date_to])->get();

        return view('reports.alnajma_deposets_report', ['deposet_dissmisal' => $deposet_dissmisal]);
    }catch(ValidationException){
        return back()->withInput();
    }
    }
}
