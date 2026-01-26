<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function dashboard(): View
    {
        $totalContents = Content::count();
        $totalCategories = Category::count();
        $recentContents = Content::latest()->take(5)->get();
        $totalImages = Image::count();

        return view('admin.dashboard', [
            'totalContents' => $totalContents,
            'totalCategories' => $totalCategories,
            'recentContents' => $recentContents,
            'totalImages' => $totalImages,
        ]);
    }

    public function index(Request $request): View
    {
        $query = Content::with('category', 'images');
        $categories = Category::all();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('cat_id', $request->category);
        }

        // Filter by search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('text', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->input('sort', 'newest');
        if ($sortBy === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $contents = $query->paginate(15);
        
        return view('admin.contents.index', [
            'contents' => $contents,
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'searchQuery' => $request->search,
            'sortBy' => $sortBy,
        ]);
    }

    public function create(): View
    {
        $categories = Category::all();
        
        return view('admin.contents.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'text' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slug dari title
        $validated['slug'] = Str::slug($request->title);

        $content = Content::create($validated);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('contents', 'public');
                Image::create([
                    'content_id' => $content->id,
                    'path' => $path,
                    'alt_text' => $request->title,
                ]);
            }
        }

        return redirect()->route('admin.contents.index')
            ->with('success', 'Konten berhasil ditambahkan!');
    }

    public function edit(Content $content): View
    {
        $categories = Category::all();
        
        return view('admin.contents.edit', [
            'content' => $content,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'text' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slug dari title jika ada perubahan
        if ($validated['title'] !== $content->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $content->update($validated);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('contents', 'public');
                Image::create([
                    'content_id' => $content->id,
                    'path' => $path,
                    'alt_text' => $validated['title'],
                ]);
            }
        }

        return redirect()->route('admin.contents.index')
            ->with('success', 'Konten berhasil diperbarui!');
    }

    public function destroy(Content $content): RedirectResponse
    {
        // Hapus semua gambar terkait
        foreach ($content->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $content->delete();

        return redirect()->route('admin.contents.index')
            ->with('success', 'Konten berhasil dihapus!');
    }

    public function deleteImage(Image $image): RedirectResponse
    {
        $contentId = $image->content_id;
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}
