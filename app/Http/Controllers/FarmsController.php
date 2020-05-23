<?php

namespace App\Http\Controllers;


use App\farms;
use App\address;
use Auth;
use Illuminate\Http\Request;

class FarmsController extends Controller
{
    /**
     * Display a listing of the  all the farms.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // get farmer Id
      $userId = auth::user()->id;
      // get all farms tha belong to the farmer with userId  
      $farmsForUser = farms::where('user_id', $userId)->get();
      
      return response()->json($farmsForUser, 201);
      
    }

  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',             
            'size' =>  'required|string',
            'street' => 'required|string',
            'suburb'  => 'required|string',
            'post_code'  => 'required|string',
            'city_id' => 'required|integer',        
            'country_id' => 'required|integer',
            'monthly_income' => 'string',
            'gio_location' => 'string',
            'category_id' => 'required|string'
          ]);

          // first create an addresso f the farm and store the address in the database
          $address = address::create([
            'street1' => $request->street,
            'suburb'=> $request->suburb,
            'city_id' =>  $request->city_id,
            'country_id' =>  $request->country_id,
            'post_code' => $request->post_code
          ]);
        
          // when address creation fails , return an error message
          if($address->errors){
            return response()->json($address, 424);
          }

          // create the farm and store it in the db 
          $newFarm = farms::create([
            'name' => $request->name,
            'description' => $request->description,
            'size' =>  $request->size,
            'monthly_income' => $request->monthly_income,
            'gio_location' =>  $request->gio_location,
            'address_id' => $address->id,
            'category_id' =>  $request->category_id,
            'user_id' => auth::user()->id
          ]);

          if($newFarm->errors){
            return response()->json($newFarm, 424);
          }
 
          return response()->json($newFarm, 201);
          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\farms  $farms
     * @return \Illuminate\Http\Response
     */
    public function show(farms $farms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\farms  $farms
     * @return \Illuminate\Http\Response
     */
    public function edit(farms $farms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\farms  $farms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, farms $farms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\farms  $farms
     * @return \Illuminate\Http\Response
     */
    public function destroy(farms $farms)
    {
        //
    }
}
