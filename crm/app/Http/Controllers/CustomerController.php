<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use DB;
class CustomerController extends Controller
{
    public function getCustomers(Request $request){
        $customers=Customer::get();
        return ['status'=>true,'customers'=>$customers];
    }
    public function updateCustomerDetails(Request $request){

        $input=$request->all();

        $customer=Customer::find($input['id']);
        $customer->name=$input['name'];
        $customer->save();

        return ['status'=>true,'customer'=>$customer];
    }
    public function saveCustomerDetails(Request $request){

        $input=$request->all();

        $customer=new Customer;
        $customer->name=$input['name'];
        $customer->save();

        return ['status'=>true,'customer'=>$customer];
    }
     public function removeCustomer(Request $request){
        $input=$request->all();
        
        Customer::where('id',$input['id'])->delete();

            $customers=Customer::get();
        return ['status'=>true,'customers'=>$customers];

    }
     public function getCustomerDetails(Request $request){
        $customer_details=Customer::find($request->all()['id']);
        return ['status'=>true,'customer_details'=>$customer_details];
    }
     public function searchCustomerByName(Request $request){
        $customers=Customer::whereRaw("name LIKE '%".$request->name."%'")->get();
        return ['status'=>true,'customers'=>$customers];
    }
}
