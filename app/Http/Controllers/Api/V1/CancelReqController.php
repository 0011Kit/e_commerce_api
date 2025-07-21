<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CancelReq;
use App\Models\Order;

class CancelReqController extends Controller
{
    public function pendingApproveList(Request $request){
        $sellerId = $request->user('seller')->seller_no;

        $requests = CancelReq::where('seller_no', $sellerId)
            ->where('status', 'PENDING')
            ->with('order')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Pending Approval List retrieved successfully.',
            'data' => $requests
        ]);
    }

    public function approveCancel(Request $request){
        $request->validate([
            'reqNo' => 'required|exists:order_cancellation_requests,cancel_appr_no',
            'approve' => 'required|boolean'
        ]);

        $approve = $request->approve? "APPROVED" : "REJECTED";

        $cancelRequest = CancelReq::where('cancel_appr_no', $request->reqNo)->first();

        if ($cancelRequest->status !== 'PENDING') {
            return response()->json(['message' => 'Already processed.'], 400);
        }

        $seller = $request->user('seller');

        $cancelRequest->status = $approve;
        $cancelRequest->approved_at = now();
        $cancelRequest->save();

        $order = Order::where('order_no', $cancelRequest->order_no)->first();

        if ($order) {
            $order->order_status = $approve == "APPROVED"? "C" : "D";
            $order->cancel_approval_date = now();
            $order->cancel_approved_by = $seller->seller_no;
            $order->save();
        }

        return response()->json([
            'message' => 'Cancellation Status updated successfully. ',
            'data' => [
                'seller decision' => $approve,
                'order' => $order
            ]
        ]);
    }
}
