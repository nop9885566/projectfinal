<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // สร้างตาราง categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // coffee, noncoffee, cake
            $table->string('slug')->unique(); // coffee, noncoffee, cake (ใช้เป็น key)
            $table->string('emoji')->nullable(); // ☕, 🧋, 🍰
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // สร้างตาราง subcategories
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');        // Special, Black, White, Milk, Cocoa, Tea, Refreshing
            $table->string('slug');        // special, black, white, milk, cocoa, tea, refreshing
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category_id', 'slug']);
        });

        // Seed ข้อมูล categories จากข้อมูลเดิม
        $categories = [
            ['name' => 'Coffee',     'slug' => 'coffee',    'emoji' => '☕', 'sort_order' => 1],
            ['name' => 'Non-Coffee', 'slug' => 'noncoffee', 'emoji' => '🧋', 'sort_order' => 2],
            ['name' => 'Cake',       'slug' => 'cake',      'emoji' => '🍰', 'sort_order' => 3],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        // Seed ข้อมูล subcategories จากข้อมูลเดิม
        $coffeeId    = \App\Models\Category::where('slug', 'coffee')->first()->id;
        $noncoffeeId = \App\Models\Category::where('slug', 'noncoffee')->first()->id;

        $subcategories = [
            ['category_id' => $coffeeId,    'name' => 'Special',    'slug' => 'special',    'sort_order' => 1],
            ['category_id' => $coffeeId,    'name' => 'Black',      'slug' => 'black',      'sort_order' => 2],
            ['category_id' => $coffeeId,    'name' => 'White',      'slug' => 'white',      'sort_order' => 3],
            ['category_id' => $noncoffeeId, 'name' => 'Milk',       'slug' => 'milk',       'sort_order' => 1],
            ['category_id' => $noncoffeeId, 'name' => 'Cocoa',      'slug' => 'cocoa',      'sort_order' => 2],
            ['category_id' => $noncoffeeId, 'name' => 'Tea',        'slug' => 'tea',        'sort_order' => 3],
            ['category_id' => $noncoffeeId, 'name' => 'Refreshing', 'slug' => 'refreshing', 'sort_order' => 4],
        ];

        foreach ($subcategories as $sub) {
            \App\Models\Subcategory::create($sub);
        }

        // เพิ่มคอลัมน์ FK ในตาราง products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('id')->constrained()->onDelete('set null');
            $table->foreignId('subcategory_id')->nullable()->after('category_id')->constrained()->onDelete('set null');
        });

        // ย้ายข้อมูลจาก string เดิมไปเป็น FK
        $categoryMap = \App\Models\Category::all()->pluck('id', 'slug');

        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            $catId = $categoryMap[$product->category] ?? null;
            $subId = null;

            if ($catId && $product->subcategory) {
                $subId = \App\Models\Subcategory::where('category_id', $catId)
                    ->where('name', $product->subcategory)
                    ->first()?->id;
            }

            $product->update([
                'category_id'    => $catId,
                'subcategory_id' => $subId,
            ]);
        }

        // ลบคอลัมน์ string เดิม
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'subcategory']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // เพิ่มคอลัมน์ string กลับ
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name');
            $table->string('subcategory')->nullable()->after('category');
        });

        // ย้ายข้อมูลกลับจาก FK เป็น string
        $products = \App\Models\Product::with(['category', 'subcategory'])->get();
        foreach ($products as $product) {
            $product->update([
                'category'    => $product->category?->slug,
                'subcategory' => $product->subcategory?->name,
            ]);
        }

        // ลบ FK columns
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropColumn(['category_id', 'subcategory_id']);
        });

        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
    }
};

