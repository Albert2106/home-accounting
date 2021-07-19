<?php


namespace App\Http\Controllers;


use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = (new Category())->getItems();
        return view('categories.index', compact('categories'));
    }
}
