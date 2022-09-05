<?php

namespace App\Http\Controllers\admin;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::where('role', UserRole::MANAGER);

        $list = $query->orderBy('created_at', 'DESC')->get();

        return view('admin.users.index',compact('list'));
    }

    public function listTourist() {
        $query = User::where('role', UserRole::TOURIST);

        $listTourist = $query->orderBy('created_at', 'DESC')->get();

        return view('admin.users.list-tourist', compact('listTourist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.form');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $checkmail = User::where('email',$data['email'])->count();
        if ($checkmail == 0) {
            $user = new User();
            $hotel = new Hotel();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->status = UserStatus::ENABLED;
            $user->role = UserRole::MANAGER;
            $user->password = Hash::make($data['password']);
            $hotel->name = $data['hotel'];
            // $user->name = $data['repassword'];
            $user->save();
            $hotel->user_id = $user->id;
            $hotel->save();
            $list = User::all();
            Mail::send('mails.info_user', array('name'=>$data['name'],'email'=>$data['email'], 'password'=> $data['password']), function($message)use ($request){
                $message->to($request->email, 'Service Hotel')->subject('Register Account Manager');
            });
            return redirect(route('users.index'))->with('success','Create Successfully');
        }else{
            return redirect()->back()->with('error','Create Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $listPayment = PaymentRequest::where('user_id', $id)->get();

        return view('admin.users.detail',compact('user', 'listPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        //dd($user);
         return view('admin.users.form',compact('user'));
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
        $data = $request->all();
        $user = User::find($id);
        $user->name = $data['name'];
        // $user->email = $data['email'];
        // $user->password = Hash::make($data['password']);
        // $user->name = $data['repassword'];
        $user->role = $data['role'];
        $user->save();
        $list = User::where('role','<>','0')->orderBy('created_at','DESC')->get();
        return view('admin.users.index',compact('list'));
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $user  = User::find($id)->delete();
        // $list = User::all();
        $booking = Booking::where('user_id', $id)->get();
        if(count($booking)>0){
            return redirect(route('users.index'))->with('error', 'Delete failed');
        }else{
            User::find($id)->delete();
            return redirect(route('users.index'))->with('success', 'Delete Successfully');;
        }
    }
    public function change_active($id){
        $user = User::find($id);
        if ($user->status == 0) {
            $user->status =1;
        }else{
            $user->status =0;
        }
        $user->save();
        $list = User::where('role','<>','0')->orderBy('created_at','DESC')->get();
        return view('admin.users.index',compact('list'));
    }

}
