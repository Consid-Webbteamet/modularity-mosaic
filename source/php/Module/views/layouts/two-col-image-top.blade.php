@php
    $leftMain = $section['cards'][0] ?? null;
    $rightCard = $section['cards'][1] ?? null;
@endphp

@if (!empty($leftMain) || !empty($rightCard))
    <section class="ls-mosiac__section ls-mosiac__section--two-col-image-top">
        <div class="ls-mosiac__column ls-mosiac__column--left">
            @if (!empty($leftMain))
                @includeIf('partials.card-side-image', ['card' => $leftMain])
            @endif
        </div>
        <div class="ls-mosiac__column ls-mosiac__column--right">
            @if (!empty($rightCard))
                @includeIf('partials.card-image-top', ['card' => $rightCard])
            @endif
        </div>
    </section>
@endif
