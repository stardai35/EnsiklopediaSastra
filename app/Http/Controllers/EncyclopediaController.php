<?php

// app/Http/Controllers/EncyclopediaController.php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Category;
use Illuminate\Http\Request;

class EncyclopediaController extends Controller
{
    // Halaman Depan / List Artikel
    public function index()
    {
        // Mengambil konten terbaru dengan relasi lemma dan kategori
        $contents = Content::with(['lemma', 'category', 'media'])->latest()->paginate(12);
        
        return view('encyclopedia.index', compact('content'));
    }

    // Halaman Detail Artikel
    public function show($slug)
    {
        $content = Content::where('slug', $slug)
            ->with(['lemma', 'category', 'media.type', 'refLinks'])
            ->firstOrFail();

        return view('encyclopedia.show', compact('content'));
    }
}