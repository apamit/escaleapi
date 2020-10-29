<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollectionResource;
use App\Models\Business;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    protected $business;
    protected $product;

    /**
     * __construct
     *
     * @param  mixed $product
     * @return void
     */
    public function __construct(Business $business, Product $product)
    {
        $this->business = new $business;
        $this->product  = new $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = $this->product->all();

        $productCollection = ProductCollectionResource::collection($product);

        return response()->json(['success' => true, 'data'=> $productCollection], 200);
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
            $validator = Validator::make($request->all(), $this->product->rules(), $this->product->validationCustomMessage());

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }

            $business = $this->business->find($request->get('business_id'));

            $product = $business->product()->create($request->all());

            if($request->hasFile('image')) {

                try {
                    //save product image

                    $product->addMultipleMediaFromRequest(['image'])
                                ->each(function ($fileAdder) {
                                    $fileAdder->toMediaCollection('product');
                                });


                } catch(\Exception $exception) {

                    if($product->exists()){
                        $product->delete();
                     }

                     throw new \Exception($exception->getMessage());
                }
            }
            return response()->json(['success' => true, 'message' => trans('constant.product.product_created_successfully')], 200);

        } catch (\Exception $exception) {
                return response()->json(['success' => false, 'exception_code' => $exception->getCode(), 'message' => $exception->getMessage()], 400);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = $this->product->find($request->id);

        if($product){

            $validator = Validator::make($request->all(), $this->product->updateRules(), $this->product->validationCustomMessage());

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }

            $product->update($request->all());

            if ($request->hasFile('image')) {

                $mediaIds = $product->getMedia('product')->pluck('id')->toArray();

                try {
                    //save product image

                    $product->addMultipleMediaFromRequest(['image'])
                                ->each(function ($fileAdder) {
                                    $fileAdder->toMediaCollection('product');
                                });

                    foreach ($mediaIds as $id) {
                        $product->deleteMedia($id);
                    }

                } catch (\Exception $exception) {

                    throw new \Exception($exception->getMessage());
                }

            }

            return response()->json(['success' => true, 'message' => trans('constant.product.product_updated_successfully')], 200);

        }else{
            return response()->json(['success' => false, 'message' => trans('constant.product.the_selected_product_id_is_invalid')], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);

        if($product){

            //Delete Product data with media data and media file
            $product->delete();

            return response()->json(['success' => true, 'message' => trans('constant.product.product_deleted_successfully')], 200);

        }else{
            return response()->json(['success' => false, 'message' => trans('constant.product.the_selected_product_id_is_invalid')], 422);
        }
    }
}
