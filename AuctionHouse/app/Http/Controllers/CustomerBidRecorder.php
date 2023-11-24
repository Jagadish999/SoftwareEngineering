<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerBid;

class CustomerBidRecorder extends Controller
{
    public function updateStatusByAdminAction(Request $request){


        $postData = $request->json()->all();

        $categoryId = $postData['categoryId'];
        $status = $postData['status'];

        $bidInformation = CustomerBid::find($categoryId);

        $bidInformation->status = $status;

        if($bidInformation->status == "Rejected"){
            $bidInformation->delete();
        }
        else{
            $bidInformation->save();
        }
    }

    public function insertCustomerBids(Request $request){

        $postData = $request->json()->all();

        $userBidAmt = $postData['bidAmount'];
        $userEmail = $postData['email'];
        $userMessage = $postData['message'];
        $userPhone = $postData['phone'];
        $status = "Unapproved";

        CustomerBid::create([
            'user_id' => auth()->user()->id,
            'product_id' => $postData['productId'],
            'userBidAmt' => $userBidAmt,
            'userEmail' => $userEmail,
            'userMessage' => $userMessage,
            'userPhone' => $userPhone,
            'status' => $status,
        ]);

    }
}
