<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id = null)
    {
        return $id ? Product::findOrFail($id) : Product::all();
    }

    /**
     * @OA\Post(
     * path="/api/products/create",
     * summary="Create a Product",
     * description="Create a product by providing a name, description, price and currency",
     * operationId="createProduct",
     * tags={"Products"},
     * @OA\RequestBody(
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", example="Potato"),
     *       @OA\Property(property="description", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam"),
     *       @OA\Property(property="price", type="float", example="123.45"),
     *       @OA\Property(property="currency", type="string", example="PLN"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Product Added Response",
     *    @OA\JsonContent(
     *       @OA\Property(property="Result", type="string", example="Product has been Added")
     *        )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->currency = $request->currency;
        $result = $product->save();

        if ($result) {
            return ["Result" => "Product has been added"];
        } else {
            return ["Result" => "Add operation failed"];
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::query()->findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->currency = $request->currency;
        $result = $product->save();

        if ($result) {
            return ["Result" => "Product has been updated"];
        } else {
            return ["Result" => "Add operation failed"];
        }
    }


    public function destroy($id)
    {
        $product = Product::query()->findOrFail($id);
        $result = $product->delete();

        if ($result) {
            return ["Result" => "Product has been deleted"];
        } else {
            return ["Result" => "Delete operation failed"];
        }
    }
}
