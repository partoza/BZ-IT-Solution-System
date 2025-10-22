<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); 
        return view('pages.inventory.products', compact('products'));
    }

    public function create()
    {
        return view('nonmenu.inventory.addproducts');
    }
}
