<?php

namespace App\Http\Controllers\home\affiliator;

use App\Enums\RequestStatus;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RequestPayment;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affiliator = auth()->user();
        return view('home.affiliator.request_payments.index', compact('affiliator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $affiliator = auth()->user();
        $affiliator_id = $affiliator->id;
        $money = $request->money;
        (int)$now = date("m-Y");
        $day_request = DB::table('payment_request')->where('user_id', $affiliator_id)->orderBy('id', 'DESC')->first();

        if($money > 0 && $money <= $affiliator->money){
            if($day_request == null){
                PaymentRequest::create([
                    'user_id' => $affiliator->id,
                    'amount' => $money,
                    'request_date' => now(),
                    'status' => RequestStatus::REQUEST
                ]);
                return back()->with('success', 'Request payment success');
            }else{
                if(($now != date("m-Y", strtotime($day_request->request_date)) || ($day_request->status == RequestStatus::REJECT))){
                    PaymentRequest::create([
                        'user_id' => $affiliator->id,
                        'amount' => $money,
                        'request_date' => now(),
                        'status' => RequestStatus::REQUEST
                    ]);
                    return back()->with('success', 'Request payment success');
                }else{
                    return redirect()->back()->with('error', 'You have already requested a withdrawal this month!');
                }
            }

        }else{
            return back()->with('error', 'Can\'t be greater than the amount available or can\'t be empty!!');
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
        $rq = PaymentRequest::where('id',$id)->first();
        return view('home.affiliator.request_payments.detail',compact('rq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $req = PaymentRequest::find($id);
        if ($req->status == \App\Enums\RequestStatus::REQUEST) {
            $affiliator = auth()->user();
            return view('home.affiliator.request_payments.index', compact('affiliator','req'));
        }else{
            return redirect()->back();
        }

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
        $req = PaymentRequest::find($id);
        $data = $request->all();
        if ($data['money'] <= auth()->user()->money) {
            $req->amount = $data['money'];
            $req->updated_at = now();
            $req->save();
            return back()->with('success', 'Update request payment success');
        }else{
            return back()->with('error', 'Request payment fail!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rq = PaymentRequest::where('id',$id)->first();
        if ($rq->status == \App\Enums\RequestStatus::REQUEST) {
            $rq->delete();
            return redirect()->route('user.request-history');
        }else{
            return redirect()->back();
        }
    }

    public function requestHistory()
    {
        $user_id = auth()->user()->id;
        $requestPayment = PaymentRequest::latest()->where('user_id', $user_id)->get();
        return view('home.affiliator.request_payments.history', compact('requestPayment'));
    }
}
