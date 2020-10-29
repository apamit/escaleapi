<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessCollectionResource;
use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{

    protected $user;
    protected $business;

    /**
     * __construct
     *
     * @param  mixed $business
     * @return void
     */
    public function __construct(User $user, Business $business)
    {
        $this->user     = new $user;
        $this->business = new $business;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business = $this->business->all();

        $businessCollection = BusinessCollectionResource::collection($business);

        return response()->json(['success' => true, 'data'=> $businessCollection], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $validator = Validator::make($request->all(), $this->business->rules(), $this->business->validationCustomMessage());

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }

            $user = $this->user->find($request->get('user_id'));
            $user->business()->create($request->all());

            return response()->json(['success' => true, 'message' => trans('constant.business.business_created_successfully')], 200);

        } catch (\Exception $exception) {

                return response()->json(['success' => false, 'exception_code' => $exception->getCode(), 'message' => $exception->getMessage()], 400);

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
    }
}
