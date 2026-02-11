<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Ambil konten untuk kategori berdasarkan ID
        $categoryContents = [];
        foreach ($categories as $category) {
            $categoryContents[$category->id] = Content::where('cat_id', $category->id)
                ->with('lemma', 'media')
                ->take(3)
                ->get();
        }

        // Ambil popular people (category 1 = Pengarang) - randomized
        $popularPeople = Content::where('cat_id', 1)
            ->with('lemma', 'media')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Hitung statistik
        $totalContent = Content::count();
        $totalCategories = Category::count();
        $totalAuthors = Content::where('cat_id', 1)->count();

        return view('home.index', [
            'categories' => $categories,
            'categoryContents' => $categoryContents,
            'popularPeople' => $popularPeople,
            'totalContent' => $totalContent,
            'totalCategories' => $totalCategories,
            'totalAuthors' => $totalAuthors,
        ]);
    }

    public function daftarIsi(Request $request): View
    {
        $categories = Category::all();

        // Query dasar
        $query = Content::with('lemma', 'category', 'media');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('lemma', function ($lemmaQuery) use ($search) {
                        $lemmaQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('cat_id', $request->category);
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'terlama':
                $query->orderBy('year', 'asc');
                break;
            case 'judul_az':
                $query->join('lemma', 'content.title_id', '=', 'lemma.id')
                      ->orderBy('lemma.name', 'asc')
                      ->select('content.*');
                break;
            case 'judul_za':
                $query->join('lemma', 'content.title_id', '=', 'lemma.id')
                      ->orderBy('lemma.name', 'desc')
                      ->select('content.*');
                break;
            case 'terbaru':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // Pagination
        $contents = $query->paginate(9);

        // Ambil kategori yang dipilih
        $selectedCategory = $request->filled('category') ?
            Category::find($request->category) : null;

        return view('home.daftar-isi', [
            'contents' => $contents,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'sort' => $sort,
            'search' => $request->search ?? null,
        ]);
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $contents = Content::where('cat_id', $category->id)
            ->with('lemma', 'media')
            ->paginate(9);
        $categories = Category::all();

        return view('home.category', [
            'category' => $category,
            'contents' => $contents,
            'categories' => $categories,
        ]);
    }

    public function detail(string $slug): View
    {
        $content = Content::where('slug', $slug)
            ->with('lemma', 'media')
            ->firstOrFail();
        $relatedContents = Content::where('cat_id', $content->cat_id)
            ->where('id', '!=', $content->id)
            ->with('lemma', 'media')
            ->take(3)
            ->get();
        $categories = Category::all();

        return view('home.detail', [
            'content' => $content,
            'relatedContents' => $relatedContents,
            'categories' => $categories,
        ]);
    }

    public function about(): View
    {
        $categories = Category::all();

        return view('home.about', [
            'categories' => $categories,
        ]);
    }

    public function contributors(): View
    {
        return view('home.contributors');
    }
}
