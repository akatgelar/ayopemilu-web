<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Election;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="",
     *     description="Get all data",
     *     operationId="user_index",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="per_page",
     *          description="Per Page value is number. ex : ?per_page=10",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          description="Page value is number. ex : ?page=2",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="sort",
     *          description="Sort value is string with rule column-name:order. ex : ?sort=id:asc",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="where",
     *          description="Where value is object. ex : ?where={'name':'john', 'dob':'1990-12-31'}",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="count",
     *          description="Count value is boolean. ex : ?count=true",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "status"=true,
     *                  "message"="Get Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        // parameter
        $where = $request->has('where') ? $request->get('where') : '{}';
        $sort = $request->has('sort') ? $request->get('sort') : 'id:asc';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $count = $request->has('count') ? $request->get('count') : false;
        $search = $request->has('search') ? $request->get('search') : '';

        // prepare parameter
        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query get
        $query = User::select('users.*',
            'c.name as created_name',
            'u.name as updated_name')
        ->join('users as c', 'c.id', '=', 'users.created_by')
        ->join('users as u', 'u.id', '=', 'users.updated_by');

        // query where
        if($where){
            foreach($where as $key => $value) {
                $query = $query->where('users.'.$key, '=', $value);
            }
        }

        // query search
        if($search){
            $query = $query->where(function ($query) use ($search){
                $query->where('users.name', 'ILIKE', '%'.$search.'%')
                    ->orWhere('users.email', 'ILIKE', '%'.$search.'%')
                    ->orWhere('users.address', 'ILIKE', '%'.$search.'%');
            });
        }

        // variable data
        $datas = [];

        // pagination
        $pagination = [];
        $pagination['page'] = (int)$page;
        $pagination['per_page'] = (int)$per_page;
        $pagination['total_data'] = $query->count('users.id');
        $pagination['total_page'] = ceil($pagination['total_data'] / $pagination['per_page']);

        // count
        if($count == true)
        {
            $query = $query->count('users.id');
            $datas['count'] = $query;
        }
        // get data
        else
        {
            $query = $query
                ->orderBy('users.'.$sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();

            foreach($query as $qry) {
                $temp = $qry;
                array_push($datas, $temp);
            };
        }

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="",
     *     description="Get data by id",
     *     operationId="user_show",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Get Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        // query get by id
        $query = User::select('users.*',
            'c.name as created_name',
            'u.name as updated_name')
        ->join('users as c', 'c.id', '=', 'users.created_by')
        ->join('users as u', 'u.id', '=', 'users.updated_by')
        ->find($id);

        $role = Role::find($query['role_id']);
        $election = Election::find($query['election_id']);
        $caleg = User::where('role_id', '=', 2)->where('election_id', '=', $query['election_id'])->limit(1)->get();

        if ($role) {
            $query['role'] = $role;
        } else{
            $temp_role = [];
            $temp_role['id'] = 0;
            $temp_role['name'] = '';
            $query['role'] = $temp_role;
        }

        if ($election) {
            $query['election'] = $election;
        } else {
            $temp_election = [];
            $temp_election['id'] = 0;
            $temp_election['category'] = '';
            $temp_election['area'] = '';
            $temp_election['subarea'] = '';
            $temp_election['voters_all'] = 0;
            $temp_election['voters_target'] = 0;
            $query['election'] = $temp_election;
        }

        if (!$caleg->isEmpty()) {
            $query['caleg_id'] = $caleg[0]['id'];
        } else {
            $query['caleg_id'] = 0;
        }

        // variable data
        $datas = $query;

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data By Id Successfull', $datas, $pagination);
    }

    /**
     * @OA\Post(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="",
     *     description="Insert data",
     *     operationId="user_store",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Insert Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        // variable data
        $temp = $request->all();
        if (array_key_exists("password", $temp)) {
            $temp['password'] = Hash::make($temp['password']);
        }

        // query insert
        $query = User::create($temp);

        // get after insert
        $datas = User::select('users.*',
            'c.name as created_name',
            'u.name as updated_name')
        ->join('users as c', 'c.id', '=', 'users.created_by')
        ->join('users as u', 'u.id', '=', 'users.updated_by')
        ->find($query['id']);

        $role = Role::find($datas['role_id']);
        $election = Election::find($datas['election_id']);
        $caleg = User::where('role_id', '=', 2)->where('election_id', '=', $datas['election_id'])->limit(1)->get();

        if ($role) {
            $datas['role'] = $role;
        } else{
            $temp_role = [];
            $temp_role['id'] = 0;
            $temp_role['name'] = '';
            $datas['role'] = $temp_role;
        }

        if ($election) {
            $datas['election'] = $election;
        } else {
            $temp_election = [];
            $temp_election['id'] = 0;
            $temp_election['category'] = '';
            $temp_election['area'] = '';
            $temp_election['subarea'] = '';
            $temp_election['voters_all'] = 0;
            $temp_election['voters_target'] = 0;
            $datas['election'] = $temp_election;
        }

        if (!$caleg->isEmpty()) {
            $datas['caleg_id'] = $caleg[0]['id'];
        } else {
            $datas['caleg_id'] = 0;
        }

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Insert Data Successfull', $datas, $pagination);
    }

    /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="",
     *     description="Update data",
     *     operationId="user_update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Update Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // variable data
        $temp = $request->all();
        if (array_key_exists("password", $temp)) {
            $temp['password'] = Hash::make($temp['password']);
        }

        // query insert
        $query = User::findOrFail($id);
        $query = $query->update($temp);

        // get after insert
        $datas = User::select('users.*',
            'c.name as created_name',
            'u.name as updated_name')
        ->join('users as c', 'c.id', '=', 'users.created_by')
        ->join('users as u', 'u.id', '=', 'users.updated_by')
        ->find($id);

        $role = Role::find($datas['role_id']);
        $election = Election::find($datas['election_id']);
        $caleg = User::where('role_id', '=', 2)->where('election_id', '=', $datas['election_id'])->limit(1)->get();

        if ($role) {
            $datas['role'] = $role;
        } else{
            $temp_role = [];
            $temp_role['id'] = 0;
            $temp_role['name'] = '';
            $datas['role'] = $temp_role;
        }

        if ($election) {
            $datas['election'] = $election;
        } else {
            $temp_election = [];
            $temp_election['id'] = 0;
            $temp_election['category'] = '';
            $temp_election['area'] = '';
            $temp_election['subarea'] = '';
            $temp_election['voters_all'] = 0;
            $temp_election['voters_target'] = 0;
            $datas['election'] = $temp_election;
        }

        if (!$caleg->isEmpty()) {
            $datas['caleg_id'] = $caleg[0]['id'];
        } else {
            $datas['caleg_id'] = 0;
        }

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Update Data Successfull', $datas, $pagination);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="",
     *     description="Delete data",
     *     operationId="user_destroy",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Delete Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        // query insert
        $query = User::findOrFail($id);
        $query = $query->delete();

        // variable data
        $datas = [];

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Delete Data Successfull', $datas, $pagination);
    }

    public function dashboard(Request $request)
    {
        // parameter
        $where = $request->has('where') ? $request->get('where') : '{}';
        $sort = $request->has('sort') ? $request->get('sort') : 'id:asc';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $count = $request->has('count') ? $request->get('count') : false;
        $search = $request->has('search') ? $request->get('search') : '';

        // prepare parameter
        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query get
        $query = User::selectRaw(
            'users.*,
            c.name as created_name,
            u.name as updated_name,
            r.name as role_name,
            e.category as election_category,
            e.area as election_area,
            e.subarea as election_subarea,
            e.voters_all as election_voters_all,
            e.voters_target as election_voters_target,
            (select count(id) from users as relawan where relawan.role_id = 3 and relawan.election_id = users.election_id) as count_relawan,
            (select count(id) from voters where voters.election_id = users.election_id) as count_pemilih,
            (select count(id) from reports where reports.election_id = users.election_id) as count_laporan'
        )
        ->join('users as c', 'c.id', '=', 'users.created_by')
        ->join('users as u', 'u.id', '=', 'users.updated_by')
        ->join('roles as r', 'r.id', '=', 'users.role_id')
        ->join('elections as e', 'e.id', '=', 'users.election_id');

        // query where
        if($where){
            foreach($where as $key => $value) {
                $query = $query->where('users.'.$key, '=', $value);
            }
        }

        // query search
        if($search){
            $query = $query->where(function ($query) use ($search){
                $query->where('users.name', 'ILIKE', '%'.$search.'%')
                    ->orWhere('users.email', 'ILIKE', '%'.$search.'%')
                    ->orWhere('users.address', 'ILIKE', '%'.$search.'%');
            });
        }

        // variable data
        $datas = [];

        // pagination
        $pagination = [];
        $pagination['page'] = (int)$page;
        $pagination['per_page'] = (int)$per_page;
        $pagination['total_data'] = $query->count('users.id');
        $pagination['total_page'] = ceil($pagination['total_data'] / $pagination['per_page']);

        // count
        if($count == true)
        {
            $query = $query->count('users.id');
            $datas['count'] = $query;
        }
        // get data
        else
        {
            $query = $query
                ->orderBy('users.'.$sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();

            foreach($query as $qry) {
                $temp = $qry;
                array_push($datas, $temp);
            };
        }

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }
}
