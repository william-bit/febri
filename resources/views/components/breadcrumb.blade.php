<div class="mb-3 tracking-wide text-blue-900">
    @foreach ($breadcrumb as $name => $link)
        <a href="{{ $link }}" class="hover:text-blue-500 hover:underline">{{ $name }}</a> <span> > </span>
    @endforeach
    <span>{{ $title }}</span>
</div>
