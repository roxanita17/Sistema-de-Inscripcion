<aside class="control-sidebar control-sidebar-{{ config('adminlte.right_sidebar_theme') }}">
    @php($links = config('adminlte.right_sidebar_links', []))
    @if(!empty($links))
        <div class="p-3">
            <ul class="list-unstyled mb-0">
                @foreach($links as $link)
                    <li class="mb-2">
                        <a href="{{ $link['url'] ?? '#' }}" class="text-white" @if(!empty($link['target'])) target="{{ $link['target'] }}" @endif>
                            @if(!empty($link['icon']))
                                <i class="{{ $link['icon'] }} mr-2"></i>
                            @endif
                            {{ $link['text'] ?? '' }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('right_sidebar')
</aside>
