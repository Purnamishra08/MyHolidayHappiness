<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator,Redirect,Response;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Session;

use DB,DateTime;

use View;

use App\Models\BlogPost;

use App\Models\BlogPostMeta;

use App\Models\BlogCategory;

use App\Models\BlogSubCategory;

use App\Models\User;

use App\Models\ContactUs;

use App\Models\Referral;

use Illuminate\Support\Str;



class PageController extends Controller

{

	function __construct(){



    }

    public function index(){

          

                 $title='Synergy Wellness';

                $description='Synergy Wellness';

                $keywords='Synergy Wellness';

         
         return view('welcome',compact('title','description','keywords'));

    }

    public function aboutUs(){

           

                 $title='About Us- Synergy Wellness';

                $description='About Us- Synergy Wellness';

                $keywords='About Us- Synergy Wellness';

            

         return view('about-us',compact('title','description','keywords'));

    }
    public function contactUs(){

            

                 $title='Contact - Synergy Wellness';

                $description='Contact - Synergy Wellness';

                $keywords='Contact - Synergy Wellness';

           

         return view('contact-us',compact('title','description','keywords'));

    }
    public function testimonial(){

            

                 $title='Testimonial - Synergy Wellness';

                $description='Testimonial - Synergy Wellness';

                $keywords='Testimonial - Synergy Wellness';

           

         return view('testimonial',compact('title','description','keywords'));

    }

    public function services(){

            

                 $title='Services - Synergy Wellness';

                $description='Services - Synergy Wellness';

                $keywords='Services - Synergy Wellness';

           

         return view('services',compact('title','description','keywords'));

    }
    public function referrals(){

            

                 $title='Referrals - Synergy Wellness';

                $description='Referrals - Synergy Wellness';

                $keywords='Referrals - Synergy Wellness';

           

         return view('referrals',compact('title','description','keywords'));

    }
    public function submitContactUs(Request $request){
        $input=$request->all();

        $contactUs=new ContactUs;
        $contactUs->name= $input['name'];
        $contactUs->email= $input['email'];
        $contactUs->message= $input['message'];
        $contactUs->save();

         return redirect()->back()->with('success','Your request has been submitted successfully.');
    }

    public function submitReferrals(Request $request){
        $input=$request->all();

        $referrals=new Referral;
        $referrals->first_name= $input['first_name'];
        $referrals->last_name= $input['last_name'];
        $referrals->dob= $input['dob'];
        $referrals->email= $input['email'];
        $referrals->contact_number= $input['contact_number'];
        $referrals->address= $input['address'];
        $referrals->emerg_name= $input['emerg_name'];
        $referrals->emerg_number= $input['emerg_number'];
        $referrals->ref_agenc_name= $input['ref_agenc_name'];
        $referrals->case_manager_name= $input['case_manager_name'];
        $referrals->case_manager_number= $input['case_manager_number'];
        $referrals->case_manager_email= $input['case_manager_email'];
        $referrals->case_manager_number= $input['case_manager_number'];
        $referrals->reason_of_referral= $input['reason_of_referral'];
        $referrals->client_PMI= $input['client_PMI'];
        $referrals->guardian_name= $input['guardian_name'];
        $referrals->diagnosis_code= $input['diagnosis_code'];
        $referrals->anticipated_date= $input['anticipated_date'];
        $referrals->guardian_phone= $input['guardian_phone'];
        $referrals->save();

         return redirect()->back()->with('success','Your request has been submitted successfully.');
    }


    // public function blogs(){

    //         $domain = parse_url(request()->root())['host'];

    //         if($domain=='localhost'){

    //             $title='Synergy Wellness';

    //             $description='Synergy Wellness';

    //             $keywords='Synergy Wellness';

    //         }else{

    //              $title='Synergy Wellness';

    //             $description='Synergy Wellness';

    //             $keywords='Synergy Wellness';

    //         }

    //         $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')

    //                     ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')

    //                     ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted','summary')

    //                     ->where('status',1)

    //                     ->orderBy('created_at','desc')

    //                     ->paginate(12);



    //         $Blogs->map(function($Blog){

    //              $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();

    //         });

    //      return view('blogs',compact('title','description','keywords','Blogs'));

    // }

    // public function blogByCategory($slug){

    //         $domain = parse_url(request()->root())['host'];

    //         $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')

    //                     ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')

    //                     ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted','summary')

    //                     ->where('status',1);



    //         $BlogCategory=BlogCategory::where('slug',$slug)->first();

    //         if($BlogCategory){

    //             $BlogCategoryName=$BlogCategory->category;

    //             $Blogs=$Blogs->where('BlogCategory.category',$BlogCategory->id)

    //                     ->orderBy('created_at','desc')

    //                    ->paginate(12);

    //         }else{

    //              $BlogCategoryName="";



    //                $Blogs=$Blogs->orderBy('created_at','desc')

    //                    ->paginate(12);

    //         }



    //         if($domain=='localhost'){

    //             $title='Synergy Wellness '.$BlogCategoryName;

    //             $description='Synergy Wellness '.$BlogCategoryName;

    //             $keywords='Synergy Wellness '.$BlogCategoryName;

    //         }else{

    //              $title='Synergy Wellness';

    //             $description='Synergy Wellness';

    //             $keywords='Synergy Wellness';

    //         }



            

                        



    //         $Blogs->map(function($Blog){

    //              $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();

    //         });

    //      return view('blogs',compact('title','description','keywords','Blogs','BlogCategory','BlogCategoryName'));

    // }

    // public function blogBySubCategory($slug){

    //          $domain = parse_url(request()->root())['host'];





    //         $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')

    //                     ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')

    //                     ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted','summary')

    //                     ->where('status',1);



    //         $BlogSubCategory=BlogSubCategory::where('slug',$slug)->first();

    //         if($BlogSubCategory){

    //             $BlogCategoryName=$BlogSubCategory->subcategory;

    //             $Blogs=$Blogs->whereIn('BlogPosts.id', BlogPostMeta::where('value',$BlogCategoryName)->where('type','Sub Category')->pluck('postId')->toArray())

    //                     ->orderBy('created_at','desc')

    //                     ->paginate(1);

    //         }else{

    //              $BlogCategoryName="";



    //                $Blogs=$Blogs->orderBy('created_at','desc')

    //                     ->paginate(1);

    //         }



    //         if($domain=='localhost'){

    //             $title='Synergy Wellness '.$BlogCategoryName;

    //             $description='Synergy Wellness '.$BlogCategoryName;

    //             $keywords='Synergy Wellness '.$BlogCategoryName;

    //         }else{

    //              $title='Synergy Wellness';

    //             $description='Synergy Wellness';

    //             $keywords='Synergy Wellness';

    //         }



            

                        



    //         $Blogs->map(function($Blog){

    //              $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();

    //         });

    //      return view('blogs',compact('title','description','keywords','Blogs','BlogSubCategory','BlogCategoryName'));

    // }

    // public function blogDetails($slug){

    //          $domain = parse_url(request()->root())['host'];





    //         $Blog=BlogPost::leftjoin('users','users.id','BlogPosts.author')

    //                     ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')

    //                     ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted','summary')

    //                     ->where('status',1)

    //                     ->where('link',$slug)->first();

    //         if(!$Blog){

    //             return redirect('/blogs');

    //         }

    //         $BlogSubCategories=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();

    //         $BlogCategory=BlogSubCategory::find($Blog->category);

    //         if($domain=='localhost'){

    //             $title='Synergy Wellness '.$Blog->title;

    //             $description='Synergy Wellness '.$Blog->description;

    //             $keywords='Synergy Wellness '.$Blog->keywords;

    //         }else{

    //             $title='Synergy Wellness '.$Blog->title;

    //             $description='Synergy Wellness '.$Blog->description;

    //             $keywords='Synergy Wellness '.$Blog->keywords;

    //         }

    //         //dd($title);



    //      return view('blog-details',compact('title','description','keywords','Blog','BlogCategory','BlogSubCategories'));

    // }

}