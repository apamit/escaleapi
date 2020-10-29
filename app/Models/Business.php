<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business';

    //fillable fields
    protected $fillable = [
        'company_name',
        'email',
        'registration_no',
        'created_at',
        'updated_at'
    ];

    /**
     * validation
     *
     * @return void
     */
    public function rules()
    {
        return  array(
            'user_id'           => 'required|exists:users,id',
            'company_name'      => 'required',
            'email'             => 'required|email|unique:business,email',
            'registration_no'   => 'required|unique:business,registration_no',
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
            'company_name.required' => 'The company name is required',
            'email.required'        => 'The :attribute field is required',
            'email.email'           => 'This :attribute is invalid',
            'email.unique'          => 'This :attribute already exists',
            'registration_no.unique'=> 'This registration no. already exists'
        );
    }

    /**
     * product
     *
     * @return void
     */
    public function product(){
        return $this->hasMany('App\Models\Product');
    }

    /**
     * user
     *
     * @return void
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
