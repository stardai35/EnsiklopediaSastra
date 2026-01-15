<div class="card mb-4">
    <div class="card-header bg-ungu text-white fw-bold">
        Kategori
    </div>
    <ul class="list-group list-group-flush">
        @foreach(\App\Models\Category::all() as $cat)
        <li class="list-group-item">
            <a href="/kategori/{{ $cat->slug }}" class="text-decoration-none">
                {{ $cat->name }}
            </a>
        </li>
        @endforeach
    </ul>
</div>

<div class="card">
    <div class="card-header bg-ungu text-white fw-bold">
        Info
    </div>
    <div class="card-body small">
        Ensiklopedia Sastra Indonesia berbasis riset dan sumber terpercaya.
    </div>
</div>
