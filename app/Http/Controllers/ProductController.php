<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
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
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $this->setProduct($product, $request);
        $result = $product->save();

        if ($result) {
            return [
                "Result" => "Product has been added",
            ];
        }
        return [
            "Result" => "Add operation failed",
        ];
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::query()->findOrFail($id);
        $this->setProduct($product, $request);
        $result = $product->save();

        if ($result) {
            return [
                "Result" => "Product has been updated",
            ];
        }
        return [
            "Result" => "Add operation failed",
        ];
    }

    public function destroy($id)
    {
        $product = Product::query()->findOrFail($id);
        $result = $product->delete();

        if ($result) {
            return [
                "Result" => "Product has been deleted",
            ];
        }
        return [
            "Result" => "Delete operation failed",
        ];
    }

    private function setProduct($product, Request $request): void
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->currency = $request->currency;
    }
}
