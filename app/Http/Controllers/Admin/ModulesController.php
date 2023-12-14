<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Constant;
use App\Libraries\CustomErrorHandler;
use App\Models\Module;
use App\Models\Modulename;
use App\Models\User;
use App\Models\WSErrorHandler;
use DataTables;
use DB;
use App\Models\SeoMeta; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Redirect;
use Illuminate\Support\Str;

class ModulesController extends Controller 
{
    // MODULE LISTING
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $moduleList = Module::select(
                'id',
                'title',
                'content',            
                 DB::RAW('DATE_FORMAT(created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
                 'created_at',
            );

            return Datatables::of($moduleList)->make(true);
        }
        $moduleList = array(
            'title' => 'Modules',
            'name' => 'modules',
            'add_route' => 'post-type.modules',
            'list_route' => 'admin.modules',
        );

       // $modulesname = Modulename::all();

        return view('admin.modules.index', array('moduleList' => $moduleList));
    }

    /* CREATE MODULE */
    public function create(Request $request)
    {
      //  $modulesname = Modulename::all();
        // return view('admin.modules.create',compact('modulesname'));
        $randomString               = Str::random(10);
        $moduleDetails                = array();
        
        $moduleDetails['id']     = null;
        $moduleDetails['title']       = 'Add New Module';
        $moduleDetails['actionRoute'] = 'post-type.create-modules';
        $moduleDetails['post_types']  = 'modules';
        $moduleDetails['idContent']   = $randomString;
        $moduleDetails['moduleInfo']    = null;
        $moduleDetails['main_title']      = 'modules';
        $moduleDetails['name']            = 'modules';
        return view('admin.modules.create', array('moduleDetails' => $moduleDetails));
    }

    /* INSERT MODULE Data */
    public function createmodule(Request $request) 
    { 

        $randomString               = Str::random(10);
        $moduleDetails                = array();
        
        $moduleDetails['id']     = null;
        $moduleDetails['title']       = 'Add New Module';
        $moduleDetails['actionRoute'] = 'post-type.create-modules';
        $moduleDetails['post_types']  = 'modules';
        $moduleDetails['idContent']   = $randomString;
        $moduleDetails['moduleInfo']    = null;
        $moduleDetails['main_title']      = 'modules';
        $moduleDetails['name']            = 'modules';
       
       // $modulesname = Modulename::all();
        if($request->title == 'faq-module'){
            $validator = \Validator::make($request->all(), [
                'faqheading' => 'required',
                'faqmodule' => 'required',
            ],
            [
                'required'  => 'The field is required.',
                'unique'    => ':attribute is already used'
            ]);
            $allData = [
                'faqheading' => $request->faqheading,
                'faqmodule' => $request->faqmodule     
            ];   
        }
        elseif($request->title == 'testimonial-module'){
            $validator = \Validator::make($request->all(), [
                'tshead' => 'required',
                'testimonials' => 'required',
            ],
            [
                'required'  => 'The field is required.'  
            ]);
            $allData = [
             'tshead' => $request->tshead,
             'testimonials' => $request->testimonials, 
             ]; 

            // dd($allData);
        }
        elseif($request->title == 'contact-us-module'){
            $validator = \Validator::make($request->all(), [
                'cfhead' => 'required',
                'cfaddlink' => 'required',
                'inputs' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
    
            $allData = [
                'cfhead' => $request->cfhead,
                'cfdesc' => isset($request->cfdesc)? $request->cfdesc : '',
                'cfaddlink' => $request->cfaddlink,
                'cfbtnlbl' => isset($request->cfbtnlbl) ? $request->cfbtnlbl :'',
                'cfbtnlink' => isset($request->cfbtnlink) ? $request->cfbtnlink :'',
                'inputs' => $request->inputs,
            ];   
        }
        elseif($request->title == 'banner-module'){
            $validator = \Validator::make($request->all(), [
                'bnhead' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
            if($request->sourcebtnstatus == '1'){
                $sourcelbl = $request->sourcelbl;
                $sourcelink = $request->sourcelink;
            }
            $allData = [
                'bnhead' => $request->bnhead,
                'bnsubhead' => $request->bnsubhead?$request->bnsubhead:'',
                'sourcebtnstatus'  => $request->sourcebtnstatus,
                'sourcelbl' => isset($sourcelbl)?$sourcelbl:'',
                'sourcelink' => isset($sourcelink)?$sourcelink:'',
            ];   
        }
        elseif($request->title == 'about-img-left-module'){
            $validator = \Validator::make($request->all(), [
                'abhead' => 'required',
                'abdesc' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
            if($request->sourcebtnstatus == '1'){
                $sourcelbl = $request->sourcelbl;
                $sourcelink = $request->sourcelink;
            }
            $allData = [
                'abhead' => $request->abhead,
                'abdesc' => $request->abdesc,
                'sourcebtnstatus'  => $request->sourcebtnstatus,
                'sourcelbl' => isset($sourcelbl)?$sourcelbl:'',
                'sourcelink' => isset($sourcelink)?$sourcelink:'',
            ];   
        }
        elseif($request->title == 'about-img-right-module'){
            $validator = \Validator::make($request->all(), [
                'abhead' => 'required',
                'abdesc' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
            if($request->sourcebtnstatus == '1'){
                $sourcelbl = $request->sourcelbl;
                $sourcelink = $request->sourcelink;
            }
            $allData = [
                'abhead' => $request->abhead,
                'abdesc' => $request->abdesc,
                'sourcebtnstatus'  => $request->sourcebtnstatus,
                'sourcelbl' => isset($sourcelbl)?$sourcelbl:'',
                'sourcelink' => isset($sourcelink)?$sourcelink:'',
            ];   
        }
        elseif($request->title == 'discover-tour-slider-module'){
            $validator = \Validator::make($request->all(), [
                'dthead' => 'required',
                'tours' => 'required'
            ],
            [
                'required'  => 'The field is required.',
            ]);
            $allData = [
                'dthead' => $request->dthead,
                'tours' => $request->tours
            ];   
        } 
        elseif($request->title == 'have-question-module'){
            $validator = \Validator::make($request->all(), [
                'hqhead' => 'required',
                'hqsubhead' => 'required',
                'hqdesc' => 'required',
                'sourcebtnstatus' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
            if($request->sourcebtnstatus == '1'){
                $sourcelbl = $request->hqbtnlbl;
                $sourcelink = $request->hqbtnlink;
            }
            $allData = [
                'hqhead' => $request->hqhead,
                'hqsubhead' => $request->hqsubhead,
                'hqdesc' => $request->hqdesc,
                'sourcebtnstatus'  => $request->sourcebtnstatus,
                'hqbtnlbl' => isset($sourcelbl)?$sourcelbl:'',
                'hqbtnlink' => isset($sourcelink)?$sourcelink:'',
            ];   
        }
        elseif($request->title == 'why-shundiin-module'){
            $validator = \Validator::make($request->all(), [
                'wshead' => 'required',
                'services' => 'required'
            ],
            [
                'required'  => 'The field is required.',
            ]);
            $allData = [
                'wshead' => $request->wshead,
                'services' => $request->services
            ];   
        }
        elseif($request->title == 'experience-shundiin-tour-module'){
            $validator = \Validator::make($request->all(), [
                'eshead' => 'required',
                'eslink' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
            $allData = [
                'eshead' => $request->eshead,
                'eslink' => $request->eslink,
                'eswidth' => $request->eswidth ? $request->eswidth : 1170,
                'esheight' => $request->esheight ? $request->esheight : 450,
            ];   
        }
        elseif($request->title == 'contact-form-module'){
            $validator = \Validator::make($request->all(), [
                'cfhead' => 'required',
                'cfdesc' => 'required',
                'cfaddlink' => 'required',
                'inputs' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
            $allData = [
                'cfhead' => $request->cfhead,
                'cfdesc' => $request->cfdesc,
                'cfaddlink' => $request->cfaddlink,
                'cfbtnlbl' => $request->cfbtnlbl ? $request->cfbtnlbl :'',
                'cfbtnlink' => $request->cfbtnlink ? $request->cfbtnlink :'',
                'inputs' => $request->inputs,
            ];   
        }
        elseif($request->title == 'image-slider-module'){
            $validator = \Validator::make($request->all(), [
                'sliders' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
    
            $allData = [
                'sliders' => $request->sliders,
            ];   
        }
        elseif($request->title == 'gallery-module'){
            $validator = \Validator::make($request->all(), [
                'document' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
    
            $allData = [
                'document' => $request->document,
            ];   
        }
        elseif($request->title == 'what-expect-lower-antelope-module'){
            $validator = \Validator::make($request->all(), [
                'sechead' => 'required',
                'secdesc' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
    
            $allData = [
                'sechead' => $request->sechead,
                'secdesc' => $request->secdesc,
            ];   
        }
        elseif($request->title == 'things-to-know-module'){
            $validator = \Validator::make($request->all(), [
                'sechead' => 'required',
                'secsubhead' => 'required',
                'secdesc' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
    
            $allData = [
                'sechead' => $request->sechead,
                'secsubhead' => $request->secsubhead,
                'secdesc' => $request->secdesc,
            ];   
        }
        elseif($request->title == 'tour-overview-module'){
            $validator = \Validator::make($request->all(), [
                'tourname' => 'required',
                'tourtime' => 'required',
                'tourscale' => 'required',
                'sechead' => 'required',
                'secdesc' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
    
            $allData = [
                'tourname' => $request->tourname,
                'tourtime' => $request->tourtime,
                'tourscale' => $request->tourscale,
                'btnlink' => isset($request->btnlink)?$request->btnlink:'',
                'sechead' => $request->sechead,
                'secdesc' => $request->secdesc,
            ];   
        }
        elseif($request->title == 'tour-inner-gallery-module'){
            $validator = \Validator::make($request->all(), [
                'sechead' => 'required',
                'document' => 'required',
            ],
            [
                'required'  => 'The field is required.',
            ]);
    
            $allData = [
                'sechead' => $request->sechead,
                'document' => $request->document,
            ];   
        }

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        else {
        $module = new Module;
        $module->title = $request->title;
        
        $module->content = json_encode($allData);
        $module->save();

        if(!$module){
            return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
        } else {
            return response()->json(['status' => 1, 'msg' => 'Module is successfully saved']);
        }
        }
        return view('admin.modules.create', array('moduleDetails' => $moduleDetails));
    }

    /* UPDATE MODULE */
    public function updatePage(Request $request){

        $qry = DB::table('modules AS p_s')
			->where('p_s.id', $request->id)
			->select([
				'p_s.id',
                'p_s.title',
                'p_s.content',
			])->orderBy('p_s.id')->get();
        $randomString               = Str::random(10);
        $moduleDetail                = array();
        $moduleDetail['id']     = $request->id;

        $moduleDetail['actionRoute'] = 'post-type.update-modules';
        $moduleDetail['title']       = 'Edit Module';
        $moduleDetail['post_types']  = 'modules';
        if(!empty($qry)){
            $moduleDetail['moduleInfo']    = $qry[0];
        }else{
            $moduleDetail['moduleInfo']    = null;
        }
        $moduleDetail['main_title']      = 'Modules';
        $moduleDetail['name']            = 'Modules';
        $moduleDetails = json_decode($qry);
        return view('admin.modules.edit',compact('request','moduleDetails','moduleDetail'));
    }

    public function updatePagedata (Request $request, $id){
        if($request->title == 'faq-module'){
        $request->validate([
            'faqheading' => 'required',
            'faqmodule' => 'required',
        ]);
        $allData = [
            'faqheading' => $request->faqheading,
            'faqmodule' => $request->faqmodule      
        ];
    }
    elseif($request->title == 'testimonial-module'){
        $validator = \Validator::make($request->all(), [
            'tshead' => 'required',
            'testimonials' => 'required',
        ],
        [
            'required'  => 'The field is required.'  
        ]);
        $allData = [
         'tshead' => $request->tshead,
         'testimonials' => $request->testimonials, 
         ]; 

        // dd($allData);
    }
    elseif($request->title == 'contact-us-module'){
        $validator = \Validator::make($request->all(), [
            'cfhead' => 'required',
            'cfaddlink' => 'required',
            'inputs' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'cfhead' => $request->cfhead,
            'cfdesc' => isset($request->cfdesc)? $request->cfdesc : '',
            'cfaddlink' => $request->cfaddlink,
            'cfbtnlbl' => isset($request->cfbtnlbl) ? $request->cfbtnlbl :'',
            'cfbtnlink' => isset($request->cfbtnlink) ? $request->cfbtnlink :'',
            'inputs' => $request->inputs,
        ];   
    }
    elseif($request->title == 'banner-module'){
        $request->validate([
            'bnhead' => 'required',
        ]);
        if($request->sourcebtnstatus == '1'){
            $sourcelbl = $request->sourcelbl;
            $sourcelink = $request->sourcelink;
        }
        $allData = [
            'bnhead' => $request->bnhead,
            'bnsubhead' => $request->bnsubhead?$request->bnsubhead:'',  
            'sourcebtnstatus'  => $request->sourcebtnstatus,
            'sourcelbl' => isset($sourcelbl)?$sourcelbl:'',
            'sourcelink' => isset($sourcelink)?$sourcelink:'',
        ]; 
    }
    elseif($request->title == 'about-img-left-module'){
        $validator = \Validator::make($request->all(), [
            'abhead' => 'required',
            'abdesc' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);
        if($request->sourcebtnstatus == '1'){
            $sourcelbl = $request->sourcelbl;
            $sourcelink = $request->sourcelink;
        }
        $allData = [
            'abhead' => $request->abhead,
            'abdesc' => $request->abdesc,
            'sourcebtnstatus'  => $request->sourcebtnstatus,
            'sourcelbl' => isset($sourcelbl)?$sourcelbl:'',
            'sourcelink' => isset($sourcelink)?$sourcelink:'',
        ];   
    }
    elseif($request->title == 'about-img-right-module'){
        $validator = \Validator::make($request->all(), [
            'abhead' => 'required',
            'abdesc' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);
        if($request->sourcebtnstatus == '1'){
            $sourcelbl = $request->sourcelbl;
            $sourcelink = $request->sourcelink;
        }
        $allData = [
            'abhead' => $request->abhead,
            'abdesc' => $request->abdesc,
            'sourcebtnstatus'  => $request->sourcebtnstatus,
            'sourcelbl' => isset($sourcelbl)?$sourcelbl:'',
            'sourcelink' => isset($sourcelink)?$sourcelink:'',
        ];   
    }
    elseif($request->title == 'discover-tour-slider-module'){
        $validator = \Validator::make($request->all(), [
            'dthead' => 'required',
            'tours' => 'required'
        ],
        [
            'required'  => 'The field is required.',
        ]);
        $allData = [
            'dthead' => $request->dthead,
            'tours' => $request->tours
        ];   
    }
    elseif($request->title == 'have-question-module'){
        $validator = \Validator::make($request->all(), [
            'hqhead' => 'required',
            'hqsubhead' => 'required',
            'hqdesc' => 'required',
            'sourcebtnstatus' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);
        if($request->sourcebtnstatus == '1'){
            $sourcelbl = $request->hqbtnlbl;
            $sourcelink = $request->hqbtnlink;
        }
        $allData = [
            'hqhead' => $request->hqhead,
            'hqsubhead' => $request->hqsubhead,
            'hqdesc' => $request->hqdesc,
            'sourcebtnstatus'  => $request->sourcebtnstatus,
            'hqbtnlbl' => isset($sourcelbl)?$sourcelbl:'',
            'hqbtnlink' => isset($sourcelink)?$sourcelink:'',
        ];   
    }
    elseif($request->title == 'why-shundiin-module'){
        $validator = \Validator::make($request->all(), [
            'wshead' => 'required',
            'services' => 'required'
        ],
        [
            'required'  => 'The field is required.',
        ]);
        $allData = [
            'wshead' => $request->wshead,
            'services' => $request->services
        ];   
    }
    elseif($request->title == 'experience-shundiin-tour-module'){
        $validator = \Validator::make($request->all(), [
            'eshead' => 'required',
            'eslink' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);
        $allData = [
            'eshead' => $request->eshead,
            'eslink' => $request->eslink,
            'eswidth' => $request->eswidth ? $request->eswidth : 1170,
            'esheight' => $request->esheight ? $request->esheight : 450,
        ];   
    }
    elseif($request->title == 'contact-form-module'){
        $validator = \Validator::make($request->all(), [
            'cfhead' => 'required',
            'cfaddlink' => 'required',
            'inputs' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'cfhead' => $request->cfhead,
            'cfdesc' => isset($request->cfdesc)? $request->cfdesc : '',
            'cfaddlink' => $request->cfaddlink,
            'cfbtnlbl' => isset($request->cfbtnlbl) ? $request->cfbtnlbl :'',
            'cfbtnlink' => isset($request->cfbtnlink) ? $request->cfbtnlink :'',
            'inputs' => $request->inputs,
        ];   
    }
    elseif($request->title == 'image-slider-module'){
        $validator = \Validator::make($request->all(), [
            'sliders' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'sliders' => $request->sliders,
        ];   
    }
    elseif($request->title == 'gallery-module'){
        $validator = \Validator::make($request->all(), [
            'document' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'document' => $request->document,
        ];   
    }
    elseif($request->title == 'what-expect-lower-antelope-module'){
        $validator = \Validator::make($request->all(), [
            'sechead' => 'required',
            'secdesc' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'sechead' => $request->sechead,
            'secdesc' => $request->secdesc,
        ];   
    }
    elseif($request->title == 'things-to-know-module'){
        $validator = \Validator::make($request->all(), [
            'sechead' => 'required',
            'secsubhead' => 'required',
            'secdesc' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'sechead' => $request->sechead,
            'secsubhead' => $request->secsubhead,
            'secdesc' => $request->secdesc,
        ];   
    }elseif($request->title == 'tour-overview-module'){
        $validator = \Validator::make($request->all(), [
            'tourname' => 'required',
            'tourtime' => 'required',
            'tourscale' => 'required',
            'sechead' => 'required',
            'secdesc' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'tourname' => $request->tourname,
            'tourtime' => $request->tourtime,
            'tourscale' => $request->tourscale,
            'btnlink' => isset($request->btnlink)?$request->btnlink:'',
            'sechead' => $request->sechead,
            'secdesc' => $request->secdesc,
        ];   
    }
    elseif($request->title == 'tour-inner-gallery-module'){
        $validator = \Validator::make($request->all(), [
            'sechead' => 'required',
            'document' => 'required',
        ],
        [
            'required'  => 'The field is required.',
        ]);

        $allData = [
            'sechead' => $request->sechead,
            'document' => $request->document,
        ];   
    }

    $module = Module::find($id);
    $module->title = $request->title;
    $module->content = json_encode($allData);
    $module->update();

    if(!$module){
        return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
    } else {
        return response()->json(['status' => 1, 'msg' => 'Module updated succesfully']);
    }
    }
    /* DELETE MODULE */
    public function destroy(int $id)
	{
		try {
            Module::destroy($id);
            $seometa = SeoMeta::where('object_id', '=', $id)->pluck('id');
            SeoMeta::destroy($seometa);
            return response()->json([
                'success' => true,
                'icon'    => 'delete',
                'type'    => 'danger',
                'message' => 'Module deleted successfully.',
            ], 200);
		}
		catch(\Exception $ex) {
			logMsg($ex);
            return response()->json([
                'success' => true,
                'message' => 'Unable to delete module.',
            ], 200);
		}
	}

    public function bulkActionModule(Request $request){ 
        $id     = $request->ids;
        $action = $request->action;

       // dd($id);
       try {
            if(!empty($action) && $action === 'delete'){
                Module::whereIn('id', $id)->delete();
                return $response = [
                    'status'  => true,
                    'data'    => array(
                        'status'  => true, 
                        'redirect' => '',
                        'message' => 'Module deleted successfully.',
                    ),
                ];
            }else{
                Module::whereIn('id', $id)->update(['status' => $action]);
                return $response = [
                    'status'  => true,
                    'data'    => array(
                        'status'  => true, 
                        'redirect' => '',
                        'message' => 'Module status update successfully.',
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

    function modulecloneData(Request $request){
        try{
            if(!empty($request->id)){
                $qry = DB::table('modules AS m_s')
                ->where('m_s.id',$request->id)
                ->first();
                // dd($qry);

                if(!empty($qry)){

                    $module = new Module;
                    $module->title = $qry->title;
                    
                    $module->content = $qry->content;
                    $module->save();

                    if(!$module){
                        return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
                    } else {
                        // return response()->json(['status' => 1, 'msg' => 'Module is successfully saved']);
                        return $response = [
                            'status'  => true,
                            'data'    => array(
                                'status'  => true, 
                                'message' => 'Module cloned succesfully.',
                            ),
                        ];
                    }
                    /* end create clone post */
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

}