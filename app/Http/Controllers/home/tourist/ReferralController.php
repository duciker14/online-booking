<?php

namespace App\Http\Controllers\home\tourist;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index() {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        $userReferred = User::where('affiliator_ref', $user->id)->paginate(10);

        return view('home.tourist.profiles.referral', compact('user', 'userReferred'));
    }
}
