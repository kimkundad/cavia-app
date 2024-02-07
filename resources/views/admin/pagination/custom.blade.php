@if ($paginator->hasPages())
<nav>
    @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span><i class="icon-arrow-left"></i> Previous</span></li>
    @else
        <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a></li>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><span>{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active my-active"><span>{{ $page }}</span></li>
                @else
                    <li class="page-item"><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next <i class="icon-arrow-right"></i></a></li>
    @else
        <li class="page-item disabled"><span>Next <i class="icon-arrow-right"></i></span></li>
    @endif
</nav>
@endif 
