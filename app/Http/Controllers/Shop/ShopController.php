<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index(string $slug = null) {
        $products = null;

        if (!$slug) {
            $products = Product::all();
        } else {
            $category = Category::where('slug', $slug)->firstOrFail();
            $products = Product::where('category_id', $category->id)->get();
        }

        $categories = Category::all();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'slug' => $slug,
        ]);
    }

}
