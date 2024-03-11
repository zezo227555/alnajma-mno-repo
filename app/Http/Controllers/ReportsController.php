<?php

namespace App\Http\Controllers;

use App\Models\Deposet_Dissmisal;
use App\Models\Ricept;
use App\Models\Stores;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function admin_adds_to_repo_form()
    {
        $user = Auth::user();
        $admin = User::where('role', '=', 2)->get(['name', 'id']);
        return view('reports.repos.admin_adds_to_repo_from', ['user' => $user, 'admin' => $admin]);
    }

    public function admin_adds_to_repo(Request $re, $id)
    {
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

        $deposet_dissmisal = Deposet_Dissmisal::where('users_id', '=', $re->input('admin'))
        ->where('repo_id', '=', auth()->user()->id)->whereBetween('created_at', [$date_from, $date_to])->get();

        return view('reports.repos.admin_adds_to_repo', ['deposet_dissmisal' => $deposet_dissmisal]);
    }

    public function alnajma_adda_to_admin_form()
    {
        return view('reports.admin.alnajma_adda_to_admin_form');
    }

    public function alnajma_adds_form()
    {
        return view('reports.alnajma.alnajma_adds_form');
    }

    public function store_account_form()
    {
        $store = Stores::where('users_id', '=', auth()->user()->id)->get(['id', 'name']);
        return view('reports.repos.store_account_form', ['store' => $store]);
    }

    public function store_account(Request $re)
    {
        $re->validate([
            'date_from' => 'required',
            'date_to' => 'required',
            'store' => 'required'
        ], [
            'date_from.required' => 'التاريخ مطلوب',
            'date_to.required' => 'التاريخ مطلوب',
            'store.required' => 'المحل مطلوب'
        ]);

        $date_from = new DateTime($re->input('date_from'));
        $date_to = new DateTime($re->input('date_to'));

        $date_from = $date_from->format('Y-m-d H:i:s');
        $date_to = $date_to->format('Y-m-d H:i:s');

        $receipt = Ricept::where('stores_id', '=', $re->input('store'))
        ->where('users_id', '=', auth()->user()->id)->whereBetween('created_at', [$date_from, $date_to])->orderBy('created_at', 'DESC')->get();
        $store = Stores::where('id', '=', $re->input('store'))->first();
        return view('reports.repos.store_account', ['receipt' => $receipt, 'store' => $store]);
    }

    public function alnajma_adds_to_admin_form()
    {
        $admin = User::where('role', '=', 2)->get(['name', 'id']);
        return view('reports.alnajma.alnajma_adds_to_admin_from', ['admin' => $admin]);
    }

    public function alnajma_adds_to_admin(Request $re)
    {
        $re->validate([
            'date_from' => 'required',
            'date_to' => 'required',
            'admin' => 'required'
        ], [
            'date_from.required' => 'التاريخ مطلوب',
            'date_to.required' => 'التاريخ مطلوب',
            'store.required' => 'المشرف مطلوب'
        ]);

        $date_from = new DateTime($re->input('date_from'));
        $date_to = new DateTime($re->input('date_to'));

        $date_from = $date_from->format('Y-m-d H:i:s');
        $date_to = $date_to->format('Y-m-d H:i:s');

        $deposet = Deposet_Dissmisal::where('users_id', '=', 1)->where('repo_id', $re->input('admin'))
        ->whereBetween('created_at', [$date_from, $date_to])->get();

        return view('reports.alnajma.alnajma_adds_to_admin', ['deposet' => $deposet]);
    }

    public function repo_account_statment_form()
    {
        $repo = User::where('role', '=', 1)->get(['name', 'id']);
        return view('reports.alnajma.repo_account_statment_form', ['repo' => $repo]);
    }

    public function repo_account_statment(Request $re)
    {
        $re->validate([
            'date_from' => 'required',
            'date_to' => 'required',
            'repo' => 'required'
        ], [
            'date_from.required' => 'التاريخ مطلوب',
            'date_to.required' => 'التاريخ مطلوب',
            'store.required' => 'المشرف مطلوب'
        ]);

        $date_from = new DateTime($re->input('date_from'));
        $date_to = new DateTime($re->input('date_to'));

        $date_from = $date_from->format('Y-m-d H:i:s');
        $date_to = $date_to->format('Y-m-d H:i:s');

        $repo = User::where('id', '=', $re->input('repo'))->first('name');
        $deposet = Deposet_Dissmisal::where('repo_id', '=', $re->input('repo'))->whereBetween('created_at', [$date_from, $date_to])->get();

        return view('reports.alnajma.repo_account_statment', ['deposet' => $deposet, 'repo' => $repo]);
    }

    public function edit_admin_dissmisal_form($id)
    {
        $deposet_dissmisal = Deposet_Dissmisal::where('id', '=', $id)->first();
        $user = User::where('id', '=', $deposet_dissmisal->repo_id)->first();
        return view('reports.alnajma.edit_admin_dissmisal_form', ['deposet_dissmisal' => $deposet_dissmisal, 'user' => $user]);
    }

    public function edit_admin_dissmisal(Request $re, $id)
    {
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required',
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'info.required' => 'الوصف مطلوب',
        ]);
        $deposet_dissmisal = Deposet_Dissmisal::where('id', '=', $id)->first();
        $admin = User::where('id', '=', $deposet_dissmisal->repo_id)->first();
        $alnajma = User::where('id', '=', $deposet_dissmisal->users_id)->first();
        
        if($re->input('ammount') != $deposet_dissmisal->ammount){
            $def = $re->input('ammount') - $deposet_dissmisal->ammount;
            $def = abs($def);

                if($deposet_dissmisal->type == 0){
                    if($re->input('ammount') < $deposet_dissmisal->ammount){
                        if($def > $admin->balance){
                            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
                        }else{
                            $alnajma->balance += $def;
                            $admin->balance -= $def;
                        }
                    }else{
                        if($def > $alnajma->balance){
                            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
                        }else{
                            $alnajma->balance -= $def;
                            $admin->balance += $def;
                        }
                    }
                }else{
                    if($re->input('ammount') > $deposet_dissmisal->ammount){
                        if($def > $admin->balance){
                            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
                        }else{
                            $alnajma->balance += $def;
                            $admin->balance -= $def;
                        }
                    }else{
                        if($def > $alnajma->balance){
                            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
                        }else{
                            $alnajma->balance -= $def;
                            $admin->balance += $def;
                        }
                    }
                }
                $deposet_dissmisal->ammount = $re->input('ammount');
                $deposet_dissmisal->info = $re->input('info');
    
                $deposet_dissmisal->save();
                $alnajma->save();
                $admin->save();

                return redirect()->back()->with('messege', 'تم التعديل بنجاح');
            }
        return redirect()->back()->with('messege', 'تم التعديل بنجاح');
    }

    public function edit_alnajma_adds_form($id)
    {
        $deposet_dissmisal = Deposet_Dissmisal::where('id', '=', $id)->first();
        return view('reports.alnajma.edit_alnajma_adds_form', ['deposet_dissmisal' => $deposet_dissmisal]);
    }

    public function edit_alnajma_adds(Request $re, $id)
    {
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required',
            'data_file' => 'mimes:pdf',
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'ammount.min' => 'القيمة يجب ان تكون موجبة',
            'info.required' => 'الوصف مطلوب',
            'data_file.mimes' => 'ملف الايداع يجب ان يكون نوع PDF',
        ]);

        $deposet_dissmisal = Deposet_Dissmisal::where('id', '=', $id)->first();
        $alnajma = User::where('id', '=', $deposet_dissmisal->users_id)->first();

        if($re->hasfile('data_file')){
            unlink('deposet_files/'.$deposet_dissmisal->file);
            $file = $re->file('data_file');
            $ecxtntion = $file->getClientOriginalExtension();
            $filename = time().'.'.$ecxtntion;
            $file->move('deposet_files/', $filename);
            $deposet_dissmisal->file = $filename;
        }
        
        if($re->input('ammount') != $deposet_dissmisal->ammount){
            $def = $re->input('ammount') - $deposet_dissmisal->ammount;
            $def = abs($def);
            
            if($deposet_dissmisal->type == 0){
                if($re->input('ammount') < $deposet_dissmisal->ammount){
                    $alnajma->store_balance += $def;
                }else{
                    if($def <= $alnajma->store_balance){
                        $alnajma->store_balance -= $def;
                    }else{
                        return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
                    }
                }
            }else{
                if($re->input('ammount') > $deposet_dissmisal->ammount){
                    $alnajma->balance += $def;
                }else{
                    if($def <= $alnajma->balance){
                        $alnajma->balance -= $def;
                    }else{
                        return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
                    }
                }
            }
        }
        
        $deposet_dissmisal->ammount = $re->input('ammount');
        $deposet_dissmisal->info = $re->input('info');

        $deposet_dissmisal->save();
        $alnajma->save();

        return redirect()->back()->with('messege', 'تم التعديل بنجاح');
    }

    public function repo_adds_form()
    {
        $repo = User::where('role', '=', 1)->get(['name', 'id']);
        return view('reports.admin.repo_adds_form', ['repo' => $repo]);
    }

    public function repo_adds(Request $re)
    {
        $re->validate([
            'date_from' => 'required',
            'date_to' => 'required',
            'repo' => 'required'
        ], [
            'date_from.required' => 'التاريخ مطلوب',
            'date_to.required' => 'التاريخ مطلوب',
            'repo.required' => 'المندوب مطلوب'
        ]);

        $date_from = new DateTime($re->input('date_from'));
        $date_to = new DateTime($re->input('date_to'));

        $date_from = $date_from->format('Y-m-d H:i:s');
        $date_to = $date_to->format('Y-m-d H:i:s');

        if($re->input('repo') == 'all'){
            $deposet_dissmisal = Deposet_Dissmisal::where('users_id', '=', auth()->user()->id)->whereBetween('created_at', [$date_from, $date_to])->with('User')->get();
        }else{
            $deposet_dissmisal = Deposet_Dissmisal::where('users_id', '=', auth()->user()->id)->where('repo_id', '=', $re->input('repo'))->whereBetween('created_at', [$date_from, $date_to])->with('User')->get();
        }
        
        return view('reports.admin.repo_adds', ['deposet_dissmisal' => $deposet_dissmisal]);
    }

    public function edit_store_dissmisal_deposet_form($id)
    {
        $recipt = Ricept::where('id', '=', $id)->first();
        $store = Stores::where('id', '=', $recipt->stores_id)->first();
        return view('reports.repos.edit_store_dissmisal_deposet_form', ['recipt' => $recipt, 'store' => $store]);
    }

    public function edit_store_dissmisal_deposet(Request $re, $id)
    {
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required',
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'info.required' => 'الوصف مطلوب',
        ]);
        $recipt = Ricept::where('id', '=', $id)->first();
        $repo = User::where('id', '=', $recipt->users_id)->first();
        $store = Stores::where('id', '=', $recipt->stores_id)->first();
        
        if($re->input('ammount') != $recipt->ammount){
            $def = $re->input('ammount') - $recipt->ammount;
            $def = abs($def);

            if($recipt->type == 0){
                if($re->input('ammount') < $recipt->ammount){
                    if($def > $store->balance){
                        return redirect()->back()->withErrors(['low_balance' => 'لايوجد رصيد كافي'])->withInput();
                    }else{
                        $repo->portal_balance += $def;
                        $store->balance -= $def;
                    }
                }else{
                    if($def > $repo->portal_balance){
                        return redirect()->back()->withErrors(['low_balance' => 'لايوجد رصيد كافي'])->withInput();
                    }else{
                        $repo->portal_balance -= $def;
                        $store->balance += $def;
                    }
                }
            }else{
                if($re->input('ammount') > $recipt->ammount){
                    if($def > $store->balance){
                        return redirect()->back()->withErrors(['low_balance' => 'لايوجد رصيد كافي'])->withInput();
                    }else{
                        $repo->store_balance += $def;
                        $store->balance -= $def;
                    }
                }else{
                    if($def > $repo->store_balance){
                        return redirect()->back()->withErrors(['low_balance' => 'لايوجد رصيد كافي'])->withInput();
                    }else{
                        $repo->store_balance -= $def;
                        $store->balance += $def;
                    }
                }
            }
        }

        $recipt->ammount = $re->input('ammount');
        $recipt->info = $re->input('info');

        $recipt->save();
        $repo->save();
        $store->save();

        return redirect()->back()->with('messege', 'تم التعديل بنجاح');
    }

    public function edit_repo_dissmisal_form($id)
    {
        $deposet_dissmisal = Deposet_Dissmisal::where('id', '=', $id)->first();
        $user = User::where('id', '=', $deposet_dissmisal->repo_id)->first();
        return view('reports.admin.edit_repo_dissmisal_form', ['user' => $user, 'deposet_dissmisal' => $deposet_dissmisal]);
    }

    public function edit_repo_dissmisal(Request $re, $id)
    {
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required',
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'info.required' => 'الوصف مطلوب',
        ]);

        $deposet_dissmisal = Deposet_Dissmisal::where('id', '=', $id)->first();
        $user = User::where('id', '=', $deposet_dissmisal->repo_id)->first();
        $admin_id = Auth::user();
        $admin = User::where('id', '=', $admin_id->id)->first();

        if($re->input('ammount') != $deposet_dissmisal->ammount){
            $def = $re->input('ammount') - $deposet_dissmisal->ammount;
            $def = abs($def);

            if($re->input('ammount') < $deposet_dissmisal->ammount){
                $admin->balance += $def;
                $user->balance -= $def;
                $user->portal_balance -= $def;
            }else{
                if($def <= $admin->balance){
                    $admin->balance -= $def;
                    $user->balance += $def;
                    $user->portal_balance += $def;
                }else{
                    return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
                }
            }
        }

        $deposet_dissmisal->ammount = $re->input('ammount');
        $deposet_dissmisal->info = $re->input('info');

        $deposet_dissmisal->save();
        $user->save();
        $admin->save();

        return redirect()->back()->with('messege', 'تم التعديل بنجاح');
    }

    public function get_repo_stores_balance($id)
    {
        try{
            $stores = Stores::where('users_id', '=', $id)->get();
            $ammount = 0;
            foreach($stores as $s){
                $ammount += $s->balance;
            }
        }catch(Exception $e){
            return redirect()->back()->withErrors(['not_found' => 'لا يوجد محلات لدى المندوب'])->withInput();
        }
        return view('stores.stores_index', ['stores' => $stores, 'ammount' => $ammount]);
    }

    public function get_repo_stores_balance_report($id)
    {
        $store = Stores::where('id', '=', $id)->first();
        $repo = User::where('id', '=', $store->users_id)->first();

        $receipt = Ricept::where('stores_id', '=', $store->id)->where('users_id', '=', $repo->id)
        ->latest()->take(200)->orderByDesc('created_at')->paginate(10);

        return view('reports.repos.store_account', ['receipt' => $receipt, 'store' => $store]);
    }

    public function repos_salary_from()
    {
        $repo = User::where('role', '=', 1)->get(['name', 'id']);
        return view('reports.repos_salary', ['repo' => $repo]);
    }

    public function repos_salary(Request $re)
    {
        $re->validate([
            'month' => 'required',
            'repo' => 'required'
        ], [
            'month.required' => 'يرجى ادخال التاريخ',
            'repo.required' => 'يرجى اختيار المندوب',
        ]);
        $month = Carbon::parse($re->input('month'));

        $store_topup = Stores::where('users_id', '=', $re->input('repo'))->with('Ricept', function($q) use ($month){
            $currentMonth = Carbon::parse($month);
            $q->whereMonth('created_at', $currentMonth)->where('type', '=', 0);
        })->get();
        
        $topup_co = 0;
        $store_ammount = 0;
        $stores_value = [];
        $repo_salary = 0;
        $class_A = 0;
        $class_B = 0;

        foreach($store_topup as $store){
            foreach($store->Ricept as $r){
                if(isset($r->ammount)){
                    $store_ammount += $r->ammount;
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

        $nam = $re->input('repo');
        $users = User::where('id', '=', $nam)->first();

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
}
