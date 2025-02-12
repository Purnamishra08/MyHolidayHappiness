<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use DB;
class StatusController extends Controller
{
    public function getStatuses(Request $request){
        $statusList=Status::get();
        return ['status'=>true,'statusList'=>$statusList];
    }
    public function updateStatusDetails(Request $request){

        $input=$request->all();

        $status=Status::find($input['id']);
        $status->name=$input['name'];
        $status->save();

        return ['status'=>true,'status_details'=>$status];
    }
    public function saveStatusDetails(Request $request){

        $input=$request->all();

        $status=new Status;
        $status->name=$input['name'];
        $status->save();

        return ['status'=>true,'status_details'=>$status];
    }
     public function removeStatus(Request $request){
        $input=$request->all();
        
        Status::where('id',$input['id'])->delete();

            $statusList=Status::get();
        return ['status'=>true,'statusList'=>$statusList];

    }
     public function getStatusDetails(Request $request){
        $status=Status::find($request->all()['id']);
        return ['status'=>true,'status_details'=>$status];
    }
}
