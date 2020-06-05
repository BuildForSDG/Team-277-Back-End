<?php

namespace App\Http\Controllers;

use App\products;
use Auth;
use App\farms;
use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // get farmer Id
      $userId = auth::user()->id;
      // get all product of the fraer has loaded   
      $farmsForUser = farms::where('user_id', $userId)->with('product')->get();
      
      return response()->json($farmsForUser, 201);
    }

    public function products()
    {   
        //Get a paginated list of products(preferably 20)
        $products = DB::table('products')->paginate(20);
        $response = [
            "status" => "success",
            "message" => "Retrieved successfully",
            "data" => $products
        ];
        return response()->json($response, 200);
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
            'quantity' =>  'required|string',
            'price' => 'required|string',
            'farm_id'  => 'required|string',
            'category_id'  => 'required|string',
            'measurement_id' => 'required|string',          
          ]);

          /// need to save image !!!!!!

          $newProduct = products::create([
            'name'  => $request->name,
            'description'=> $request->description,
            'quantity' =>  $request->quantity,
            'price' =>  $request->price,
            'category_id'  => $request->category_id,
            'farm_id' =>  $request->farm_id,
            'measurement_units_id'  => $request->measurement_id,
            'isAvailable' => 1
          ]);

          if($newProduct->errors){
            return response()->json($newProduct, 424);
          }
 
          return response()->json($newProduct, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productToFind  = products::find($id)->get();
        if( empty($productToFind) ){
          return response()->json(['message'=>' Product does not exist.'],404 );   
        }
        return  response()->json($productToFind, 201);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, products $products)
    {
        $this->validate($request, [
            'productId' => 'required|int',
            'name' => 'required|string',
            'description' => 'required|string',             
            'quantity' =>  'required|string',
            'price' => 'required|string',
            'farm_id'  => 'required|string',
            'category_id'  => 'required|string',
            'measurement_id' => 'required|string',          
          ]);

          $productToUpdate = products::find($request->productId);
          $productToUpdate->update([
            'name' => $request->name,
            'description' => $request->description,
            'quantity '=>  $request->quantity,
            'price' =>  $request->price,
            'farm_id' => $request->farm_id,
            'category_id' =>  $request->category_id,
            'measurement_id' => $request->measurement_id

          ]);

        // retun error message
        if($productToUpdate->errors ||  empty($productToUpdate)){
            return response()->json( ['message'=>' Cannot update the product. Either the id provided does not exist.'], 424);
        }

        return  response()->json( $productToUpdate, 201);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(products $products)
    {
        //
    }
}
