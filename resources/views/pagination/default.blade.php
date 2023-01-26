


                                    <div class="ps-pagination">
                                        <ul class="pagination">
                                            <li><a href="{{ $paginator->url(1) }}">First Page<i class="icon-chevron-left"></i></a></li>
                                            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                                            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $paginator->url($i) }}" >{{ $i }}</a></li>
                                            @endfor
                                            
                                            <li><a href="{{ $paginator->url($paginator->currentPage()+1) }}">Next Page <i class="icon-chevron-right"></i></a></li>
                                        </ul>
                                    </div>
