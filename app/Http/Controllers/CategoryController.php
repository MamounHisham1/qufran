<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(Category $category)
    {
        $lessons = $category->posts->where('type', '!=', 'fatwa');
        $fatawa = $category->posts->where('type', 'fatwa');
        $blogs = $category->blogs;
        $exams = $category->exams()->where('start_at', '<=', now())->where('end_at', '>=', now())->get();

        $categories = Category::where('id', '!=', $category->id)->get();
        return view('categories', [
            'category' => $category,
            'categories' => $categories,
            'lessons' => $lessons,
            'fatawa' => $fatawa,
            'blogs' => $blogs,
            'exams' => $exams,
        ]);
    }
}
