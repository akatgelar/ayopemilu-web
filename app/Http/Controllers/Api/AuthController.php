<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Election;
use App\Models\SessionModel;
use Session;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="",
     *     description="Login",
     *     operationId="auth_login",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=True,
     *                  "message"="Login Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credentials);

        if ($token) {
            $user = User::findOrFail(auth()->guard('api')->user()['id']);

            if ($user['expired_date'] > $now = \Carbon\Carbon::now()) {

                $role = Role::find($user['role_id']);
                $election = Election::find($user['election_id']);
                $caleg = User::where('role_id', '=', 2)->where('election_id', '=', $user['election_id'])->limit(1)->get();

                if ($role) {
                    $user['role'] = $role;
                } else{
                    $temp_role = [];
                    $temp_role['id'] = 0;
                    $temp_role['name'] = '';
                    $user['role'] = $temp_role;
                }

                if ($election) {
                    $user['election'] = $election;
                } else {
                    $temp_election = [];
                    $temp_election['id'] = 0;
                    $temp_election['category'] = '';
                    $temp_election['area'] = '';
                    $temp_election['subarea'] = '';
                    $temp_election['voters_all'] = 0;
                    $temp_election['voters_target'] = 0;
                    $user['election'] = $temp_election;
                }

                if (!$caleg->isEmpty()) {
                    $user['caleg_id'] = $caleg[0]['id'];
                } else {
                    $user['caleg_id'] = 0;
                }

                // save session
                Session::push('user', [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ]);
                Session::regenerate();

                return response()->json([
                    'status' => true,
                    'message' => 'Login success',
                    'data' => [
                        'auth' => [
                            'token' => $token,
                            'type' => 'bearer',
                        ],
                        'data' => $user
                    ],
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Account has expired',
                    'data' => [],
                ], 401);
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => 'Username or password not found',
                'data' => [],
            ], 401);
        }

    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="",
     *     description="Register",
     *     operationId="auth_register",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=True,
     *                  "message"="Register Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => [
                'auth' =>[
                    'token' => $token,
                    'type' => 'bearer',
                ],
                'data' => $user
            ],
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
            'data' => [],
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => true,
            'message' => 'Token refresh',
            'data' => [
                'auth' =>  [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ],
                'data' => Auth::user()
            ],
        ]);
    }
}
