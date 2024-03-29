<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adver_Type;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class Adver_TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('Visit_Adver_Type')) return abort(403,'عدم دسترسی');
        {
            $adver_types = Adver_Type::all();
            return view('adver_type.index' , ['adver_types' => $adver_types]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $users = User::all();
        if($id == null & Gate::allows('Insert_Adver_Type'))
        {
            $adver_type = (object)[];
            $status = 'insert';
        }
        elseif($id != null & Gate::allows('Edit_Adver_Type'))
        {
            $adver_type = Adver_Type::findOrFail($id);
            $status = 'update';
        }
        else
        {
            return abort(403 , 'عدم دسترسی');
        }
        return view('adver_type.create' , ['adver_type' => $adver_type , 'users' => $users , 'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id = null)
    {
        // dd('fmnmn');
        if($id == null & Gate::allows('Insert_Adver_Type'))
        {
            $request->validate([
                'adver_type' => 'required|min:3|unique:adver_types',
            ]);

            $adver_type = new Adver_Type();
        }
        elseif($id != null & Gate::allows('Edit_Adver_Type'))
        {
            $adver_type = Adver_Type::findOrFail($id);
            // dd($adver_type);
            $request->validate([
                'adver_type' => [
                    'required' ,
                    'min:3' ,
                    Rule::unique('Adver_types')->ignore($adver_type->id),
                ],
            ]);
        }
        else
        {
            return abort(403,'عدم دسترسی');
        }

        $adver_type->adver_type = trim($request->adver_type) ;
        $adver_type->user_id = $request->user_id;
        $adver_type->save();
        return redirect()->route('adver_type.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Gate::allows('Delete_Adver_Type')) return abort(403,'عدم دسترسی');
        {
            $adver_type = Adver_Type::findOrFail($id);
            $adver_type->adver_type_coef()->delete();
            $adver_type->delete();
            return redirect()->back();
        }
    }

    // if(!Gate::allows('Delete_Cast')) return abort(403,'عدم دسترسی');
    // {
    //     $cast = Cast::findOrFail($id);
    //     $cast->product()->delete();
    //     $cast->delete();
    //     return redirect()->back(); 
    // }

    public function search(Request $request)
    {
        $adver_types = Adver_Type::query();
        
        if($request->has('adver_type') && $request->adver_type)
        {
            $adver_types->where('adver_type' , 'like' , "%$request->adver_type%");
        }
        $adver_types = $adver_types->get();
        return view('adver_type.index' , ['adver_types' => $adver_types]);
    }

}


