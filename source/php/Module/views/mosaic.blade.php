@if (!empty($sections))
    <div class="ls-mosiac">
        @foreach ($sections as $section)
            @if ($section['layout'] === 'full')
                @includeIf('layouts.full', ['section' => $section])
            @elseif ($section['layout'] === 'two_col_stacked')
                @includeIf('layouts.two-col-stacked', ['section' => $section])
            @elseif ($section['layout'] === 'two_col_image_top')
                @includeIf('layouts.two-col-image-top', ['section' => $section])
            @endif
        @endforeach
    </div>
@endif
