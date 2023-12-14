<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Libraries\Constant;
use App\Libraries\CustomErrorHandler;
use App\Models\User;
use App\Models\WSErrorHandler;
use DataTables;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Redirect;
use Auth;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /* Admin Side User Listing Page */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userList = User::select(
                'id',
                DB::RAW('CONCAT(first_name," ",last_name) as full_name'),
                'email',
                'user_type',
                'status',
                'profile_picture',
                DB::RAW('DATE_FORMAT(created_at, "%d/%m/%Y") as display_created_at'),
                'created_at'
            )->where('id','!=', Auth::id());

            if ($request->get('filterUserType')) {
                $userList = $userList->WHERE('user_type', $request->get('filterUserType'));
            }
            return Datatables::of($userList)->make(true);
        }
        $userTypeList = Constant::getUserType();
        return view('admin.user.list', array('userTypeList' => $userTypeList));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $retData = array(
            'userTypeList' => Constant::getUserType(),
            'userMenuList' => Constant::getMenuList(),
        );
        return view('admin.user.add', $retData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $requestData = $request->all();
            // dd($requestData);
            if (isset($requestData['thumbnail']) && $requestData['thumbnail']) {
                $requestData['profile_picture'] = $requestData['thumbnail'];
            }

            $requestData['name'] = $requestData['first_name'] . ' ' . $requestData['last_name'];
            $userObj = User::create($requestData);
            return redirect(route('user.index'))->with('success', 'User Added Successfully.');
        } catch (\Exception$e) {
            CustomErrorHandler::APIServiceLog($e, "UserController: store");
            return back()->with('error', 'Something Went Wrong.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $retData = array(
            'data' => $user,
            'userTypeList' => Constant::getUserType(),
        );
        return view('admin.user.add', $retData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $requestData = $request->all();
            if (isset($requestData['thumbnail']) && $requestData['thumbnail']) {
                $requestData['profile_picture'] = $requestData['thumbnail'];
            }else{
                $requestData['profile_picture'] = '';
            }
            $userObj = User::findOrFail($requestData['id']);
            $userObj->update($requestData);
            return redirect(route('user.index'))->with('success', 'User Updated Successfully.');
        } catch (\Exception$e) {
            // CustomErrorHandler::APIServiceLog($e, "UserController: update");
            return back()->with('error', 'Something Went Wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.',
            ], 200);
        } catch (\Exception$e) {
            // CustomErrorHandler::APIServiceLog($e, "UserController: destroy");
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong.',
            ], 200);
        }
    }

    /**
     * Display User Image from storage.
     *
     * @param  use File $filename
     * @return \Illuminate\Http\Response
     */
    public function displayUserImage($filename)
    {
        $path = storage_path('app/public/user_images/' . $filename);
        if (!File::exists($path)) {
            //admin-panel/img
            $path = public_path('admin-panel/img/avatar5.png');
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    /**
     * Active\Inactive User status.
     *
     * @param  use File $filename
     * @return \Illuminate\Http\Response
     */
    public function ActiveDeactiveStatus(Request $request)
    {
        $requestData = $request->all();
        try {
            $userObj = User::findOrFail($requestData['id']);
            if ($userObj->status == 1) {
                $project = User::updateOrCreate(
                    ['id' => $requestData['id']],
                    ['status' => 0]
                );
            }
            if ($userObj->status == 0) {
                $project = User::updateOrCreate(
                    ['id' => $requestData['id']],
                    ['status' => 1]
                );
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Status Update successfully.',
            ], 200);
        } catch (\Exception$e) {
            DB::rollback();
            //CustomErrorHandler::APIServiceLog($e, "UserController: ActiveDeactiveStatus");
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong.',
            ], 200);
        }
    }

    // Error Logs
    public static function getErrorLogs()
    {
        $query = WSErrorHandler::SELECT(
            'error_handler.*',
        );
        $query = $query->ORDERBY('error_handler.created_at', 'DESC');

        // return Datatables::of($query)
        //     ->addColumn('user_name', function ($row) {
        //         return $row->name;
        //     })
        //     ->make(true);
        return \View::make('admin.common.errorlogs', array());
    }
}
