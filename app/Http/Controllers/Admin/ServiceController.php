<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostMetas;
use App\Models\SeoMeta;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
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

            $postList->where('type', '=', 'services');

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
            'title' => 'Services',
            'name' => 'services',
            'add_route' => 'post-type.services',
            'list_route' => 'admin.services',
            'bulk_action_route' => 'post-type.bulk-action-services',
        );
        return view('admin.pages.index', array('postList' => $postList));
    }

    /* CREATE PAGE */
    public function create(Request $request)
    {
        $randomString = Str::random(10);
        $pageDetails = array();

        $pageDetails['post_id'] = null;
        $pageDetails['title'] = 'Add New Service';
        $pageDetails['actionRoute'] = 'post-type.create-services';
        $pageDetails['post_types'] = 'services';
        $pageDetails['idContent'] = $randomString;
        $pageDetails['pageInfo'] = null;
        $pageDetails['main_title'] = 'Services';
        $pageDetails['name'] = 'services';
        return view('admin.pages.create', array('pageDetails' => $pageDetails));
    }

    /* INSERT DATA PAGE */
    public function createPage(Request $request)
    {
        if (empty($request->slug)) {
            $tempSlug = $request->title;
            $tempSlug = str_replace(' ', '-', $tempSlug);

            $request->merge(["slug" => strtolower($tempSlug)]);
        } else {
            $request->merge(["slug" => $request->slug]);
        }
        $json_metas = json_encode($request->meta);
        $request->merge(["json_metas" => json_decode($json_metas, true)]);

        if (empty($request->meta_description)) {
            $request->merge(["description" => $request->review_description]);
        } else {
            $request->merge(["description" => $request->meta_description]);
        }

        /* Type */
        $request->merge(["type" => $request->post_types]);

        $CreatedInfo = Post::create($request->all());
        $postMeta = array();
        if (!empty($CreatedInfo->id)) {
            $metaData = json_decode($json_metas, true);
            if(!empty($metaData)){
                foreach ($metaData as $key => $metaDataVal) {
                    $postMeta['post_id'] = $CreatedInfo->id;
                    $postMeta['meta_key'] = $key;
                    $postMeta['meta_value'] = $metaDataVal;
                }
                PostMetas::create($postMeta);
            }
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
                'redirect' => route('admin.services'),
                'message' => 'Service created succesfully.',
            ),
        ];
    }
    /* UPDATE PAGE */
    public function updatePage(Request $request)
    {

        $qry = DB::table('posts AS p_s')
            //->join('post_metas AS p_m', 'p_m.post_id', '=', 'p_s.id')
            ->leftJoin('seo_metas AS s_m', 's_m.object_id', '=', 'p_s.id')
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
            ])->orderBy('p_s.id', 'desc')->get()->toArray();

        $randomString = Str::random(10);
        $pageDetails = array();
        $pageDetails['post_id'] = $request->id;
        $pageDetails['actionRoute'] = 'post-type.update-services';
        $pageDetails['title'] = 'Edit Service';
        $pageDetails['post_types'] = 'services';
        $pageDetails['idContent'] = $randomString;
        if(!empty($qry)){
            $pageDetails['pageInfo']    = $qry[0];
        }else{
            $pageDetails['pageInfo']    = null;
        }
        $pageDetails['main_title'] = 'Services';
        $pageDetails['name'] = 'services';

        return view('admin.pages.create', array('pageDetails' => $pageDetails));
    }

    public function updatePagedata(Request $request, $id)
    {
        if (empty($request->slug)) {
            $tempSlug = $request->title;
            $tempSlug = str_replace(' ', '_', $tempSlug);

            $request->merge(["slug" => strtolower($tempSlug)]);
        } else {
            $request->merge(["slug" => $request->slug]);
        }
        $json_metas = json_encode($request->meta);
        $request->merge(["json_metas" => $json_metas]);

        if (empty($request->meta_description)) {
            $request->merge(["description" => $request->review_description]);
        } else {
            $request->merge(["description" => $request->meta_description]);
        }
        $request->request->remove('_token');
        $postRequest = array(
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'description' => $request->description,
            'json_metas' => $request->json_metas,
        );
        Post::where('id', $request->id)->update($postRequest);

        $postMeta = array();
        if (!empty($request->id)) {
            $metaData = json_decode($json_metas, true);
            if(!empty($metaData)){
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
                        'object_type' => 'services',
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
                'message' => 'Service updated succesfully.'.
               "<a href='" . url('/') . '/services/' . $request->slug . "' target='_blank' style='text-decoration: none !important;'> View post</a>",
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
                'message' => 'Service deleted successfully.',
            ], 200);
        } catch (\Exception$ex) {
            logMsg($ex);
            return response()->json([
                'success' => true,
                'message' => 'Unable to delete service.',
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
                        'message' => 'Services deleted successfully.',
                    ),
                ];
            } else {
                Post::whereIn('id', $id)->update(['status' => $action]);
                return $response = [
                    'status' => true,
                    'data' => array(
                        'status' => true,
                        'redirect' => '',
                        'message' => 'Service status update successfully.',
                    ),
                ];
            }
        } catch (\Exception$ex) {
            return response()->json([
                'success' => true,
                'message' => 'Something is wrong, Please ask devlopment team.',
            ], 200);
        }
    }
}
