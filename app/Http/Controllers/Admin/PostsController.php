<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostMetas;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Taxonomies;
use DataTables;
use DB;
use App\Models\SeoMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    // PAGE LISTING
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $postList = Post::select(
                'id',
                'title',
                'slug',
                DB::RAW('DATE_FORMAT(created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
                'created_at',
                'type',
                'status',
                'lockunlockstatus',
            );

            $postList->where('type', '=', 'posts');

            if ($request->get('filterPostType') == 'trash') {
                $postList->where('status', '=', 'trash');
            }else{
                $postList->where('status', '!=', 'trash');
            }

            if ($request->get('filterPostType') !== 'all_status') {
                $postList = $postList->WHERE('status', $request->get('filterPostType'));
            }
            return Datatables::of($postList)->make(true);
        }
        $postList = array(
            'title' => 'Posts',
            'name' => 'posts',
            'add_route' => 'post-type.posts',
            'bulk_action_route' => 'post-type.post.bulk-action',
            'list_route' => 'admin.posts',
        );
        return view('admin.pages.index', array('postList' => $postList));
    }

    /* CREATE PAGE */
    public function create(Request $request)
    {
        $randomString               = Str::random(10);
        $pageDetails                = array();
        
        $pageDetails['post_id']     = null;
        $pageDetails['title']       = 'Add New Posts';
        $pageDetails['actionRoute'] = 'post-type.create-posts';
        $pageDetails['post_types']  = 'posts';
        $pageDetails['idContent']   = $randomString;
        $pageDetails['pageInfo']    = null;
        $pageDetails['main_title']      = 'Posts';
        $pageDetails['name']            = 'posts';
        return view('admin.pages.create', array('pageDetails' => $pageDetails));
    }

    /* INSERT DATA PAGE */
    public function createPage(Request $request)
    {
        if(empty($request->slug)){
            $tempSlug = $request->title;
            $tempSlug = str_replace(' ', '-', $tempSlug); 

            $request->merge(["slug" => strtolower($tempSlug)]);
        }else{
            $request->merge(["slug" => $request->slug]);
        }
        $json_metas = json_encode($request->meta);
        $request->merge(["json_metas" => json_decode($json_metas, true)]);

        if(empty($request->meta_description)){
            $request->merge(["description" => $request->review_description]);
        }else{
            $request->merge(["description" => $request->meta_description]);
        }

        /* Type */
        $request->merge(["type" => $request->post_types]);

        /* Tags & Categories */
        if($request->categories != null || $request->tags != null){
            $ids = array();
            if($request->categories != null){
                $ids = array_merge($ids, $request->categories);
            }
            if($request->tags != null){
                $ids = array_merge($ids, $request->tags);
            }
            $TaxData =  Taxonomies::whereIn('id', $ids)
            ->select('id', 'name', 'taxonomy', 'slug', 'total_post', 'thumbnail')
            ->get()->toArray();

            $json_TaxData = json_encode($TaxData, true);
            $request->merge(["json_taxonomies" => json_decode($json_TaxData)]);
        }

        $CreatedInfo = Post::create($request->all());
        $postMeta = array();
        if(!empty($CreatedInfo->id)){
            $metaData = json_decode($json_metas, true);
            if(!empty($metaData)){
                foreach($metaData as $key=> $metaDataVal){
                    $postMeta['post_id'] = $CreatedInfo->id;
                    $postMeta['meta_key'] = $key;
                    $postMeta['meta_value'] = $metaDataVal;
                }
                PostMetas::create($postMeta);
            }
            /* SEO META TITLE / DESCRIPTION */
            if(!empty($request->meta_title) || !empty($request->meta_description)){
                SeoMeta::updateOrCreate(
                    [
                        'object_type' => $request->post_types,
                        'object_id' => $CreatedInfo->id,
                    ],
                    [
                        'meta_title' => $request->meta_title,
                        'meta_description' => $request->meta_description,
                    ]
                );
            }
        }
        
        return $response = [
            'status'  => true,
            'data'    => array(
                'status'  => true, 
                'redirect' => route('admin.posts'),
                'message' => 'Post created succesfully.',
            ),
        ];
    }
    /* UPDATE PAGE */
    public function updatePage(Request $request){

        $qry = DB::table('posts AS p_s')
			// ->join('post_metas AS p_m', 'p_m.post_id', '=', 'p_s.id')
            ->leftJoin('seo_metas AS s_m', 's_m.object_id',  '=', 'p_s.id')
			->where('p_s.id', $request->id)
			->select([
				'p_s.id',
                'p_s.title',
                'p_s.thumbnail',
                'p_s.slug',
                'p_s.description',
                'p_s.content',
                'p_s.status',
                'p_s.type',
                's_m.meta_title',
                's_m.meta_description',
                'p_s.json_taxonomies',
			])->orderBy('p_s.id', 'desc')->get()->toArray();

        $randomString               = Str::random(10);
        $pageDetails                = array();
        $pageDetails['post_id']     = $request->id;
        $pageDetails['actionRoute'] = 'post-type.update-posts';
        $pageDetails['title']       = 'Edit Page';
        $pageDetails['post_types']  = 'posts';
        $pageDetails['idContent']   = $randomString;
        if(!empty($qry)){
            $pageDetails['pageInfo']    = $qry[0];
        }else{
            $pageDetails['pageInfo']    = null;
        }
        $pageDetails['main_title']      = 'Posts';
        $pageDetails['name']            = 'posts'; 
        return view('admin.pages.create', array('pageDetails' => $pageDetails));
    }

    public function updatePagedata (Request $request, $id){

        if(empty($request->slug)){
            $tempSlug = $request->title;
            $tempSlug = str_replace(' ', '_', $tempSlug); 

            $request->merge(["slug" => strtolower($tempSlug)]);
        }else{
            $request->merge(["slug" => $request->slug]);
        }
        $json_metas = json_encode($request->meta);
        $request->merge(["json_metas" => $json_metas]);

        if(empty($request->meta_description)){
            $request->merge(["description" => $request->review_description]);
        }else{
            $request->merge(["description" => $request->meta_description]);
        }
        $request->request->remove('_token');

        /* Tags & Categories */
        $json_TaxData = null;
        if($request->categories != null || $request->tags != null){
            $ids = array();
            if($request->categories != null){
                $ids = array_merge($ids, $request->categories);
            }
            if($request->tags != null){
                $ids = array_merge($ids, $request->tags);
            }
            $TaxData =  Taxonomies::whereIn('id', $ids)
            ->select('id', 'name', 'taxonomy', 'slug', 'total_post', 'thumbnail')
            ->get()->toArray();
            $json_TaxData = json_encode($TaxData, true);
        }

        $postRequest = array(
            'title'         => $request->title,
            'slug'          => $request->slug,
            'status'        => $request->status,
            'content'       => $request->content,
            'thumbnail'     => $request->thumbnail,
            'description'   => $request->description,
            'json_metas'    => $request->json_metas,
            'json_taxonomies'    => $json_TaxData,
        );
        Post::where('id', $request->id)->update($postRequest);

        $postMeta = array();
        if(!empty($request->id)){
            $metaData = json_decode($json_metas, true);
            if(!empty($metaData)){
                foreach($metaData as $key=> $metaDataVal){
                    $postMeta['post_id'] = $request->id;
                    $postMeta['meta_key'] = $key;
                    $postMeta['meta_value'] = $metaDataVal;
                }
                PostMetas::where('post_id', $request->id)->update($postMeta);
            }
            /* SEO META TITLE / DESCRIPTION */
            if(!empty($request->meta_title) || !empty($request->meta_description)){
                SeoMeta::updateOrCreate(
                    [
                        'object_type' => 'posts',
                        'object_id' => $request->id,
                    ],
                    [
                        'meta_title' => $request->meta_title,
                        'meta_description' => $request->meta_description,
                    ]
                );
            }
        }
        
        return $response = [
            'status'  => true,
            'data'    => array(
                'status'  => true, 
                //'redirect' => route('admin.pages'),
                'message' => 'Post updated succesfully.'.
                "<a href='".url('/').'/'.$request->slug."' target='_blank' style='text-decoration: none !important;'> View post</a>",
            ),
        ];
    }
    /* DELETE PAGE */
    public function destroy(int $id)
	{
		try {
            Post::destroy($id);
            $seometa = SeoMeta::where('object_id', '=', $id)->pluck('id');
            SeoMeta::destroy($seometa);
            return response()->json([
                'success' => true,
                'icon'    => 'delete',
                'type'    => 'danger',
                'message' => 'Post deleted successfully.',
            ], 200);
		}
		catch(\Exception $ex) {
			logMsg($ex);
            return response()->json([
                'success' => true,
                'message' => 'Unable to delete post.',
            ], 200);
		}
	}

    public function bulkActionPage(Request $request){
        $id     = $request->ids;
        $action = $request->action;

        try {
            if(!empty($action) && $action === 'delete'){
                /* posts delete */
                Post::whereIn('id', $id)->delete();
                /* seo meta delete */
                SeoMeta::whereIn('object_id', $id)->delete();
                return $response = [
                    'status'  => true,
                    'data'    => array(
                        'status'  => true, 
                        'redirect' => '',
                        'message' => 'Posts deleted successfully.',
                    ),
                ];
            }else{
                Post::whereIn('id', $id)->update(['status' => $action]);
                return $response = [
                    'status'  => true,
                    'data'    => array(
                        'status'  => true, 
                        'redirect' => '',
                        'message' => 'post status update successfully.',
                    ),
                ];
            }
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Something is wrong, Please ask devlopment team.',
            ], 200);
		}
    }
    function postlockUnlockData(Request $request){
        try{
            if($request->id != '' && $request->status != null){
                $lockUnloack = 0;
                if($request->status == 'yes'){
                    $lockUnloack = 0;
                }else{
                    $lockUnloack = 1;
                }

                $postRequest = array(
                    'lockunlockstatus' => $lockUnloack,
                );
                Post::where('id', $request->id)->update($postRequest);
                return $response = [
                    'status'  => true,
                    'data'    => array(
                        'status'  => true, 
                        'message' => 'Post updated succesfully.',
                    ),
                ];
            
            }   
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Something is wrong, Please ask devlopment team.',
            ], 200);
		}
        return [];
    }
    function postcloneData(Request $request){
        try{
            if(!empty($request->id)){
                $qry = DB::table('posts AS p_s')
                ->leftJoin('post_metas AS p_m', 'p_m.post_id', '=', 'p_s.id')
                ->leftJoin('seo_metas AS s_m', 's_m.object_id',  '=', 'p_s.id')
                ->where('p_s.id',$request->id)
                ->orderBy('p_s.id', 'desc')->get()->toArray();

                if(!empty($qry)){
                    $postTitle          = $qry[0]->title.' - Copy';
                    $postSlug           = $qry[0]->slug.'-copy';
                    $postStatus         = 'draft';
                    $postContent        = $qry[0]->content;
                    $postThumbnail      = $qry[0]->thumbnail;
                    $postDesc           = $qry[0]->description;
                    $postType           = $qry[0]->type;
                    $postjson_taxo      = $qry[0]->json_taxonomies;
                    $postJson_metas     = $qry[0]->json_metas;
                    $postTemplateStatus = $qry[0]->templateStatus;
                    $postlockulStatus   = $qry[0]->lockunlockstatus;

                    // $postMetaId         = $qry[0]->post_id;
                    $postMetakey        = $qry[0]->meta_key;
                    $postMetaval        = $qry[0]->meta_value;
                    
                    $postSeoobjtype     = $qry[0]->object_type;
                    // $postSeoobjid       = $qry[0]->object_id;
                    $postSeomtitle      = $qry[0]->meta_title;
                    $postSeomdesc       = $qry[0]->meta_description;

                    if(!empty($postjson_taxo)){
                        $postjson_taxo = json_decode($postjson_taxo, true);
                    }
                    if(!empty( $postJson_metas)){
                        $postJson_metas = json_decode( $postJson_metas, true);
                    }

                    /* start create clone post */   
                    $postRequest = array(
                        'title'             => $postTitle,
                        'thumbnail'         => $postThumbnail,
                        'slug'              => $postSlug,
                        'description'       => $postDesc,
                        'content'           => $postContent,
                        'status'            => $postStatus,
                        'type'              => $postType,
                        'json_metas'        => $postJson_metas,
                        'templateStatus'    => $postTemplateStatus,
                        'json_taxonomies'   => $postjson_taxo,
                        'lockunlockstatus'  => $postlockulStatus,
                    );
                    $CreatedInfo = Post::create($postRequest);
                    if(!empty($CreatedInfo->id)){
                        if(!empty($CreatedInfo->id)){

                            $postMeta['post_id']    = $CreatedInfo->id;
                            $postMeta['meta_key']   = $postMetakey;
                            $postMeta['meta_value'] = $postMetaval;
                            PostMetas::create($postMeta);
                        }
                        if(!empty($CreatedInfo->id)){
                            SeoMeta::updateOrCreate(
                                [
                                    'object_type' => $postSeoobjtype,
                                    'object_id'   => $CreatedInfo->id,
                                ],
                                [
                                    'meta_title'        => $postSeomtitle,
                                    'meta_description'  => $postSeomdesc,
                                ]
                            );
                        }
                    }
                    /* end create clone post */
                    return $response = [
                        'status'  => true,
                        'data'    => array(
                            'status'  => true, 
                            'message' => 'Post updated succesfully.',
                        ),
                    ];
                }            
            }   
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Something is wrong, Please ask devlopment team.',
            ], 200);
		}
        return [];
    }

    // it's me
    // public function getCategorywisepost(Request $request){
       
    //     $category = Taxonomies::where('taxonomy','=','categories')
    //     ->where('post_type','posts')
    //         ->where('slug', 'like', '%' . $request->categorySlug . '%')
    //          ->first();
    //         // dd();
    //     $data = Post::where('type','posts')
    //     // ->where('slug',$request->categorySlug)
    //     ->where('title', 'like', '%' . $category['name'] . '%')
    //     ->paginate(6);
    //     //  dd($data);
    // //   return view('',compact('data'));
    // if ($request->ajax()) {
    //     // $view = view('components.front.filterpost', $data)->render();
    //     // return response()->json(['html' => $view]);
    // }
       
    // }
    public function details($id){
     
       $post = Post::find($id);
       
       return view('front.details',compact('post'));
       
    }
    
}
