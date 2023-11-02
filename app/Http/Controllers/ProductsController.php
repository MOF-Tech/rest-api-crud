<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       $products =  Products::all();
       return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
                'name'=> 'required',
                'description'=> 'required',
                'slug'=> 'required',
                'category'=> 'required',
                'price'=> 'required',
        ]);
   

        $products = Products::create($request->all());
        // $products = Products::create([
        //     "name"=> "kabej",
        //     "description"=> "kabej mzuri ya green",
        //     "slug"=> "kabeji",
        //     "category"=> "groceries",
        //     "price"=> "250.98",
        // ]);

        // $products = Products::create([
        //     "name"=> $request->name,
        //     "description"=> $request->description,
        //     "slug"=> $request->slug,
        //     "category"=> $request->category,
        //     "price"=> $request->price,
        // ]);

        return response()->json([
            "message"=> "created product succesfully",
            "data"=>  $products
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $product = Products::find($id);
        return response()->json($product);
    }


    public function search($name)
    {
        //
        
        $product = Products::where("name","LIKE","%". $name ."%")->get();
        return response()->json([
            "message"=> "product found",
            "data"=> $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $id)
    {
        //
        $product = Products::find($id);
        $product->update( $request->all() );
        return response()->json([$product]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $id)
    {
        //
        $product = Products::destroy($id);
        return response()->json([
            "message"=> "item deleted",
            "data"=>$product
        ]);
       
     
    }
}