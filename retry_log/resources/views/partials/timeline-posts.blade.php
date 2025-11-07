@foreach ($timeline as $post)
    <x-posts.post-card :post="$post" />
@endforeach