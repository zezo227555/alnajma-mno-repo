<?php

namespace App\Http\Controllers;

use App\Models\Ricept;
use App\Models\Stores;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $stores = Stores::where('users_id', '=', $user->id)->with('Ricept', function($q){
            $currentMonth = Carbon::now()->month;
            $q->whereMonth('created_at', $currentMonth)->where('type', '=', 0);
        })->get();
        $ammount = 0;
        foreach($stores as $s){
            $ammount += $s->balance;
        }

        return view('stores.stores_index', ['stores' => $stores, 'ammount' => $ammount]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $re)
    {
        $re->validate([
            'name' => 'required|min:3|max:255',
            'phone' => 'required|unique:stores,phone|regex:/^09[0-5]-[0-9]{7}/',
        ], [
            'name.required' => 'الاسم مطلوب',
            'phone.regex' => 'يجب على رقم الهاتف ان يكون بالصيغة التالية (09X-XXXXXXX)',
            'phone.required' => 'رقم الهاتف مطلوب',
        ]);

        $store = new Stores();
        $user = Auth::user();

        $store->name = $re->input('name');
        $store->phone = $re->input('phone');
        $store->users_id = $user->id;

        $store->save();

        return redirect(route('stores.index'))->with('massege', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stores $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($store_id)
    {
        $store = Stores::where('id', '=', $store_id)->first();
        return view('stores.stores_edit', ['store' => $store]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $re, $store_id)
    {
        $re->validate([
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/^09[0-5]-[0-9]{7}/',
        ], [
            'name.required' => 'الاسم مطلوب',
            'phone.regex' => 'يجب على رقم الهاتف ان يكون بالصيغة التالية (09X-XXXXXXX)',
            'phone.required' => 'رقم الهاتف مطلوب',
        ]);
        $store = Stores::where('id', '=', $store_id)->first();

        if($re->input('phone' != $store->phone)){
            $re->validate([
                'phone' => 'unique:stores,phone'
            ], [
                'phone.unique' => 'رقم الهاتف موجود مسبقا'
            ]);
        }

        $store->name = $re->input('name');
        $store->phone = $re->input('phone');
        $store->save();

        return redirect(route('stores.edit', $store_id))->with('message', 'تم التعديل بنجاح');
    }

    public function store_deposet_form($store_id){
        $store = Stores::where('id', '=', $store_id)->first();
        return view('stores.store_deposet_form', ['store' => $store]);
    }

    public function store_deposet(Request $re ,$store_id){
        try{
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required'
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'info.required' => 'الوصف مطلوب'
        ]);

        $store = Stores::where('id', '=', $store_id)->first();
        $user_id = Auth::user();
        $user = User::where('id', '=', $user_id->id)->first();

        $ricept = new Ricept();

        if($re->input('ammount') > $store->balance){
            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
        }

        $ricept->ammount = $re->input('ammount');
        $ricept->info = $re->input('info');
        $ricept->stores_id = $store->id;
        $ricept->users_id = $user->id;
        $ricept->type = true;
        
        $store->balance -= $re->input('ammount');
        $user->store_balance += $re->input('ammount');

        $ricept->save();
        $store->save();
        $user->save();

        return redirect(route('store.store_deposet_form', $store->id))->with('messege', 'تم اضافة الايصال بنجاح');
    }catch(ValidationException){
        return back()->withInput()->withErrors(['error' => 'حدث خطأ']);
    }
    }

    public function store_dissmisal_form($store_id){
        $store = Stores::where('id', '=', $store_id)->first();
        return view('stores.store_dissmisal_form', ['store' => $store]);
    }

    public function store_dissmisal(Request $re ,$store_id){
        try{
        $re->validate([
            'ammount' => 'required|min:0',
            'info' => 'required'
        ], [
            'ammount.required' => 'القيمة مطلوبة',
            'info.required' => 'الوصف مطلوب'
        ]);

        $store = Stores::where('id', '=', $store_id)->first();
        $user_id = Auth::user();
        $user = User::where('id', '=', $user_id->id)->first();

        if($re->input('ammount') > $user->portal_balance){
            return redirect()->back()->withErrors(['big_ammount' => 'لا يوجد رصيد كافي'])->withInput();
        }

        $ricept = new Ricept();

        $ricept->ammount = $re->input('ammount');
        $ricept->info = $re->input('info');
        $ricept->stores_id = $store->id;
        $ricept->users_id = $user->id;
        $ricept->type = false;
        
        $store->balance += $re->input('ammount');
        $user->portal_balance -= $re->input('ammount');

        $ricept->save();
        $store->save();
        $user->save();

        return redirect(route('store.store_dissmisal_form', $store->id))->with('messege', 'تم اضافة الايصال بنجاح');
    }catch(ValidationException){
        return back()->withInput()->withErrors(['error' => 'حدث خطأ']);
    }
    }


}
