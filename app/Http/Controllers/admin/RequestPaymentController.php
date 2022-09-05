<?php

namespace App\Http\Controllers\admin;

use App\Enums\RequestStatus;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = PaymentRequest::with('user:id,name,money')->latest();

        if($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if($request->has('request_date') && $request->request_date != '') {
            $query->where(DB::raw("(DATE_FORMAT(request_date,'%Y-%m-%d'))"), $request->request_date);
        }

        $paymentRequest = $query->orderBy('created_at', 'DESC')->paginate(10);
        $paymentRequestStatus = RequestStatus::asArray();

        return view('admin.request_payments.index', [
            'paymentRequest' => $paymentRequest,
            'paymentRequestStatus' => $paymentRequestStatus,
            'selectedStatus' => $request->status,
            'requestDate' => $request->request_date
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        $status = RequestStatus::asArray();

        return view('admin.request_payments.detail', compact('paymentRequest', 'status'));
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
        $request->validate([
            'status' => ['required', new EnumValue(RequestStatus::class, false)],
        ]);

        $paymentRequest = PaymentRequest::find($id);
        $paymentRequest->status = $request->status;
        $paymentRequest->reject_cause = $request->reject_cause;
        $paymentRequest->save();

        return back()->withInput()->with('message', 'Update payment request success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approval($id) {
        $paymentRequest = PaymentRequest::find($id);
        $user = User::find($paymentRequest->user_id);
        if($paymentRequest->status == RequestStatus::REQUEST) {
            $paymentRequest->status = RequestStatus::APPROVE;
            $paymentRequest->payment_date = Carbon::now();
            $paymentRequest->save();

            $user->money -= $paymentRequest->amount;
            $user->save();

            return back()->withInput()->with('message', 'Approval payment request successfully!');
        }
        return back()->withInput()->with('error', 'Payment request status has been approved or rejected!');
    }

    public function reject(Request $request) {
        // $request->validate([
        //     'rejectCause' => 'required',
        // ]);

        $id = $request->paymentRequestId;

        $paymentRequest = PaymentRequest::find($id);
        if ($paymentRequest->status == RequestStatus::REQUEST) {
            $paymentRequest->status = RequestStatus::REJECT;
            $paymentRequest->reject_cause = $request->rejectCause;
            $paymentRequest->payment_date = Carbon::now();
            $paymentRequest->save();

            return back()->withInput()->with('message', 'Reject payment request successfully!');
        }
        return back()->withInput()->with('error', 'Payment request status has been approved or rejected!');
    }
}
