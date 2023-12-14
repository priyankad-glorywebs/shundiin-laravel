<?php
namespace App\Libraries;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Input;

class Constant {

   public static function getUserType(){
      return [
         "SuperAdmin" => "SuperAdmin",
         "Admin" => "Admin",
         "User" => "User"
      ];
   }

   public static function getMenuList(){
      return [
         'dashboard' => array(
            'value' => 'Dashboard', 
            'icon' => 'fa-tachometer-alt',
            'link' => route('home').'/admin/',
            'active_link' => array('admin'),
            'current_links' => array('admin','admin/dashboard/*'),
            'sub' => array()
         ),   
         'media' => array(
            'value' => 'Media', 
            'icon' => 'fas fa-photo-video',
            'link' => route('home').'/admin/media',
            'active_link' => array('admin/media'),
            'current_links' => array('admin/media','admin/media/*'),
            'sub' => array()
         ), 
         'posts' => array(
            'value' => 'Posts', 
            'icon' => 'fas fa-thumbtack',
            'active_link' => array('admin/post-type/posts', 'admin/posts', 'admin/posts', 'admin/posts/create', 'admin/posts/*/edit', 'admin/posts/create', 'admin/taxonomy/posts/categories', 'admin/taxonomy/posts/tags', request()->is('admin/post-type/posts/*/edit')),
            'current_links' => array('admin/posts/*'),
            'link' => route('home').'/admin/posts',
            'sub' => array(
               array(
                  'value' => 'All Posts', 
                  'icon' => 'nav-icon fas fa-thumbtack ',
                  'link' => route('home').'/admin/posts',
                  'active_link' => array('admin/posts', 'admin/posts', request()->is('admin/post-type/posts/*/edit')),
               ),
               array(
                  'value' => 'Add new', 
                  'icon' => 'fas fa-plus nav-icon',
                  'link' => route('home').'/admin/posts/create',
                  'active_link' => array( 'admin/posts/create', request()->is('admin/post-type/posts')),
               ),
               array(
                  'value' => 'Categories', 
                  'icon' => 'fas fa-list-ul nav-icon',
                  'link' => route('home').'/admin/taxonomy/posts/categories',
                  'active_link' => array( 'admin/taxonomy/posts/categories', request()->is('admin/taxonomy/posts/categories/*/edit')),
               ),
               array(
                  'value' => 'Tags', 
                  'icon' => 'fas fa-tags nav-icon',
                  'link' => route('home').'/admin/taxonomy/posts/tags',
                  'active_link' => array( 'admin/taxonomy/posts/tags', request()->is('admin/taxonomy/posts/tags/*/edit')),
               ),
            ),
         ),   
         'pages' => array(
            'value' => 'Pages', 
            'icon' => 'fas fa-book',
            'active_link' => array('admin/pages', 'admin/pages', 'admin/pages/*/edit', 'admin/post-type/pages'),
            'current_links' => array('admin/pages/*'),
            'link' => route('home').'/admin/pages',
            'sub' => array(
               array(
                  'value' => 'All Pages', 
                  'icon' => 'nav-icon fas fa-book',
                  'link' => route('home').'/admin/pages',
                  'active_link' => array('admin/pages', 'admin/pages', request()->is('admin/post-type/pages/*/edit')),
               ),
               array(
                  'value' => 'Add new', 
                  'icon' => 'fas fa-plus nav-icon',
                  'link' => route('home').'/admin/post-type/pages',
                  'active_link' => array( 'admin/post-type/pages'),
               ),
            ),
         ), 
         'contacts' => array(
            'value' => 'All Contacts', 
            'icon' => 'nav-icon fas fa-phone',
            'link' => route('home').'/admin/contacts',
            'active_link' => array('admin/contacts', 'admin/contacts', request()->is('admin/post-type/contacts/*/edit')),
         ),
         'modules' => array(
            'value' => 'Modules', 
            'icon' => 'fas fa-solid fa-tasks nav-icon',
            'active_link' => array('admin/modules', 'admin/modules', 'admin/modules/*/edit', 'admin/post-type/modules',request()->is('admin/post-type/modules/*/edit')),
            'current_links' => array('admin/modules/*'),
            'link' => route('home').'/admin/modules',
            'sub' => array(
               array(
                  'value' => 'All Modules', 
                  'icon' => 'fas fa-solid fa-list nav-icon',
                  'link' => route('home').'/admin/modules',
                  'active_link' => array('admin/modules', 'admin/modules', request()->is('admin/post-type/modules/*/edit')),
               ),
               array(
                  'value' => 'Add new', 
                  'icon' => 'fas fa-plus nav-icon',
                  'link' => route('home').'/admin/post-type/modules?module=banner-module',
                  'active_link' => array( 'admin/post-type/modules','admin/post-type/modules?module=banner-module'),
               ),
            ),
         ),            
         'user' => array(
            'value' => 'User Management', 
            'icon' => 'fa-users',
            'active_link' => array('admin/user', 'admin/user/create', 'admin/user/*/edit'),
            'current_links' => array('admin/user/*'),
            'link' => route('home').'/admin/user',
            'sub' => array(
               array(
                  'value' => 'Add User', 
                  'icon' => 'fa fa-user-plus',
                  'link' => route('home').'/admin/user/create',
                  'active_link' => array('admin/user/create', 'admin/user/create'),
               ),
               array(
                  'value' => 'User List', 
                  'icon' => 'fa-user',
                  'link' => route('home').'/admin/user',
                  'active_link' => array('admin/user', 'admin/user', request()->is('admin/user/*/edit')),
               ),
            ),
         ),
         'settings' => array(
            'value' => 'General Setting', 
            'icon' => 'fa fa-wrench',
            'active_link' => array('admin/setting', 'admin/setting'),
            'current_links' => array('admin/setting/*'),
            'link' => route('home').'/admin/setting',
         ),
         'Mail Settings' => array(
            'value' => 'Mail Setting', 
            'icon' => 'fa fa-envelope',
            'active_link' => array('admin/mailsetting', 'admin/mailsetting'),
            'current_links' => array('admin/mailsetting/*'),
            'link' => route('home').'/admin/mailsetting',
         ),
      ];
   }

}
