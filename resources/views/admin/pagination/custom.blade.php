@if ($paginator->hasPages())
<nav>
    <ul class="pagination flex-wrap">
    @if ($paginator->onFirstPage())
        <li class="page-item disabled"><a class="page-link"><i class="icon-arrow-left"></i> Previous</a></li>
    @else
        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a></li>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><a class="page-link">{{ $element }}</a></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active my-active"><a class="page-link">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <i class="icon-arrow-right"></i></a></li>
    @else
        <li class="page-item disabled"><a class="page-link">Next <i class="icon-arrow-right"></i></a></li>
    @endif
</ul>
</nav>
@endif 


{{-- <a class="page-link">
<nav>
    <ul class="pagination flex-wrap">
      <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}"><i class="icon-arrow-left"></i></a></li>
      @for ($i = 1; $i <= $paginator->lastPage(); $i++)
      <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
      @endfor
      <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}"><i class="icon-arrow-right"></i></a></li>
    </ul>
  </nav> --}}