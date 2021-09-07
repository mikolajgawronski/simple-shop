<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Mail\ProductAdded;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;

class ProductController extends Controller
{

    protected Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @OA\Get(
     * path="/api/products",
     * summary="List of products",
     * description="Get all products",
     * operationId="getProducts",
     * tags={"Products"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="number", example="1"),
     *       @OA\Property(property="name", type="string", example="Potato"),
     *       @OA\Property(property="description", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam"),
     *       @OA\Property(property="price", type="float", example="123.45"),
     *       @OA\Property(property="currency", type="string", example="PLN"),
     *       )
     *    )
     * )
     * )
     */
    /**
     * @OA\Get(
     * path="/api/products/{sort}",
     * summary="List of products",
     * description="Get list of products sorted by a column of your choice (ID is the default)",
     * operationId="getProductsSorted",
     * tags={"Products"},
     * @OA\Parameter(
     *    description="Sort by a column of your choice (id, name, description, price or currency)",
     *    in="path",
     *    name="sort",
     *    required=false,
     *    example="name",
     *    @OA\Schema(
     *       type="string"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="number", example="1"),
     *       @OA\Property(property="name", type="string", example="Potato"),
     *       @OA\Property(property="description", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam"),
     *       @OA\Property(property="price", type="float", example="123.45"),
     *       @OA\Property(property="currency", type="string", example="PLN"),
     *       )
     *    )
     * )
     * )
     */
    public function index($sort = "id")
    {
        return Product::query()->orderBy($sort,"asc")->paginate(10);
    }


    /**
     * @OA\Get(
     * path="/api/products/show/{id}",
     * summary="Details of a product",
     * description="Get one of products",
     * operationId="getProduct",
     * tags={"Products"},
     * @OA\Parameter(
     *    description="ID of a product",
     *    in="path",
     *    name="id",
     *    required=false,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="number", example="1"),
     *       @OA\Property(property="name", type="string", example="Potato"),
     *       @OA\Property(property="description", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam"),
     *       @OA\Property(property="price", type="float", example="123.45"),
     *       @OA\Property(property="currency", type="string", example="PLN"),
     *       )
     *    )
     * )
     * )
     */
    public function show($id = null)
    {
        return Product::query()->findOrFail($id);
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
            //$this->sendMail($this->mailer);
            return [
                "Result" => "Product has been added",
            ];
        }
        return [
            "Result" => "Add operation failed",
        ];
    }

    /**
     * @OA\Put(
     * path="/api/products/update/{id}",
     * summary="Update a product",
     * description="Update one of products",
     * operationId="updateProduct",
     * tags={"Products"},
     * @OA\Parameter(
     *    description="ID of a product",
     *    in="path",
     *    name="id",
     *    required=false,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
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
     *       @OA\Property(property="Result", type="string", example="Product has been updated")
     *        )
     *     )
     * )
     * )
     */
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

    /**
     * @OA\Delete(
     * path="/api/products/delete/{id}",
     * summary="Delete a product",
     * description="Delete one of products",
     * operationId="deleteProduct",
     * tags={"Products"},
     * @OA\Parameter(
     *    description="ID of a product",
     *    in="path",
     *    name="id",
     *    required=false,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Product Added Response",
     *    @OA\JsonContent(
     *       @OA\Property(property="Result", type="string", example="Product has been deleted")
     *        )
     *     )
     * )
     * )
     */
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

    private function sendMail(Mailer $mailer): void
    {

        $details = [
            "title" => "Product Added",
            "body" => "Thank you for adding a product to our database."
        ];

        $mailer->to("fake@example.com")->send(new ProductAdded($details));

    }
}
