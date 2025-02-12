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
use Illuminate\Support\Str;

class APIController extends Controller
{
	function __construct(){

    }
    public function tryLogin(Request $request){
        $credentials = $request->only('email', 'password');
         if (Auth::attempt($credentials)) {
              return ['status'=>true,'userId'=>Auth::Id()];
        }

        return ['status'=>false];

    }
     public function tryLogout(Request $request){
       
              Auth::logout();
            return redirect('/login');
      

    }
    public function getUserDetails(Request $request){
        $user=User::find($request->all()['id']);

        if(isset($user['id'])){
            return ['status'=>true,'message'=>'User found','user_details'=>$user];
        }

        return ['status'=>false,'message'=>'User not found','user_details'=>[]];


    }
    public function getBlogs(){
    	$Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')
                        ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')
                        ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted')
                        ->orderBy('created_at','desc')
                        ->get();

                        $Blogs->map(function($Blog){
                             $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();
                        });
       
                       
    	return ['status'=>true,'blogs'=>$Blogs];
    }

    public function getBlogDetailsForEdit(Request $request){
        $Blog=BlogPost::select('title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','summary','status','category')
                        ->where('BlogPosts.id',$request->id)->first();
           $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();
        //$Blog['category']=BlogCategory::whereIn('id',BlogPostMeta::where('postId',$Blog->id)->pluck('value')->toArray())->pluck('category')->toArray();
         $categories=BlogCategory::orderBy('category','asc')
                        ->get();
         $sub_categories=BlogSubCategory::orderBy('subcategory','asc')
                        ->get();               


        return ['status'=>true,'blog_details'=>$Blog,'categories'=>$categories,'sub_categories'=>$sub_categories];
    }
    public function removeBlog(Request $request){
          $input=$request->all();
          BlogPost::where('id',$input['id'])->delete();
          BlogPostMeta::where('postId',$request->id)->delete();
           $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')
                        ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')
                        ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted')
                        ->orderBy('created_at','desc')
                        ->get();

                        $Blogs->map(function($Blog){
                             $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();
                        });
       
                       
        return ['status'=>true,'blogs'=>$Blogs];
    }
    public function unHighlightBlog(Request $request){
          $input=$request->all();
          BlogPost::where('id',$input['id'])->update(['highlighted'=>0]);
           $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')
                        ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')
                        ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted')
                        ->orderBy('created_at','desc')
                        ->get();

                        $Blogs->map(function($Blog){
                             $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();
                        });
       
                       
        return ['status'=>true,'blogs'=>$Blogs];
    }
    public function highlightBlog(Request $request){
          $input=$request->all();
          BlogPost::where('id',$input['id'])->update(['highlighted'=>1]);
         $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')
                        ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')
                        ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted')
                        ->orderBy('created_at','desc')
                        ->get();

                        $Blogs->map(function($Blog){
                             $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();
                        });
       
                       
        return ['status'=>true,'blogs'=>$Blogs];
    }
     public function disableBlog(Request $request){
          $input=$request->all();
          BlogPost::where('id',$input['id'])->update(['status'=>2]);
           $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')
                        ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')
                        ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted')
                        ->orderBy('created_at','desc')
                        ->get();

                        $Blogs->map(function($Blog){
                             $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();
                        });
       
                       
        return ['status'=>true,'blogs'=>$Blogs];
    }
    public function enableBlog(Request $request){
          $input=$request->all();
          BlogPost::where('id',$input['id'])->update(['status'=>1]);
         $Blogs=BlogPost::leftjoin('users','users.id','BlogPosts.author')
                        ->leftjoin('BlogCategory','BlogCategory.id','BlogPosts.category')
                        ->select('name','title','link','blogImage','content','BlogPosts.created_at','BlogPosts.id','users.id as Author','status','BlogCategory.category','highlighted')
                        ->orderBy('created_at','desc')
                        ->get();

                        $Blogs->map(function($Blog){
                             $Blog['sub_categories']=BlogPostMeta::where('postId',$Blog->id)->where('type','Sub Category')->pluck('value')->toArray();
                        });
       
                       
        return ['status'=>true,'blogs'=>$Blogs];
    }
     public function uploadTempBlogImage(Request $request){
        $input=$request->all();
        $filenametostore="";
        $filenamewithextension="";
        if($request->hasFile('files') && $request->file('files')){
            $image = $request->file('files');
            $filenamewithextension = $image->getClientOriginalName();
            $destinationPath = public_path('/uploads/BlogImages');
            $image->move($destinationPath, $filenamewithextension);
            
        }
        
        return ['status'=>true,'filenametostore'=>$filenamewithextension,'originalFileName'=>$filenamewithextension];
    }
    public function updateBlogImage(Request $request){
        $input=$request->all();
        $blog_details=BlogPost::find($input['id']);
        $blog_details->blogImage= $input['originalFileName'];
        $blog_details->save();
        return ['status'=>true];
    }
    public function updateBlog(Request $request){
          $input=$request->all();
         BlogPost::where('id',$input['id'])->update([    'content'=> $input['content'], 
                                                         'title'=> $input['title'],
                                                         'link'=> str_replace(" ","-",$input['title']),
                                                         'summary'=> $input['summary'],
                                                         'category'=> $input['category'],
                                                         'blogImage'=> isset($input['image_file'][0]['name'])?$input['image_file'][0]['name']:'',
                                                     ]);

         BlogPostMeta::where('postId',$input['id'])->delete();

            foreach($input['sub_categories'] as $category){
                $newCategory=new BlogPostMeta;
                $newCategory->type='Sub Category';
                $newCategory->postId=$input['id'];
                $newCategory->value=$category;
                $newCategory->save();   
            }
        return ['status'=>true];   
    }
     public function saveBlog(Request $request){
          $input=$request->all();
         $postId= BlogPost::insertGetId([    'content'=> $input['content'],
                                            'title'=> $input['title'],
                                            'summary'=> $input['summary'],
                                            'link'=> str_replace(" ","-",$input['title']),
                                            'author'=> $input['user_id'], 
                                            'category'=> $input['category'],
                                            'status'=>1,
                                            'blogImage'=> isset($input['image_file'][0]['name'])?$input['image_file'][0]['name']:'',
                                        ]); 

         

            foreach($input['sub_categories'] as $category){
                $newCategory=new BlogPostMeta;
                $newCategory->type='Sub Category';
                $newCategory->postId=$postId;
                $newCategory->value=$category;
                $newCategory->save();   
            }
        return ['status'=>true];   
    }
    public function getCategories(){
        $categories=BlogCategory::orderBy('created_at','desc')
                        ->get();
         $sub_categories=BlogSubCategory::orderBy('subcategory','asc')
                        ->get();                  
        return ['status'=>true,'categories'=>$categories,'sub_categories'=>$sub_categories];
    }
     public function getCategoriesOrderByName(){
        $categories=BlogCategory::orderBy('category','asc')
                        ->get();
         $sub_categories=BlogSubCategory::orderBy('subcategory','asc')
                        ->get();                   
        return ['status'=>true,'categories'=>$categories,'sub_categories'=>$sub_categories];
    }

    public function getCategoryDetailsForEdit(Request $request){
        $category_details=BlogCategory::where('id',$request->id)->first();     
        $sub_categories=BlogSubCategory::where('category_id',$request->id)
                        ->pluck('subcategory')->toArray();     
        return ['status'=>true,'category_details'=>$category_details,'sub_categories'=>$sub_categories];
    }
    public function removeCategory(Request $request){
          $input=$request->all();
          BlogCategory::where('id',$input['id'])->delete();
         BlogSubCategory::where('category_id',$input['id'])->delete();      
          $categories=BlogCategory::orderBy('created_at','desc')
                        ->get();    
        return ['status'=>true,'categories'=>$categories];
    }

    public function updateCategory(Request $request){
          $input=$request->all();
          BlogCategory::where('id',$input['id'])->update(['category'=> $input['category'],'slug'=> Str::slug($input['category']) ]);

         BlogSubCategory::where('category_id',$input['id'])->delete();   
         if($input['sub_categories']){
             foreach($input['sub_categories'] as $scategory){
                $newsCategory=new BlogSubCategory;
                $newsCategory->category_id=$input['id'];
                $newsCategory->subcategory=$scategory;
                $newsCategory->slug=Str::slug($scategory);
                $newsCategory->save();   
            }
         }
         
         
        return ['status'=>true];   
    }
     public function saveCategory(Request $request){
          $input=$request->all();
         $postId= BlogCategory::insertGetId(['category'=> $input['category'],'slug'=> Str::slug($input['category']) ]); 
         if($input['sub_categories']){
             foreach($input['sub_categories'] as $scategory){
                    $newsCategory=new BlogSubCategory;
                    $newsCategory->category_id=$postId;
                    $newsCategory->subcategory=$scategory;
                    $newsCategory->slug=Str::slug($scategory);
                    $newsCategory->save();   
                }
            }
        return ['status'=>true];   
    }
}