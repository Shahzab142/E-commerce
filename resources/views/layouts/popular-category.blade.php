<section class="py-5 popular-categories-section">
    <div class="container position-relative">

        {{-- =========================
             SECTION HEADER
        ========================== --}}
        <div class="category-header d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">

            <div>
                <span class="section-eyebrow">
                    <span class="eyebrow-icon">✦</span>
                    Collections
                </span>

                <h2 class="section-title mb-1">
                    Top Categories
                </h2>

                <p class="section-subtitle mb-0">
                    Find exactly what you need from our extensive product collections
                </p>
            </div>

            <a href="{{ route('shop') }}" class="btn-view-all">
                <span>View All</span>
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>


        {{-- =========================
             CATEGORIES
        ========================== --}}
        @if ($categories->isNotEmpty())

            <div class="category-marquee-wrapper">

                {{-- Left fade --}}
                <div class="marquee-fade marquee-fade-left"></div>

                {{-- Carousel --}}
                <div class="marquee-viewport" id="marqueeViewport">

                    <div class="marquee-track" id="marqueeTrack">

                        {{-- First group --}}
                        <div class="marquee-group">

                            @foreach ($categories as $category)

                                @php
                                    $img = $category->image_url;

                                    $shortDesc = $category->short_description
                                        ?? \Illuminate\Support\Str::limit(
                                            strip_tags($category->description ?? ''),
                                            55
                                        );

                                    $hasImage = !empty($img)
                                        && $img !== asset('assets/img/placeholder-category.svg');
                                @endphp

                                <a
                                    href="{{ url('category/' . $category->slug) }}"
                                    class="category-card"
                                >

                                    {{-- Category Image --}}
                                    <div class="category-ring">

                                        <div class="category-thumb">

                                            @if ($hasImage)

                                                <img
                                                    src="{{ $img }}"
                                                    alt="{{ $category->name }}"
                                                    loading="lazy"
                                                >

                                            @else

                                                <div class="category-placeholder">
                                                    <i class="bi bi-tag-fill"></i>
                                                </div>

                                            @endif

                                        </div>

                                        {{-- Floating arrow --}}
                                        <span class="category-arrow">
                                            <i class="bi bi-arrow-up-right"></i>
                                        </span>

                                    </div>


                                    {{-- Category name --}}
                                    <h6 class="category-name">
                                        {{ \Illuminate\Support\Str::limit($category->name, 18) }}
                                    </h6>


                                    {{-- Category description --}}
                                    @if ($shortDesc)

                                        <p class="category-desc">
                                            {{ $shortDesc }}
                                        </p>

                                    @endif

                                </a>

                            @endforeach

                        </div>


                        {{-- Second group is created by JavaScript --}}
                    </div>

                </div>

                {{-- Right fade --}}
                <div class="marquee-fade marquee-fade-right"></div>

            </div>

        @else

            {{-- Empty State --}}
            <div class="category-empty-state">

                <div class="empty-icon">
                    <i class="bi bi-grid-3x3-gap"></i>
                </div>

                <h5>No Categories Available</h5>

                <p>
                    Product categories will appear here once they are available.
                </p>

            </div>

        @endif

    </div>
</section>


{{-- =========================================================
     STYLES
========================================================= --}}
@push('styles')
<style>

    /* =========================================================
       SECTION
    ========================================================= */

    .popular-categories-section {
        position: relative;
        overflow: hidden;

        background:
            radial-gradient(
                circle at 8% 20%,
                rgba(109, 40, 217, 0.08),
                transparent 30%
            ),
            radial-gradient(
                circle at 92% 80%,
                rgba(219, 39, 119, 0.07),
                transparent 28%
            ),
            linear-gradient(
                180deg,
                #fafbff 0%,
                #f1f3f9 100%
            );
    }


    /* Decorative glow */

    .popular-categories-section::before {
        content: "";
        position: absolute;

        width: 280px;
        height: 280px;

        top: -160px;
        left: -100px;

        border-radius: 50%;

        background: rgba(109, 40, 217, 0.10);

        filter: blur(80px);

        pointer-events: none;
    }

    .popular-categories-section::after {
        content: "";
        position: absolute;

        width: 260px;
        height: 260px;

        bottom: -150px;
        right: -90px;

        border-radius: 50%;

        background: rgba(219, 39, 119, 0.08);

        filter: blur(80px);

        pointer-events: none;
    }

    .popular-categories-section .container {
        position: relative;
        z-index: 2;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .category-header {
        position: relative;
    }

    .section-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        margin-bottom: 9px;

        padding: 6px 12px;

        border-radius: 999px;

        background: rgba(109, 40, 217, 0.08);

        color: #6d28d9;

        font-size: 0.70rem;
        font-weight: 800;

        letter-spacing: 0.10em;
        text-transform: uppercase;
    }

    .eyebrow-icon {
        font-size: 0.85rem;
    }

    .section-title {
        color: #111827;

        font-size: clamp(
            1.55rem,
            2.5vw,
            2rem
        );

        font-weight: 800;

        letter-spacing: -0.035em;

        line-height: 1.15;
    }

    .section-subtitle {
        color: #7b8494;

        font-size: 0.9rem;
    }


    /* =========================================================
       VIEW ALL BUTTON
    ========================================================= */

    .btn-view-all {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        padding: 9px 17px;

        border-radius: 999px;

        background: rgba(255, 255, 255, 0.9);

        border: 1px solid #e2e5ed;

        color: #6d28d9;

        font-size: 0.84rem;
        font-weight: 700;

        text-decoration: none;

        box-shadow:
            0 4px 12px rgba(17, 24, 39, 0.05);

        transition:
            color 0.3s ease,
            background 0.3s ease,
            border-color 0.3s ease,
            transform 0.3s ease,
            box-shadow 0.3s ease;
    }

    .btn-view-all i {
        transition: transform 0.3s ease;
    }

    .btn-view-all:hover {
        color: #fff;

        background:
            linear-gradient(
                135deg,
                #6d28d9,
                #db2777
            );

        border-color: transparent;

        transform: translateY(-2px);

        box-shadow:
            0 12px 25px rgba(109, 40, 217, 0.25);
    }

    .btn-view-all:hover i {
        transform: translateX(4px);
    }


    /* =========================================================
       MARQUEE
    ========================================================= */

    .category-marquee-wrapper {
        position: relative;
        width: 100%;
    }

    .marquee-viewport {
        width: 100%;
        overflow: hidden;

        padding: 14px 2px 24px;
    }

    .marquee-track {
        display: flex;

        width: max-content;

        will-change: transform;
    }

    .marquee-group {
        display: flex;
        align-items: flex-start;

        gap: 1.75rem;

        padding-right: 1.75rem;

        flex-shrink: 0;
    }


    /* Animation */

    .marquee-track.is-animating {
        animation:
            category-marquee
            var(--marquee-duration, 35s)
            linear
            infinite;
    }

    .category-marquee-wrapper:hover
    .marquee-track.is-animating {
        animation-play-state: paused;
    }

    @keyframes category-marquee {

        from {
            transform: translate3d(0, 0, 0);
        }

        to {
            transform: translate3d(
                var(--marquee-distance),
                0,
                0
            );
        }

    }


    /* =========================================================
       FADE EDGES
    ========================================================= */

    .marquee-fade {
        position: absolute;

        top: 0;
        bottom: 0;

        width: 90px;

        z-index: 5;

        pointer-events: none;
    }

    .marquee-fade-left {
        left: 0;

        background:
            linear-gradient(
                to right,
                #fafbff,
                rgba(250, 251, 255, 0)
            );
    }

    .marquee-fade-right {
        right: 0;

        background:
            linear-gradient(
                to left,
                #f1f3f9,
                rgba(241, 243, 249, 0)
            );
    }


    /* =========================================================
       CATEGORY CARD
       (Enlarged circle + card)
    ========================================================= */

    .category-card {
        position: relative;

        width: 172px;

        flex: 0 0 172px;

        display: block;

        text-align: center;

        text-decoration: none;

        padding: 6px 4px 10px;

        border-radius: 20px;

        transition:
            transform 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-4px);
    }

    .category-card:focus-visible {
        outline: 2px solid #6d28d9;
        outline-offset: 5px;
    }


    /* =========================================================
       IMAGE RING  (bigger)
    ========================================================= */

    .category-ring {
        position: relative;

        width: 146px;
        height: 146px;

        margin: 0 auto 14px;

        padding: 5px;

        border-radius: 50%;

        background:
            linear-gradient(
                135deg,
                #e4e7f0,
                #f2eaff
            );

        box-shadow:
            0 8px 22px rgba(17, 24, 39, 0.10);

        transition:
            background 0.35s ease,
            transform 0.35s cubic-bezier(
                .22,
                1,
                .36,
                1
            ),
            box-shadow 0.35s ease;
    }

    .category-card:hover .category-ring {
        background:
            linear-gradient(
                135deg,
                #6d28d9,
                #db2777
            );

        transform:
            translateY(-8px)
            scale(1.05);

        box-shadow:
            0 22px 40px rgba(
                109,
                40,
                217,
                0.28
            );
    }


    /* =========================================================
       IMAGE
    ========================================================= */

    .category-thumb {
        width: 100%;
        height: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;

        border-radius: 50%;

        background: #ffffff;
    }

    .category-thumb img {
        width: 100%;
        height: 100%;

        object-fit: cover;

        transition:
            transform 0.5s
            cubic-bezier(
                .22,
                1,
                .36,
                1
            );
    }

    .category-card:hover
    .category-thumb img {
        transform: scale(1.12);
    }


    /* =========================================================
       PLACEHOLDER
    ========================================================= */

    .category-placeholder {
        width: 100%;
        height: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #a0a7b4;

        font-size: 2.6rem;

        background:
            radial-gradient(
                circle at center,
                #ffffff,
                #f0f2f6
            );
    }


    /* =========================================================
       FLOATING ARROW
    ========================================================= */

    .category-arrow {
        position: absolute;

        right: 4px;
        top: 6px;

        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        color: #ffffff;

        background:
            linear-gradient(
                135deg,
                #6d28d9,
                #db2777
            );

        font-size: 0.85rem;

        opacity: 0;

        transform:
            translateY(-6px)
            scale(0.75);

        box-shadow:
            0 8px 18px
            rgba(109, 40, 217, 0.28);

        transition:
            opacity 0.25s ease,
            transform 0.25s ease;
    }

    .category-card:hover .category-arrow {
        opacity: 1;

        transform:
            translateY(0)
            scale(1);
    }


    /* =========================================================
       NAME
    ========================================================= */

    .category-name {
        margin: 0 0 4px;

        color: #202633;

        font-size: 0.94rem;
        font-weight: 750;

        line-height: 1.3;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;

        transition:
            color 0.25s ease;
    }

    .category-card:hover .category-name {
        color: #6d28d9;
    }


    /* =========================================================
       DESCRIPTION
    ========================================================= */

    .category-desc {
        margin: 0;

        color: #8b93a4;

        font-size: 0.73rem;

        line-height: 1.4;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .category-empty-state {
        padding: 55px 20px;

        text-align: center;

        background: rgba(255,255,255,0.75);

        border:
            1px dashed
            #dce1eb;

        border-radius: 20px;
    }

    .empty-icon {
        width: 58px;
        height: 58px;

        margin: 0 auto 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #f0f1f5;

        color: #8b93a4;

        font-size: 1.4rem;
    }

    .category-empty-state h5 {
        color: #343a40;

        font-weight: 750;
    }

    .category-empty-state p {
        margin: 0;

        color: #8b93a4;

        font-size: 0.88rem;
    }


    /* =========================================================
       TABLET
    ========================================================= */

    @media (max-width: 767.98px) {

        .popular-categories-section {
            padding-top: 42px !important;
            padding-bottom: 42px !important;
        }

        .category-header {
            align-items: flex-start !important;
        }

        .section-title {
            font-size: 1.65rem;
        }

        .section-subtitle {
            font-size: 0.82rem;
        }

        .marquee-group {
            gap: 1.25rem;
            padding-right: 1.25rem;
        }

        .category-card {
            width: 148px;
            flex-basis: 148px;
        }

        .category-ring {
            width: 124px;
            height: 124px;
        }

        .category-name {
            font-size: 0.86rem;
        }

        .category-desc {
            font-size: 0.68rem;
        }

        .category-arrow {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
        }

        .marquee-fade {
            width: 50px;
        }

    }


    /* =========================================================
       SMALL MOBILE
    ========================================================= */

    @media (max-width: 480px) {

        .section-eyebrow {
            font-size: 0.63rem;
            padding: 5px 10px;
        }

        .section-title {
            font-size: 1.45rem;
        }

        .section-subtitle {
            font-size: 0.78rem;
        }

        .btn-view-all {
            padding: 7px 13px;
            font-size: 0.76rem;
        }

        .category-card {
            width: 130px;
            flex-basis: 130px;
        }

        .category-ring {
            width: 108px;
            height: 108px;
        }

        .category-name {
            font-size: 0.80rem;
        }

        .category-desc {
            font-size: 0.63rem;
        }

        .marquee-group {
            gap: 0.95rem;
            padding-right: 0.95rem;
        }

    }


    /* =========================================================
       REDUCED MOTION
    ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .marquee-track.is-animating {
            animation: none !important;
        }

        .category-card,
        .category-ring,
        .category-thumb img,
        .category-arrow,
        .btn-view-all,
        .btn-view-all i {
            transition: none !important;
        }

    }

</style>
@endpush


{{-- =========================================================
     JAVASCRIPT  (Seamless Marquee)
========================================================= --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const viewport = document.getElementById('marqueeViewport');
    const track    = document.getElementById('marqueeTrack');

    if (!viewport || !track) return;

    const originalGroup = track.querySelector('.marquee-group');
    if (!originalGroup) return;

    /* Prevent duplicate initialization */
    if (track.dataset.initialized === 'true') return;
    track.dataset.initialized = 'true';

    /*
     * Clone the group twice so we always have
     * enough content to fill wide screens.
     */
    const cloneA = originalGroup.cloneNode(true);
    cloneA.setAttribute('aria-hidden', 'true');

    const cloneB = originalGroup.cloneNode(true);
    cloneB.setAttribute('aria-hidden', 'true');

    track.appendChild(cloneA);
    track.appendChild(cloneB);


    function initializeMarquee() {

        const groupWidth    = originalGroup.getBoundingClientRect().width;
        const viewportWidth = viewport.getBoundingClientRect().width;

        /* Not enough content to scroll → center it */
        if (groupWidth <= viewportWidth) {
            track.classList.remove('is-animating');
            track.style.removeProperty('--marquee-distance');
            track.style.removeProperty('--marquee-duration');
            track.style.justifyContent = 'center';
            return;
        }

        track.style.justifyContent = '';

        /* Move exactly one group width for a seamless loop */
        track.style.setProperty(
            '--marquee-distance',
            `-${groupWidth}px`
        );

        /* ~55px per second, minimum 22s for a calm pace */
        const duration = Math.max(groupWidth / 55, 22);

        track.style.setProperty(
            '--marquee-duration',
            `${duration}s`
        );

        track.classList.add('is-animating');
    }


    /* Wait for images so width calculation is accurate */
    const images = track.querySelectorAll('img');
    let loadedImages = 0;

    function tryInit() {
        loadedImages++;
        if (loadedImages >= images.length) {
            initializeMarquee();
        }
    }

    if (images.length === 0) {
        initializeMarquee();
    } else {
        images.forEach(function (img) {
            if (img.complete) {
                tryInit();
            } else {
                img.addEventListener('load',  tryInit, { once: true });
                img.addEventListener('error', tryInit, { once: true });
            }
        });
    }


    /* Recalculate on resize */
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initializeMarquee, 200);
    });

});
</script>
@endpush