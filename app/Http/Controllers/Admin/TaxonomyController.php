<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostMetas;
use App\Models\Taxonomies;
use App\Models\User;
use DataTables;
use DB;
use App\Models\SeoMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxonomyController extends Controller {

    public function indexTaxs(Request $request) {
        // START TAXONOMY COUNTS
        $taxonomies = Post::select('id', 'json_taxonomies')->get()->toArray();
        if(!empty($taxonomies)){
            $count_cate = array();
            foreach($taxonomies as $taxonomiesVal){
                // $post_ID = $taxonomiesVal['id'];
                if(!empty($taxonomiesVal['json_taxonomies'])){
                    foreach($taxonomiesVal['json_taxonomies'] as $json_taxonomiesVal){
                        @$count_cate[$json_taxonomiesVal['slug']]++;
                    }
                }
            }
            if(!empty($count_cate)){
                foreach($count_cate as $key => $count_cateVal){
                    Taxonomies::where('slug',$key)
                    ->update(['total_post'=>$count_cateVal]);
                }
            }
        }
        // END TAXONOMY COUNTS
        if ($request->ajax()) {
            $postList = DB::table('taxonomies as c')
            ->where('c.taxonomy', '=', 'categories')
            ->leftJoin('taxonomies as k','c.parent_id','=','k.id')
            ->select('c.id','c.name','k.name as parent_name','c.parent_id',
            DB::RAW('DATE_FORMAT(c.created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
            'c.created_at',
            'c.total_post');
            
            return Datatables::of($postList)->make(true);
        }
        $postList = array(
            'title' => 'Categories',
            'name' => 'categories',
            'add_route' => 'post-type.posts',
            'list_route' => 'posts.categories',
            'taxonomy' => 'categories',
        );
        return view('admin.taxonomy.categories', array('postList' => $postList));
    }

    /* Load taxonomy */

    function loadTaxonomies(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        $postType = $request->get('post_type');
        $taxonomy = $request->get('taxonomy');

        $query = Taxonomies::query();
        $query->select(
                [
                    'id',
                    'name as text',
                ]
        );

        if ($postType) {
            $query->where('post_type', '=', $postType);
        }

        if ($taxonomy) {
            $query->where('taxonomy', '=', $taxonomy);
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }
    
    public function createTaxs(Request $request){
        if(empty($request->slug)){
            $tempSlug = $request->name;
            $tempSlug = str_replace(' ', '_', $tempSlug); 

            $request->merge(["slug" => strtolower($tempSlug)]);
        }else{
            $request->merge(["slug" => $request->slug]);
        }
        $CreatedInxfo = Taxonomies::create($request->all());
        return $response = [
            'status'  => true,
            'data'    => array(
            'status'  => true, 
            //'redirect' => route('admin.posts'),
            'message' => ucfirst($request->taxonomy).' created successfully.',
            ),
        ];
    }
   
    public function createPostTaxs(Request $request){

        if($request->name == null){
            return $response = [
                'status'  => false,
                'data'    => array(
                    'message' => ' The name field is required.',  
                ),
            ];
        }

        if(empty($request->slug)){
            $tempSlug = $request->name;
            $tempSlug = str_replace(' ', '_', $tempSlug); 

            $request->merge(["slug" => strtolower($tempSlug)]);
        }else{
            $request->merge(["slug" => $request->slug]);
        }
        $CreatedInxfo = Taxonomies::create($request->all());
        $CreatedInxf['status'] = true;
        return $response = [
            'status'  => true,
            'data'    => array(
            'info'    => $CreatedInxfo,
            'message' => ucfirst($request->taxonomy).' created successfully.',
            ),
        ];
    }
    
    public function taxBulkActionPage(Request $request){
        $id         = $request->ids;
        $action     = $request->action;
        $taxonomy   = $request->taxonomy;

        try {
            /* posts delete */
            Taxonomies::whereIn('id', $id)->delete();
            return $response = [
                'status'  => true,
                'data'    => array(
                    'status'  => true, 
                    'redirect' => '',
                    'message' => ucfirst($taxonomy).' deleted successfully.',
                ),
            ];
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Something is wrong, Please ask devlopment team.',
            ], 200);
		}
    }
    
    public function destroy(request $request, int $id){
        try {
            Taxonomies::destroy($id);
                return response()->json([
                    'success' => true,
                    'icon'    => 'delete',
                    'type'    => 'danger',
                    'message' => ucfirst($request->query('taxonomy')).' deleted successfully.',
                ], 200);
            }
            catch(\Exception $ex) {
                return response()->json([
                    'success' => true,
                    'message' => 'Unable to delete page.',
                ], 200);
            }
    }

    /* Edit Categories Page */
    public function taxupdatePage(Request $request){

        $pageDetails                = array();
        if(request()->is('admin/taxonomy/posts/tags/*/edit')){
            $pageDetails['title']       = 'Edit Tags';
            $pageDetails['name']        = 'tags'; 
            $pageDetails['taxonomy']    = 'tags';
        }elseif(request()->is('admin/taxonomy/posts/categories/*/edit')){
            $pageDetails['title']       = 'Edit Categories';
            $pageDetails['name']        = 'categories'; 
            $pageDetails['taxonomy']    = 'categories';
        }

        try {
            $qry = DB::table('taxonomies as c')
            ->where('c.id', $request->id)
            ->leftJoin('taxonomies as k','c.parent_id','=','k.id')
            ->select('c.id','c.name','c.description','k.name as parent_name','c.parent_id',
            DB::RAW('DATE_FORMAT(c.created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
            'c.created_at',
            'c.total_post')
            ->orderBy('c.id', 'desc')->get()->toArray();

            $randomString               = Str::random(10);
            $pageDetails['post_id']     = $request->id;
            $pageDetails['actionRoute'] = 'admin.taxonomy.update-taxonomys';
            $pageDetails['post_types']  = 'posts';
            $pageDetails['idContent']   = $randomString;
            if(!empty($qry)){
                $pageDetails['pageInfo']    = $qry[0];
            }else{
                $pageDetails['pageInfo']    = null;
            }
            $pageDetails['main_title']      = $qry[0]->name;
            
            return view('admin.taxonomy.edit-taxonomys', array('pageDetails' => $pageDetails));
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Unable to edit categories page.',
            ], 200);
        }
    }
    public function updateTaxdata(Request $request, $id){
        try {   
            // $request->request->remove('_token');
            $postRequest = array(
                'name'          => $request->name,
                'description'   => $request->description,
                'parent_id'     => $request->parent_id,
            );
            Taxonomies::where('id', $request->id)->update($postRequest);

            return $response = [
                'status'  => true,
                'data'    => array(
                    'status'  => true, 
                    //'redirect' => route('admin.pages'),
                    'message' => ucfirst($request->taxonomy).' updated succesfully.',
                ),
            ];
        } catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Unable to edit categories page.',
            ], 200);
        }
    }
    /* tags */
    public function indexTags(Request $request) {
        if ($request->ajax()) {
            $postList = DB::table('taxonomies as c')
            ->where('c.taxonomy', '=', 'tags')
            ->leftJoin('taxonomies as k','c.parent_id','=','k.id')
            ->select('c.id','c.name','k.name as parent_name','c.parent_id',
            DB::RAW('DATE_FORMAT(c.created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
            'c.created_at',
            'c.total_post');
            
            return Datatables::of($postList)->make(true);
        }
        $postList = array(
            'title' => 'Tags',
            'name' => 'tags',
            'add_route' => 'post-type.posts',
            'list_route' => 'posts.categories',
            'taxonomy' => 'tags',
        );
        return view('admin.taxonomy.categories', array('postList' => $postList));
    }
    public function tagsupdatePage(Request $request){
        $pageDetails                = array();
        $pageDetails['title']       = 'Edit Tags';
        $pageDetails['name']        = 'tags'; 
        $pageDetails['taxonomy']    = 'tags';

        try {
            $qry = DB::table('taxonomies as c')
            ->where('c.id', $request->id)
            ->leftJoin('taxonomies as k','c.parent_id','=','k.id')
            ->select('c.id','c.name','c.description','k.name as parent_name','c.parent_id',
            DB::RAW('DATE_FORMAT(c.created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
            'c.created_at',
            'c.total_post')
            ->orderBy('c.id', 'desc')->get()->toArray();

            $randomString               = Str::random(10);
            $pageDetails['post_id']     = $request->id;
            $pageDetails['actionRoute'] = 'admin.taxonomy.update-taxonomys';
            $pageDetails['post_types']  = 'posts';
            $pageDetails['idContent']   = $randomString;
            if(!empty($qry)){
                $pageDetails['pageInfo']    = $qry[0];
            }else{
                $pageDetails['pageInfo']    = null;
            }
            $pageDetails['main_title']      = $qry[0]->name;
            
            return view('admin.taxonomy.edit-taxonomys', array('pageDetails' => $pageDetails));
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Unable to edit categories page.',
            ], 200);
        }
    }

    public function tagsgetPage(Request $request){
        $item = Taxonomies::findOrFail($request->id);
        return response()->json([
            'success' => true,
            'message' => 'Unable to edit categories page.',
             'data' => array(
                'html' => view(
                    'components.tag-item',
                    [
                        'item' => $item,
                        'name' => 'tags',
                    ]
                )->render(),
             ),
        ], 200);
       
    }
}
