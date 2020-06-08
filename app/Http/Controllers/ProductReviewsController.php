<?php

namespace App\Http\Controllers;

use App\product_reviews;
use Illuminate\Http\Request;
use App\products;
use Auth;

class ProductReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productReview($id)
    {
        //Get the product object as a collection
        $product = products::find($id);
        //Get all the reviews attached to it
        $reviews = product_reviews::where('product_id', $product->id)->get();
        //Check if the particular product has reviews
        if(count($reviews) > 0)
        {
            $response = [
              "status" => "success",
              "message" => "Product reviews retrieved successfully",
              "data" => $reviews
            ];
            return response()->json($response, 200);
        }
        else
        {
            $response = [
                "status" => "success",
                "message" => "No review has been posted has been posted yet",
                "data" => null
            ];
            return response()->json($response, 200);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        $this->validate($request, [
            "comment" => 'required'
        ]);
        $product = products::find($id);
        $review = new product_reviews;
        $review->user_id = auth::user()->id;
        $review->comment= $request['comment'];
        if($product != null)
        {
            $review->product_id = $product->id;
            $review->save();
            $response = [
                "status" => "success",
                "message" => "Review successfully added",
                "data" => $review
            ];
            return response()->json($response, 201);
        }
        else
        {
            $response = [
                "status" => "error",
                "message" => "The product you are trying to add a review for is not available",
                "data" => null
            ];
            return response()->json($response, 404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\product_reviews  $product_reviews
     * @return \Illuminate\Http\Response
     */
    public function show(product_reviews $product_reviews)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product_reviews  $product_reviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
            "comment" => 'required'
        ]);
        $review = product_reviews::find($id);
        if($review->user_id != auth::user()->id){
            $response = [
                "status" => "error",
                "message" => "Unauthorized action"
            ];
            return response()->json($response, 401);
        }
        else
        {
            $review->comment = $request["comment"];
            $review->update();
            $response = [
                "message" => "Comment successfully updated",
                "data" => $review
            ];
            return response()->json($response, 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product_reviews  $product_reviews
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $review = product_reviews::find($id);
        if($review->user_id != auth::user()->id)
        {
            return response()->json(["status" =>"error","message" => "Unauthorized action"], 401);
        }

        if ($review != null) {
            if ($review->delete()) {
                return response([
                    'status' => 'success',
                    'data'   => null,
                    'message' => 'Review deleted successfully'
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'data' => null,
                    'code' => 500,
                    'message' => 'Update Failed!'
                ])->setStatusCode(500);
            }
        } else {
          
          return response([
                'status' => 'error',
                'data' => null,
                'code' => 404,
                'message' => 'Review with ID of ' . $id . 'Not found'
            ])->setStatusCode(404);
        }
    }
}
