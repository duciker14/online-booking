<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        $bank = BankAccount::join('users', 'bank_account.user_id', '=', 'users.id')
        ->select('bank_account.*','users.name as username')
        ->where('users.id', '=', auth()->user()->id )
        ->first();

        return view('manager.profiles.bankAccount', compact('bank'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|min:10',
            'branch' => 'required'
        ]);
        DB::table('bank_account')->updateOrInsert([
            'user_id' => auth()->user()->id,
        ],[
            'name' => $request->name,
            'code' => $request->code,
            'branch' => $request->branch,
        ]);

        return back()->withInput()->with('message', 'Update bank account success!');
    }
}
