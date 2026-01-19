<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;

class DaftarIsiController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all categories for the sidebar
        $categories = Category::all();
        
        // Start building the query for contents
        $query = Content::with(['category', 'lemma', 'media']);
        
        // Filter by category if provided in query string
        if ($request->has('category')) {
            $categorySlug = $request->get('category');
            $category = Category::where('slug', $categorySlug)->first();
            
            if ($category) {
                $query->where('cat_id', $category->id);
            }
        }
        
        // Paginate the results
        $contents = $query->paginate(12);
        
        // Get the selected category slug for UI highlighting
        $selectedCategory = $request->get('category');
        
        return view('pages.daftar_isi', compact('categories', 'contents', 'selectedCategory'));
    }
}
