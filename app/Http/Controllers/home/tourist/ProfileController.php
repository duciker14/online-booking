<?php

namespace App\Http\Controllers\home\tourist;

use App\Enums\UserGender;
use App\Http\Controllers\Controller;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $gender = UserGender::asArray();

        return view('home.tourist.profiles.index', compact('user', 'gender'));
    }

    public function updateProfile(Request $request, $id) {
        $user = User::find($id);

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required',
            'address' => 'required|string',
            'gender' => ['required', new EnumValue(UserGender::class, false)],
            'birthday' => 'required|date',
        ]);

        $data = $request->all();
        $user->name = $data['username'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->gender = $data['gender'];
        $user->birthdate = $data['birthday'];
        $avatar = $request->file('avatar');

        if ($avatar) {
            if (!empty($user->avatar)) {
                unlink('img/users/' . $user->avatar);
            }
            $get_name_image = $avatar->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move('img/users/', $new_image);
            $user->avatar = $new_image;
        }
        $user->save();

        return back()->withInput()->with('msg', 'Update profile successfully!');
    }
}
