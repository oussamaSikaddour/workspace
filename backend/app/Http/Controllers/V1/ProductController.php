<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\workSpace\StoreProductRequest;
use App\Http\Requests\V1\workSpace\UpdateProductRequest;
use App\Http\Resources\V1\workspace\ProductResource;
use App\Models\Image;
use App\Models\Product;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use Utilities;

    public function index(Request $request)
    {
        try {
            // Define the base query with eager loading of related models
            $query = Product::query();
            if ($request->query('price')) {
                $price= $request->input("price");
                $query->where('price',$price);
            }
            if ($request->query('name')) {
                $name = $request->input("name");
                $query->where('name','like','%'.$name.'%');
            }
            if ($request->query('status')) {
                $status = $request->input("status");
                $query->where('status',$status);
            }

            if ($request->query("includeAll")) {
                $products = $query->get();
                $products = ProductResource::collection($products);
            } else {
                $products = $query->get()->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'status' => $product->status,
                    ];
                });
            }
            // Return the formatted data as a JSON response
            return response()->json([
                'status' => 'success',
                'products' => $products
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des jours de congés",
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getProductsForUser(Request $request)
    {
        try {
            // Define the base query with eager loading of related models
            $products = Product::query()->with(["images"])
                    ->where("status", "active")
                    ->take(4) // Use take() instead of get() with a limit of 4
                    ->get();
            // Return the formatted data as a JSON response
            return response()->json([
                'status' => 'success',
                'products' => ProductResource::collection($products)
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des jours de congés",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(String $lang, StoreProductRequest $request)
    {
        try {

            $data = $request->validated();
            $product = Product::create($data);
            $images = $request->allFiles("images");

            if ($images) {
                $this->uploadAndCreateImages($images["images"], $product->id, "App\Models\Product", "product image");
            }

            $product->loadMissing('images');
            return response()->json([
                'message' => 'Product created successfully',
                'product' => new ProductResource($product)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création du produit",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, Product $product)
    {
        try {
            $product->loadMissing('images');
            return response()->json([
                'message' => 'Product retrieved successfully',
                'product' => new ProductResource($product)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du Product",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, UpdateProductRequest $request, Product $product)
    {
        try {
            $data = $request->validated();
            $images = $request->allFiles('images');
            if ($images) {
                $this->uploadAndUpdateImages($images["images"], $product->id, "App\Models\Product", "product image");
            }

            $product->update($data);
            $product->loadMissing('images');
            return response()->json([
                'message' => 'Product updated successfully',
                'product' => new ProductResource($product)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la création du produit",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, Product $product)
    {
        try {
            Image::where('imageable_id', $product->id)->where('imageable_type', 'App\Models\Product')->each(function ($image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            });
            $product->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du Product",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }}
