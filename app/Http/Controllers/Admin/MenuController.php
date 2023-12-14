<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Menuitem;
use App\Models\Category;
use App\Models\Post;
use Session;

class MenuController extends Controller
{	
  public function index(Request $request){
    $menuitems = '';
    $desiredMenu = ''; 
    if(isset($request['id']) && $request['id'] != 'new'){
      $id = $request['id'];
      $desiredMenu = Menu::where('id',$id)->first();
      //dd($desiredMenu);
      if($desiredMenu->content != ''){
        $menuitems = json_decode($desiredMenu->content);
        $menuitems = $menuitems[0]; 
        foreach($menuitems as $menu){
          $menu->title = Menuitem::where('id',$menu->id)->value('title');
          $menu->name = Menuitem::where('id',$menu->id)->value('name');
          $menu->slug = Menuitem::where('id',$menu->id)->value('slug');
          $menu->target = Menuitem::where('id',$menu->id)->value('target');
          $menu->type = Menuitem::where('id',$menu->id)->value('type');
          if(!empty($menu->children[0])){
            foreach ($menu->children[0] as $child) {
              $child->title = Menuitem::where('id',$child->id)->value('title');
              $child->name = Menuitem::where('id',$child->id)->value('name');
              $child->slug = Menuitem::where('id',$child->id)->value('slug');
              $child->target = Menuitem::where('id',$child->id)->value('target');
              $child->type = Menuitem::where('id',$child->id)->value('type');
            }  
          }
        }
      }else{
        $menuitems = Menuitem::where('menu_id',$desiredMenu->id)->get();                    
      }             
    }else if(isset($request['id'])) {
      $id = $request['id'];
      $desiredMenu = Menu::where('id','$id')->first();
      if($desiredMenu){
        if($desiredMenu->content != '' && $desiredMenu->content != null){
          $menuitems = json_decode($desiredMenu->content);
          $menuitems = $menuitems[0]; 
          foreach($menuitems as $menu){
            $menu->title = Menuitem::where('id',$menu->id)->value('title');
            $menu->name = Menuitem::where('id',$menu->id)->value('name');
            $menu->slug = Menuitem::where('id',$menu->id)->value('slug');
            $menu->target = Menuitem::where('id',$menu->id)->value('target');
            $menu->type = Menuitem::where('id',$menu->id)->value('type');
            if(!empty($menu->children[0])){
              foreach ($menu->children[0] as $child) {
                $child->title = Menuitem::where('id',$child->id)->value('title');
                $child->name = Menuitem::where('id',$child->id)->value('name');
                $child->slug = Menuitem::where('id',$child->id)->value('slug');
                $child->target = Menuitem::where('id',$child->id)->value('target');
                $child->type = Menuitem::where('id',$child->id)->value('type');
              }  
            }
          }
        }else{
          $menuitems = Menuitem::where('menu_id',$desiredMenu->id)->get();
        }                                   
      }           
    }
    else{
      $desiredMenu = Menu::where('id','Desc')->first();
      if($desiredMenu){
        if($desiredMenu->content != '' && $desiredMenu->content != null){
          $menuitems = json_decode($desiredMenu->content);
          $menuitems = $menuitems[0]; 
          foreach($menuitems as $menu){
            $menu->title = Menuitem::where('id',$menu->id)->value('title');
            $menu->name = Menuitem::where('id',$menu->id)->value('name');
            $menu->slug = Menuitem::where('id',$menu->id)->value('slug');
            $menu->target = Menuitem::where('id',$menu->id)->value('target');
            $menu->type = Menuitem::where('id',$menu->id)->value('type');
            if(!empty($menu->children[0])){
              foreach ($menu->children[0] as $child) {
                $child->title = Menuitem::where('id',$child->id)->value('title');
                $child->name = Menuitem::where('id',$child->id)->value('name');
                $child->slug = Menuitem::where('id',$child->id)->value('slug');
                $child->target = Menuitem::where('id',$child->id)->value('target');
                $child->type = Menuitem::where('id',$child->id)->value('type');
              }  
            }
          }
        }else{
          $menuitems = Menuitem::where('menu_id',$desiredMenu->id)->get();
        }                                   
      }           
    }
    $pageDetails['title']       = 'Menu';
    return view ('admin.apperance.menus.index',['categories'=>category::all(),'posts'=>post::all(),'menus'=>Menu::all(),'desiredMenu'=>$desiredMenu,'menuitems'=>$menuitems,'pageDetails' => $pageDetails]);
  }	

  public function store(Request $request){
	$data = $request->all(); 
	if(Menu::create($data)){ 
	  $newdata = Menu::orderby('id','DESC')->first();          
	  session::flash('success','Menu saved successfully !');             
	  return redirect("admin/manage-menus?id=$newdata->id");
	}else{
	  return redirect()->back()->with('error','Failed to save menu !');
	}
  }	

  public function addCatToMenu(Request $request){
    $data = $request->all();
    $menuid = $request->menuid;
    $ids = $request->ids;
    $menu = Menu::findOrFail($menuid);
    if($menu->content == ''){
      foreach($ids as $id){
        $data['title'] = category::where('id',$id)->value('title');
        $data['slug'] = category::where('id',$id)->value('slug');
        $data['type'] = 'category';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        Menuitem::create($data);
      }
    }else{
      $olddata = json_decode($menu->content,true); 
      foreach($ids as $id){
        $data['title'] = category::where('id',$id)->value('title');
        $data['slug'] = category::where('id',$id)->value('slug');
        $data['type'] = 'category';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        Menuitem::create($data);
      }
      foreach($ids as $id){
        $array['title'] = category::where('id',$id)->value('title');
        $array['slug'] = category::where('id',$id)->value('slug');
        $array['name'] = NULL;
        $array['type'] = 'category';
        $array['target'] = NULL;
        $array['id'] = Menuitem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->value('id');
        $array['children'] = [[]];
        array_push($olddata[0],$array);
        $oldata = json_encode($olddata);
        $menu->update(['content'=>$olddata]);
      }
    }
  }

  public function addPostToMenu(Request $request){
    $data = $request->all();
    $menuid = $request->menuid;
    $ids = $request->ids;
    $menu = Menu::findOrFail($menuid);
    if($menu->content == ''){
      foreach($ids as $id){
        $data['title'] = post::where('id',$id)->value('title');
        $data['slug'] = post::where('id',$id)->value('slug');
        $data['type'] = 'posts';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        Menuitem::create($data);
      }
    }else{
      $olddata = json_decode($menu->content,true); 
      foreach($ids as $id){
        $data['title'] = post::where('id',$id)->value('title');
        $data['slug'] = post::where('id',$id)->value('slug');
        $data['type'] = 'posts';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        Menuitem::create($data);
      }
      foreach($ids as $id){
        $array['title'] = post::where('id',$id)->value('title');
        $array['slug'] = post::where('id',$id)->value('slug');
        $array['name'] = NULL;
        $array['type'] = 'posts';
        $array['target'] = NULL;
        $array['id'] = Menuitem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->orderby('id','DESC')->value('id');                
        $array['children'] = [[]];
        array_push($olddata[0],$array);
        $oldata = json_encode($olddata);
        $menu->update(['content'=>$olddata]);
      }
    }
  }

  public function addCustomLink(Request $request){
    $data = $request->all();
    $menuid = $request->menuid;
    $menu = Menu::findOrFail($menuid);
    if($menu->content == ''){
      $data['title'] = $request->link;
      $data['slug'] = $request->url;
      $data['type'] = 'custom';
      $data['menu_id'] = $menuid;
      $data['updated_at'] = NULL;
      Menuitem::create($data);
    }else{
      $olddata = json_decode($menu->content,true); 
      $data['title'] = $request->link;
      $data['slug'] = $request->url;
      $data['type'] = 'custom';
      $data['menu_id'] = $menuid;
      $data['updated_at'] = NULL;
      Menuitem::create($data);
      $array = [];
      $array['title'] = $request->link;
      $array['slug'] = $request->url;
      $array['name'] = NULL;
      $array['type'] = 'custom';
      $array['target'] = NULL;
      $array['id'] = Menuitem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->orderby('id','DESC')->value('id');                
      $array['children'] = [[]];
      array_push($olddata[0],$array);
      $oldata = json_encode($olddata);
      $menu->update(['content'=>$olddata]);
    }
  }

  public function updateMenu(Request $request){
    $newdata = $request->all(); 
   
    $menu = Menu::findOrFail($request->menuid);            
    $content = $request->data; 
    $newdata = [];  
    $newdata['location'] = $request->location;   
    $newdata['content'] = json_encode($content);
   
    //$result = $menu->update($newdata);
    //dd($result); 
    if($menu->update($newdata)){
    return redirect()->back()->with('success','Menu Updated successfully !');
    }else{
      return redirect()->back()->with('success','Menu not Updated successfully !');
    }
  }

  public function updateMenuItem(Request $request){
    $data = $request->all();        
    $item = Menuitem::findOrFail($request->id);
   // $item->update($data);
    if($item->update($data)){
      return redirect()->back()->with('success','MenuList saved successfully  !');
     // session::flash('success','MenuList saved successfully !');
    }
  }

  public function deleteMenuItem($id,$key,$in=''){        
    $menuitem = Menuitem::findOrFail($id);
    $menu = Menu::where('id',$menuitem->menu_id)->first();
    if($menu->content != ''){
      $data = json_decode($menu->content,true);            
      $maindata = $data[0];            
      if($in == ''){
        unset($data[0][$key]);
        $newdata = json_encode($data); 
        $menu->update(['content'=>$newdata]);                         
      }else{
        unset($data[0][$key]['children'][0][$in]);
	    $newdata = json_encode($data);
        $menu->update(['content'=>$newdata]); 
      }
    }
    $menuitem->delete();
    return redirect()->back();
  }	

  public function destroy(Request $request){
    Menuitem::where('menu_id',$request->id)->delete();  
    Menu::findOrFail($request->id)->delete();
    return redirect('admin/manage-menus')->with('success','Menu deleted successfully');
  }		
}	