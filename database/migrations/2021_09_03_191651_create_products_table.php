<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create("products", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->float("price");
            $table->string("currency");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("products");
    }
}
