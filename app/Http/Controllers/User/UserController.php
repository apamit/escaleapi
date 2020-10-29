<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollectionResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = new $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->all();

        $userCollection = UserCollectionResource::collection($user);

        return response()->json(['success' => true, 'data'=> $userCollection], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    try{
        $validator = Validator::make($request->all(), $this->user->rules(), $this->user->validationCustomMessage());

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $user = $this->user->create($request->all());

        if($request->hasFile('profilePic')) {

            try {
                //save profile image
                $user->addMedia($request->file('profilePic'))->toMediaCollection('user');

            } catch(\Exception $exception) {

                if($user->exists()){
-                   $user->delete();
                }
                 throw new \Exception('There is a problem in uploading file.');
            }
        }

        return response()->json(['success' => true, 'message' => trans('constant.user.user_created_successfully')], 200);

    } catch (\Exception $exception) {

            return response()->json(['success' => false, 'exception_code' => $exception->getCode(), 'message' => $exception->getMessage()], 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
