@php
    $card = $card ?? [];
    $styleParts = [];
    $imagePosition = $card['imagePosition'] ?? 'right';

    if (!empty($card['backgroundVar']) && !empty($card['backgroundHex'])) {
        $styleParts[] = 'background-color: var(' . $card['backgroundVar'] . ', ' . $card['backgroundHex'] . ')';
    } elseif (!empty($card['backgroundVar'])) {
        $styleParts[] = 'background-color: var(' . $card['backgroundVar'] . ')';
    } elseif (!empty($card['backgroundHex'])) {
        $styleParts[] = 'background-color: ' . $card['backgroundHex'];
    }

    if (!empty($card['textColor'])) {
        $styleParts[] = 'color: ' . $card['textColor'];
    }

    $style = implode('; ', $styleParts);
    $hasImage = !empty($card['image']);
    $hasFallbackImage = !$hasImage && !empty($card['imageId']);
    $hasLink = !empty($card['link']['url']);
    $linkTarget = (string) ($card['link']['target'] ?? '');
    $linkRel = $linkTarget === '_blank' ? 'noopener noreferrer' : '';
@endphp

<article class="ls-mosiac__card ls-mosiac__card--side-image ls-mosiac__card--image-{{ esc_attr($imagePosition) }}" @if (!empty($style)) style="{{ esc_attr($style) }}" @endif>
    @if ($hasImage && $imagePosition === 'left')
        <div class="ls-mosiac__image-wrapper">
            @image([
                'src' => $card['image'],
                'cover' => true,
                'classList' => ['ls-mosiac__image'],
                'placeholderEnabled' => false,
            ])
            @endimage
        </div>
    @elseif ($hasFallbackImage && $imagePosition === 'left')
        <div class="ls-mosiac__image-wrapper">
            {!! wp_get_attachment_image((int) $card['imageId'], 'large', false, ['class' => 'ls-mosiac__image']) !!}
        </div>
    @endif

    <div class="ls-mosiac__content">
        @if (!empty($card['title']))
            <h2 class="ls-mosiac__title">{{ $card['title'] }}</h2>
        @endif

        @if (!empty($card['body']))
            <div class="ls-mosiac__body">{!! wp_kses_post(wpautop($card['body'])) !!}</div>
        @endif

        @if ($hasLink)
            <a class="ls-mosiac__link" href="{{ esc_url($card['link']['url']) }}" @if (!empty($linkTarget)) target="{{ esc_attr($linkTarget) }}" @endif @if (!empty($linkRel)) rel="{{ esc_attr($linkRel) }}" @endif>
                {{ !empty($card['link']['title']) ? $card['link']['title'] : __('Läs mer', 'modularity-mosaic') }}
            </a>
        @endif
    </div>

    @if ($hasImage && $imagePosition !== 'left')
        <div class="ls-mosiac__image-wrapper">
            @image([
                'src' => $card['image'],
                'cover' => true,
                'classList' => ['ls-mosiac__image'],
                'placeholderEnabled' => false,
            ])
            @endimage
        </div>
    @elseif ($hasFallbackImage && $imagePosition !== 'left')
        <div class="ls-mosiac__image-wrapper">
            {!! wp_get_attachment_image((int) $card['imageId'], 'large', false, ['class' => 'ls-mosiac__image']) !!}
        </div>
    @endif
</article>
