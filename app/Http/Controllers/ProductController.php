<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Tag;
use App\Models\Products\ProductImage;
use Illuminate\Http\Response;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product =Product::all()->with(['tag','image']);

        return response()->json(['success' => 'success','data'=>$product]);
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
    public function store(ProductRequest $request)
    {
        $product= new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->amount = $request->amount;
        $product->price = $request->price;
        $product->save();

        if($request->tag) {
            $product->tags()->attach($request->tag);
        }
        if ($request->image) {
            foreach ($request->image as $key => $i) {
                $image = new ProductImage();
                $image->url = $i;
                $image->product_id = $product->id;
                $image->save();
            }
        }
        return response()->json(['success' => 'success']);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product=  Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->amount = $request->amount;
        $product->price = $request->price;
        $product->save();

        if($request->tag) {
            $product->tags()->delete();
            $product->tags()->attach($request->tag);
        }
        if ($request->image) {
            foreach ($request->image as $key => $i) {
                $image = new ProductImage();
                $image->url = $i;
                $image->product_id = $product->id;
                $image->save();
            }
        }
        return response()->json(['success' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =  Product::find($id);
        $product->images()->delete();
        $product->tags()->delete();
        Product::deleted($id);
        return response()->json(['success' => 'success']);

    }
}
