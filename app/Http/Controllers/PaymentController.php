<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return response()->json(['message' => 'payments listed successfully', 'payments' => $payments]);
    }

    public function store(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'booking_id'=> 'required',

                'payment_method' => 'required|string',
                'file_upload' => 'required|file',
                'bank' => 'required|string|min:3|max:75',
                'account_title' => 'required|string|min:3|max:75',
                'account_number' => 'required|integer',
//                'status' => 'required|string',
            ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $payment = Payment::create($request->all());
        $payment->save();
        return response()->json([
            'message' => ' payment created successfully','payment' => $payment],
            201);

    }
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json(['message' => 'payment listed successfully', 'payment' => $payment]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'=> 'required',

            'payment_method' => 'required|string',
            'file_upload' => 'required|file',
            'bank' => 'required|string|min:3|max:75',
            'account_title' => 'required|string|min:3|max:75',
            'account_number' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $payment = Payment::findOrFail($id);
        $payment->update($validator);

        return response()->json(['message' => 'payment updated successfully', 'payment' => $payment]);
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return response()->json(['message' => 'payment deleted successfully']);
    }
}
