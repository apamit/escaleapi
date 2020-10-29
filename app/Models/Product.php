<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends Model implements HasMedia
{
    use HasMediaTrait;

    //fillable fields
    protected $fillable = [
        'business_id',
        'name',
        'description',
        'mrp',
        'created_at',
        'updated_at'
    ];

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return  array(
            'business_id' => 'required|exists:business,id',
            'name'        => 'required',
            'mrp'         => 'required|numeric|min:0',
        );
    }

    public function updateRules()
    {
        return  array(
            'business_id' => 'required|exists:business,id',
            'name'        => 'required',
            'mrp'         => 'required|numeric|min:0',
        );
    }

    /**
     * validationCustomMessage
     *
     * @return void
     */
    public function validationCustomMessage()
    {
        return array(
            'name.required'=>'The :attribute field is required',
            'mrp.required'=>'The :attribute field is required',
        );
    }

    /**
     * business
     *
     * @return void
     */
    public function business(){
        return $this->belongsTo('App\Models\Business');
    }

    /**
     * getProductImageUrl
     *
     * @param  mixed $id
     * @return void
     */
    public function getProductImageUrl($that){

        $images = $that->getMedia('product');

        $i=[];

        if($images){
            foreach ($images as $img) {
                $i[] = $img ? array('id' => $img->id, 'url' => url('/').'/storage/'.$img->id.'/'.$img->file_name) : '';
            }
        }

        return $i;
    }
}
