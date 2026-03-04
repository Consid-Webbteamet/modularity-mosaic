@php
    $card = $section['cards'][0] ?? null;
@endphp

@if (!empty($card))
    <section class="ls-mosiac__section ls-mosiac__section--full">
        @includeIf('partials.card-side-image', ['card' => $card])
    </section>
@endif
