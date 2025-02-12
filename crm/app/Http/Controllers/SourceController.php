<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;
use DB;
class SourceController extends Controller
{
    public function getSources(Request $request){
        $sources=Source::get();
        return ['status'=>true,'sources'=>$sources];
    }
    public function updateSourceDetails(Request $request){

        $input=$request->all();

        $source=Source::find($input['id']);
        $source->name=$input['name'];
        $source->save();

        return ['status'=>true,'source_details'=>$source];
    }
    public function saveSourceDetails(Request $request){

        $input=$request->all();

        $source=new Source;
        $source->name=$input['name'];
        $source->save();

        return ['status'=>true,'source_details'=>$source];
    }
     public function removeSource(Request $request){
        $input=$request->all();
        
        Source::where('id',$input['id'])->delete();

            $sources=Source::get();
        return ['status'=>true,'sources'=>$sources];

    }
     public function getSourceDetails(Request $request){
        $source_details=Source::find($request->all()['id']);
        return ['status'=>true,'source_details'=>$source_details];
    }
}
