<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\Url;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class User extends Model implements HasMedia
{
    use HasMediaTrait;

    //fillable fields
    protected $fillable = [
            'name',
            'email',
            'bio',
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
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
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
            'name.required' =>  'The :attribute field is required',
            'email.required'=>  'The :attribute field is required',
            'email.email'   =>  'This :attribute is invalid',
            'email.unique'  =>  'This :attribute already exists'
        );
    }

    /**
     * business
     *
     * @return void
     */
    public function business()
    {
        return $this->hasMany('App\Models\Business');
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function getUrl() : string
    // {
    //     return config('medialibrary.s3.domain''/'.$this->getPathRelativeToRoot();
    // }

    /**
     * getProfilePicUrl
     *
     * @param  mixed $id
     * @return void
     */
    public function getProfilePicUrl($that){

        $m = $that->getFirstMedia('user');

        return $m ? url('/').'/storage/'.$m->id.'/'.$m->file_name : '';

    }

}
