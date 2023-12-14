<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\PostMetas;
use DB;
use Illuminate\Http\Request;
use Auth;

class FontendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $genetalSetting = get_general_settings();
        $siteURL = null;
        if(isset($genetalSetting['gs_site_url'])){
            $siteURL = $genetalSetting['gs_site_url'];
        }
        if($request->slug != null){
            $postList =  DB::table('posts AS p_s')
            ->where('p_s.slug', '=', $request->slug)
            ->where('p_s.status', '=', 'publish')
            ->leftJoin('seo_metas AS s_m', 's_m.object_id',  '=', 'p_s.id')
            ->select([
				'p_s.id',
                'p_s.title',
                'p_s.thumbnail',
                'p_s.slug',
                'p_s.description',
                'p_s.content',
                'p_s.status',
                'p_s.type',
                'p_s.json_metas',
                'p_s.templateStatus',
                'p_s.json_taxonomies',
                'p_s.lockunlockstatus',
                's_m.meta_title',
                's_m.meta_description',
                'p_s.json_taxonomies',
			])->orderBy('p_s.id', 'desc')->get();
            if(!$postList->isEmpty()){
                $postList       = $postList->toArray();
                $postId         = $postList[0]->id;
                $postTitle      = $postList[0]->title;
                $postlockUnlock = $postList[0]->lockunlockstatus;

                if(Auth::user() != NULL && !empty(Auth::user()) || $postlockUnlock != 0){
                    if(isset(Auth::user()->user_type)){
                        if(Auth::user()->user_type == 'SuperAdmin' || Auth::user()->user_type == 'Member'){
                            $postData = [
                                "postId"    => $postId,
                                "postTitle" => $postTitle,
                                "pageData"  => $postList,
                            ];                   
                            return view('front.home', compact('postData'));
                        }
                    }else{
                        $postData = [
                            "postId"    => $postId,
                            "postTitle" => $postTitle,
                            "pageData"  => $postList,
                        ];                   
                        return view('front.home', compact('postData'));
                    }
                }else{
                    $postData = [
                        "postId"    => $postId,
                        "postTitle" => $postTitle,
                        "pageData"  => $postList,
                    ];  
                    return view('front.member.login', compact('postData'));
                }
            }else{
                return view('front.error-page');
            }
        }else{
            if($siteURL != null){
                $postList =  DB::table('posts AS p_s')
                ->where('p_s.slug', '=', $siteURL)
                ->leftJoin('seo_metas AS s_m', 's_m.object_id',  '=', 'p_s.id')
                ->select([
                    'p_s.id',
                    'p_s.title',
                    'p_s.thumbnail',
                    'p_s.slug',
                    'p_s.description',
                    'p_s.content',
                    'p_s.status',
                    'p_s.type',
                    'p_s.json_metas',
                    'p_s.templateStatus',
                    'p_s.json_taxonomies',
                    'p_s.lockunlockstatus',
                    's_m.meta_title',
                    's_m.meta_description',
                    'p_s.json_taxonomies',
                ])->orderBy('p_s.id', 'desc')->get();
                if(!$postList->isEmpty()){
                    $postList       = $postList->toArray();
                    $postId         = $postList[0]->id;
                    $postTitle      = $postList[0]->title;
                    $postlockUnlock = $postList[0]->lockunlockstatus;

                    if(Auth::user() != NULL && !empty(Auth::user()) || $postlockUnlock != 0){
                        if(isset(Auth::user()->user_type)){
                            if(Auth::user()->user_type == 'SuperAdmin' || Auth::user()->user_type == 'Member'){
                                $postData = [
                                    "postId"    => $postId,
                                    "postTitle" => $postTitle,
                                    "pageData"  => $postList,
                                ];                   
                                return view('front.home', compact('postData'));
                            }
                        }else{
                            $postData = [
                                "postId"    => $postId,
                                "postTitle" => $postTitle,
                                "pageData"  => $postList,
                            ];                   
                            return view('front.home', compact('postData'));
                        }
                    }else{
                        $postData = [
                            "postId"    => $postId,
                            "postTitle" => $postTitle,
                            "pageData"  => $postList,
                        ];  
                        return view('front.member.login', compact('postData'));
                    }
                }else{
                    return view('front.error-page');
                }
            }
            return view('front.error-page');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $postCount = Post::where("type", "=", 'posts')->count();
        $pageCount = Post::where("type", "=", 'pages')->count();
        $serviceCount = Post::where("type", "=", 'services')->count();
        $eventCount = Post::where("type", "=", 'events')->count();

        $userCount = User::where('id', '!=', Auth::id())->count();
        $userData = [
            "userCount" => $userCount,
            "postCount" => $postCount,
            "pageCount" => $pageCount,
            "serviceCount" => $serviceCount,
            "eventCount" => $eventCount,

        ];
        return view('admin.dashboard', compact('userData'));
    }
    
}
