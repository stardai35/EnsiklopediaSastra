<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;

class EnsisaController extends Controller
{
    public function home()
    {
        return view('home', [
            'categories' => Category::withCount('contents')->get(),
            'latest' => Content::latest()->limit(6)->get()
        ]);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('category', compact('category'));
    }

    public function content($slug)
    {
        $content = Content::with(['media.type', 'media.position', 'references'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('content', compact('content'));
    }
}
