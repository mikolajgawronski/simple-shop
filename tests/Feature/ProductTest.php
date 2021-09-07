<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testGettingProducts(): void
    {
        $response = $this->get("/api/products/");
        $response->assertStatus(200);
    }

    public function testCreatingProduct(): void
    {
        $response = $this->post("/api/products/create", [
            "name" => "testing_product",
            "description" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean ma",
            "price" => "123.45",
            "currency" => "PLN",
        ]);

        $response->assertStatus(200);
    }

    public function testValidationWithTooShortDescription(): void
    {
        $response = $this->post("/api/products/create", [
            "name" => "testing_product",
            "description" => "Lorem ipsum dolor sit amet",
            "price" => "123.45",
            "currency" => "PLN",
        ]);

        $response->assertStatus(302);
    }
}
