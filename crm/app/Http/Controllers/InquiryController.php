<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Source;
use App\Models\Inquiry;
use App\Models\Status;
use App\Models\Customer;

use DB;

class InquiryController extends Controller
{
    
    public function getInquiries(Request $request){
        $input=$request->all();
        $inquiries=Inquiry::get();

        $inquiries->map(function($inquiry){
            $inquiry['source_name']=Source::find($inquiry->source_id)['name']??'';
            $inquiry['status_name']=Status::find($inquiry->status_id)['name']??'';
            $inquiry['name']=User::find($inquiry->user_id)['name']??'';

        });
        return ['status'=>true,'inquiries'=>$inquiries];
    }
    
    
     public function searchInquiries(Request $request){
        $input=$request->all();
        
        
        $inquiries=Inquiry::orderBy('id','asc');
        if(isset($input['customer_name'])){
            $inquiries=$inquiries->where('customer_name', 'like', '%'.$input['customer_name'].'%');
        }
        if(isset($input['phone_number'])){
            $inquiries=$inquiries->where('phone_number', 'like', '%'.$input['phone_number'].'%');
        }

       if(isset($input['type'])){     
        if($input['type']=='Creation Date' && isset($input['creation_date']) && isset($input['creation_date'][0]) && isset($input['creation_date'][1]) ){
            if(isset($input['creation_date'][0]) && isset($input['creation_date'][1])){
                $inquiries=$inquiries->whereBetween('created_at', [date('Y-m-d 00:00:00',strtotime($input['creation_date'][0])), date('Y-m-d 23:59:59',strtotime($input['creation_date'][1]))]);
            }elseif(isset($input['creation_date'][0]) && !isset($input['creation_date'][1])){
                $inquiries=$inquiries->whereDate('created_at', '>=', date('Y-m-d 00:00:00',strtotime($input['creation_date'][0])));
            }elseif(!isset($input['creation_date'][0]) && isset($input['creation_date'][1])){
                $inquiries=$inquiries->whereDate('created_at', '<=', date('Y-m-d 23:59:59',strtotime($input['creation_date'][1])));
            }
             
        }
        
        if($input['type']=='Followup Date' && isset($input['followup_date']) && isset($input['followup_date'][0]) && isset($input['followup_date'][1]) ){
            if(isset($input['followup_date'][0]) && isset($input['followup_date'][1])){
                $inquiries=$inquiries->whereBetween('followup_date', [date('Y-m-d 00:00:00',strtotime($input['followup_date'][0])), date('Y-m-d 23:59:59',strtotime($input['followup_date'][1]))]);
            }elseif(isset($input['followup_date'][0]) && !isset($input['followup_date'][1])){
                $inquiries=$inquiries->whereDate('followup_date', '>=', date('Y-m-d 00:00:00',strtotime($input['followup_date'][0])));
            }elseif(!isset($input['followup_date'][0]) && $isset(input['followup_date'][1])){
                $inquiries=$inquiries->whereDate('followup_date', '<=', date('Y-m-d 23:59:59',strtotime($input['followup_date'][1])));
            }
             
        }
       }
        
        
        $inquiries=$inquiries->get();

        $inquiries->map(function($inquiry){
            $inquiry['source_name']=Source::find($inquiry->source_id)['name']??'';
            $inquiry['status_name']=Status::find($inquiry->status_id)['name']??'';
            $inquiry['name']=User::find($inquiry->user_id)['name']??'';

        });
        return ['status'=>true,'inquiries'=>$inquiries];
    }
     public function getReportsByFollowupDate(Request $request){
        $input=$request->all();
        $summaries=Inquiry::whereDate('followup_date', '=', date('Y-m-d',strtotime($input['followup_date'])))
                            ->join('statuses','statuses.id','inquiries.status_id')
                            ->selectRaw('count(inquiries.id) as customer_count, statuses.name ')
                            ->groupBy('statuses.name')->get();

        
        
        $inquiries=Inquiry::whereDate('followup_date', '=', date('Y-m-d',strtotime($input['followup_date'])))->get();

        $inquiries->map(function($inquiry){
            $inquiry['source_name']=Source::find($inquiry->source_id)['name']??'';
            $inquiry['status_name']=Status::find($inquiry->status_id)['name']??'';
            $inquiry['name']=User::find($inquiry->user_id)['name']??'';

        });
        return ['status'=>true,'inquiries'=>$inquiries,'summaries'=>$summaries];
    }
    
    // public function changeStatusOfCandidate(Request $request){

    //     $input=$request->all();

    //     $candidate_details=CandidateDetail::find($input['candidate_id']);
    //     $candidate_details->candidate_status=$input['status'];
    //     $candidate_details->save();

    //       return ['status'=>true];  
    // }
    
    public function updateInquiryDetails(Request $request){
        $input=$request->all();
       
       
            //CandidateDetail
            $inquiry_details=Inquiry::find($input['id']);
            $inquiry_details->customer_name=$input['customer_name'];
            $inquiry_details->email_address=$input['email_address'];
            $inquiry_details->phone_number=$input['phone_number'];
            $inquiry_details->status_id=$input['status_id'];
            $inquiry_details->source_id=$input['source_id'];
            $inquiry_details->trip_name=$input['trip_name'];
            $inquiry_details->trip_start_date=date('Y-m-d H:i:s',strtotime($input['trip_start_date']));
            $inquiry_details->followup_date=date('Y-m-d H:i:s',strtotime($input['followup_date']));
            $inquiry_details->travellers_count=$input['travellers_count'];
            $inquiry_details->comments=$input['comments'];
            $inquiry_details->save();
            
            if(!Customer::where('name',$input['customer_name'])->count()){
                
                    $customer=new Customer;
                    $customer->name=$input['customer_name'];
                    $customer->save();
            }
            
            return ['status'=>true];
    }
    public function saveInquiryDetails(Request $request){
        $input=$request->all();
     
       
            //CandidateDetail
            $inquiry_details=new Inquiry;
            $inquiry_details->user_id=$input['user_id'];
            $inquiry_details->customer_name=$input['customer_name'];
            $inquiry_details->email_address=$input['email_address'];
            $inquiry_details->phone_number=$input['phone_number'];
            $inquiry_details->status_id=$input['status_id'];
            $inquiry_details->source_id=$input['source_id'];
            $inquiry_details->trip_name=$input['trip_name'];
            $inquiry_details->trip_start_date=date('Y-m-d H:i:s',strtotime($input['trip_start_date']));
            $inquiry_details->followup_date=date('Y-m-d H:i:s',strtotime($input['followup_date']));
            $inquiry_details->travellers_count=$input['travellers_count'];
            $inquiry_details->comments=$input['comments'];
            $inquiry_details->save();

          $inquiry_details->inquiry_number= 'INQ'.sprintf("%05d", $inquiry_details->id);
             $inquiry_details->save();
             
            if(!Customer::where('name',$input['customer_name'])->count()){
                
                    $customer=new Customer;
                    $customer->name=$input['customer_name'];
                    $customer->save();
            }
            return ['status'=>true];

    }
    public function getMetadataForInquiryForm(Request $request){

         $input=$request->all();
            $sources=Source::get();
            $statuses=Status::get();
            $users=User::get();
            

            return [
                'status'=>true,
                'statuses'=>$statuses,
                'sources'=>$sources,
                'users'=>$users
            ];
       

    }
    public function getInquiryDetailsForEdit(Request $request){
         $input=$request->all();


            $inquiry_details=Inquiry::find($input['id']);

            $inquiry_details['source_name']=Source::find($inquiry_details->source_id)['name']??'';
           $inquiry_details['status_name']=Status::find($inquiry_details->status_id)['name']??'';     
             $sources=Source::get();
            $users=User::get();
            $statuses=Status::get();
            
            
            return [
                'status'=>true,
                'inquiry'=>$inquiry_details,
                'sources'=>$sources,
                'statuses'=>$statuses,
                'users'=>$users
            ];
       

    }
    
    
     public function removeInquiry(Request $request){
        $input=$request->all();
        
        Inquiry::where('id',$input['id'])->delete();

            $inquiries=Inquiry::get();
        return ['status'=>true,'inquiries'=>$inquiries];

    }
}
