@php
    $leftMain = $section['cards'][0] ?? null;
    $rightTop = $section['cards'][1] ?? null;
    $rightBottom = $section['cards'][2] ?? null;
@endphp

@if (!empty($leftMain) || !empty($rightTop) || !empty($rightBottom))
    <section class="ls-mosiac__section ls-mosiac__section--two-col-stacked">
        <div class="ls-mosiac__column ls-mosiac__column--left">
            @if (!empty($leftMain))
                @includeIf('partials.card-side-image', ['card' => $leftMain])
            @endif
        </div>
        <div class="ls-mosiac__column ls-mosiac__column--right">
            @if (!empty($rightTop))
                @includeIf('partials.card-side-image', ['card' => $rightTop])
            @endif
            @if (!empty($rightBottom))
                @includeIf('partials.card-side-image', ['card' => $rightBottom])
            @endif
        </div>
    </section>
@endif
