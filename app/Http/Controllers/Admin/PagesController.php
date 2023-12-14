<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostMetas;
use App\Models\User;
use DataTables;
use DB;
use App\Models\SeoMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PagesController extends Controller
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

            $postList->where('type', '=', 'pages');

            if ($request->get('filterPostType') == 'trash') {
                $postList->where('status', '=', 'trash');
            } else {
                $postList->where('status', '!=', 'trash');
            }

            if ($request->get('filterPostType') !== 'all_status') {
                $postList = $postList->WHERE('status', $request->get('filterPostType'));
            }
            return Datatables::of($postList)->make(true);
        }
        $postList = array(
            'title' => 'Pages',
            'name' => 'pages',
            'add_route' => 'post-type.pages',
            'list_route' => 'admin.pages',
            'bulk_action_route' => 'post-type.page.bulk-action',
        );
        return view('admin.pages.index', array('postList' => $postList));
    }

    /* CREATE PAGE */
    public function create(Request $request)
    {
        $randomString = Str::random(10);
        $pageDetails = array();

        $pageDetails['post_id'] = null;
        $pageDetails['title'] = 'Add New Page';
        $pageDetails['actionRoute'] = 'post-type.create-pages';
        $pageDetails['post_types'] = 'pages';
        $pageDetails['idContent'] = $randomString;
        $pageDetails['pageInfo'] = null;
        $pageDetails['main_title'] = 'Pages';
        $pageDetails['name'] = 'pages';
        return view('admin.pages.create', array('pageDetails' => $pageDetails));
    }

    /* INSERT DATA PAGE */
    public function createPage(Request $request)
    {
        $blockArr = [];
        $arrayBlock = [];
        $json_metas = null;
        if (!empty($request->blocks)) {
            foreach ($request->blocks['content'] as $key => $blocksVal) {
                if (!empty($blocksVal)) {
                    foreach ($blocksVal as $key => $blockContent) {
                        $arrayBlock[] = array(
                            'block' => $key,
                            'shortcode' => $blockContent,
                        );
                    }
                }
                $blockArr['block_content']['content'] = $arrayBlock;
            }
            $json_metas = json_encode($blockArr);
        } else {
            $json_metas = json_encode($request->meta);
        }

        if (empty($request->slug)) {
            $tempSlug = $request->title;
            $tempSlug = str_replace(' ', '-', $tempSlug);

            $request->merge(["slug" => strtolower($tempSlug)]);
        } else {
            $request->merge(["slug" => $request->slug]);
        }
        if ($json_metas == null) {
            $json_metas = json_encode($request->meta);
        }
        $request->merge(["json_metas" => json_decode($json_metas, true)]);

        if (empty($request->meta_description)) {
            $request->merge(["description" => $request->review_description]);
        } else {
            $request->merge(["description" => $request->meta_description]);
        }

        /* Type */
        $request->merge(["type" => $request->post_types]);
        $request->merge(["templateStatus" => json_encode($request->meta)]);

        $CreatedInfo = Post::create($request->all());
        $postMeta = array();
        if (!empty($CreatedInfo->id)) {
            $metaData = json_decode($json_metas, true);
            if (!empty($metaData)) {
                foreach ($metaData as $key => $metaDataVal) {
                    $postMeta['post_id'] = $CreatedInfo->id;
                    $postMeta['meta_key'] = $key;
                    $postMeta['meta_value'] = json_encode($metaDataVal);
                }
            }
            PostMetas::create($postMeta);
            /* SEO META TITLE / DESCRIPTION */
            if (!empty($request->meta_title) || !empty($request->meta_description)) {
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
            'status' => true,
            'data' => array(
                'status' => true,
                'redirect' => route('admin.pages'),
                'message' => 'Page created succesfully.',
            ),
        ];
    }
    /* UPDATE PAGE */
    public function updatePage(Request $request)
    {

        $qry = DB::table('posts AS p_s')
            ->join('post_metas AS p_m', 'p_m.post_id', '=', 'p_s.id')
            ->leftJoin('seo_metas AS s_m', 's_m.object_id', '=', 'p_m.post_id')
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
                'p_s.json_metas',
                'p_s.templateStatus',
                's_m.meta_title',
                's_m.meta_description',
            ])->orderBy('p_s.id', 'desc')->get()->toArray();

        $randomString = Str::random(10);
        $pageDetails = array();
        $pageDetails['post_id'] = $request->id;
        $pageDetails['actionRoute'] = 'post-type.update-pages';
        $pageDetails['title'] = 'Edit Page';
        $pageDetails['post_types'] = 'pages';
        $pageDetails['idContent'] = $randomString;
        if (!empty($qry)) {
            $pageDetails['pageInfo'] = $qry[0];
        } else {
            $pageDetails['pageInfo'] = null;
        }
        $pageDetails['main_title'] = 'Pages';
        $pageDetails['name'] = 'pages';

        return view('admin.pages.create', array('pageDetails' => $pageDetails));
    }

    public function updatePagedata(Request $request, $id)
    {
        /* start slug empty */
        if (empty($request->slug)) {
            $tempSlug = $request->title;
            $tempSlug = str_replace(' ', '_', $tempSlug);
            $request->merge(["slug" => strtolower($tempSlug)]);
        } else {
            $request->merge(["slug" => $request->slug]);
        }
        if (empty($request->meta_description)) {
            $request->merge(["description" => $request->review_description]);
        } else {
            $request->merge(["description" => $request->meta_description]);
        }
        /* end slug empty */
        $blockArr   = [];
        $arrayBlock = [];
        $json_metas = null;
        $json_metas = json_encode($request->meta);
       
        if (!empty($request->blocks)) {
            foreach ($request->blocks['content'] as $key => $blocksVal) {
                if (!empty($blocksVal)) {
                    foreach ($blocksVal as $key => $blockContent) {
                        $arrayBlock[] = array(
                            'block' => $key,
                            'shortcode' => $blockContent,
                        );
                    }
                }
                $blockArr['block_content']['content']  = $arrayBlock;
                $blockArr['block_content']['template'] = $request->meta;
            }
            $json_metas = json_encode($blockArr);
        }
        $request->merge(["json_metas" => $json_metas]);    

        if($request->content == null){
            $pageContent = Post::where('id', '=', $id)
            ->select('id', 'content','json_metas','description')
            ->get()
            ->toArray();
            $requestContent  = $pageContent[0]['content'];
            $requestDesc     = $pageContent[0]['description'];
            if(isset($request->meta['template'])){
                if($request->meta['template'] == 'default'){
                    if(isset($requestContent)){
                        $request->merge(["content" => $requestContent]);
                    }
                }
            }
            if(isset($requestDesc)){
                $request->merge(["description" => $requestDesc]);
            }
        }
        
        if($request->blocks == null){
            $pageContent = Post::where('id', '=', $id)
            ->select('id', 'content','json_metas','description')
            ->get()
            ->toArray();
            $requestjMeta  = $pageContent[0]['json_metas'];
            $requestDesc   = $pageContent[0]['description'];
            if(!empty($requestjMeta)){
                if(!str_contains(json_encode($requestjMeta), 'notemplate')){
                    $json_metas = json_encode($requestjMeta);
                }
            }
            if(isset($requestDesc)){
                $request->merge(["description" => $requestDesc]);
            }
            $request->merge(["json_metas" => $json_metas]);  
        }

        $request->request->remove('_token');
        $postRequest = array(
            'title'             => $request->title,
            'slug'              => $request->slug,
            'status'            => $request->status,
            'content'           => $request->content,
            'thumbnail'         => $request->thumbnail,
            'description'       => $request->description,
            'json_metas'        => $request->json_metas,
            'templateStatus'    => $request->meta,
        );

        Post::where('id', $request->id)->update($postRequest);
        $postMeta = array();
        if (!empty($request->id)) {
            $metaData = json_decode($json_metas, true);
            if (!empty($metaData)) {
                foreach ($metaData as $key => $metaDataVal) {
                    $postMeta['post_id'] = $request->id;
                    $postMeta['meta_key'] = $key;
                    $postMeta['meta_value'] = $metaDataVal;
                }
                PostMetas::where('post_id', $request->id)->update($postMeta);
            }
            /* SEO META TITLE / DESCRIPTION */
            if (!empty($request->meta_title) || !empty($request->meta_description)) {
                SeoMeta::updateOrCreate(
                    [
                        'object_type' => 'pages',
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
            'status' => true,
            'data' => array(
                'status' => true,
                //'redirect' => route('admin.pages'),
                'message' => 'Post updated succesfully.' .
                "<a href='" . url('/') . '/' . $request->slug . "' target='_blank' style='text-decoration: none !important;'> View post</a>",
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
                'icon' => 'delete',
                'type' => 'danger',
                'message' => 'Page deleted successfully.',
            ], 200);
        } catch (\Exception $ex) {
            logMsg($ex);
            return response()->json([
                'success' => true,
                'message' => 'Unable to delete page.',
            ], 200);
        }
    }

    public function bulkActionPage(Request $request)
    {
        $id = $request->ids;
        $action = $request->action;

        try {
            if (!empty($action) && $action === 'delete') {
                /* posts delete */
                Post::whereIn('id', $id)->delete();
                /* seo meta delete */
                SeoMeta::whereIn('object_id', $id)->delete();
                return $response = [
                    'status' => true,
                    'data' => array(
                        'status' => true,
                        'redirect' => '',
                        'message' => 'Pages deleted successfully.',
                    ),
                ];
            } else {
                Post::whereIn('id', $id)->update(['status' => $action]);
                return $response = [
                    'status' => true,
                    'data' => array(
                        'status' => true,
                        'redirect' => '',
                        'message' => 'Page status update successfully.',
                    ),
                ];
            }
        } catch (\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Something is wrong, Please ask devlopment team.',
            ], 200);
        }
    }

}