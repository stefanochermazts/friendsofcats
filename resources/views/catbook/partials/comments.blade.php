{{-- Comments List --}}
@foreach($comments as $comment)
    @include('catbook.partials.comment', compact('comment'))
@endforeach
