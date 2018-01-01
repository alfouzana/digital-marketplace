<article class="card mb-3">
    <img class="card-img-top"
         src="{{ asset($product->cover_path) }}"
         alt="Cover">

    <div class="card-body">
        <h3 class="card-title">
            <a href="{{ $product->url() }}">{{ $product->title }}</a>
        </h3>

        <a href="{{ $product->category->url() }}" class="card-link">
            <i class="far fa-folder"></i> {{ $product->category->name }}
        </a>

        <a href="#" class="card-link">
            <i class="far fa-user-circle"></i> {{ $product->vendor->name }}
        </a>
    </div>
</article>