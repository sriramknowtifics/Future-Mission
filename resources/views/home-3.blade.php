@extends('layouts.theme')

@section('title', config('app.name', 'Shop') . ' - Home')
@section('body_class', 'shop-main-h')

@section('content')
<style>
.container-zoom {
    transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.container-zoom:hover {
    transform: scale(1.05) translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

</style>
<div class="rts-banner-area rts-section-gap pt_sm--20">
        <div class="container">
            <div class="row g-5 g-sm-4">
                <div class="col-lg-9">
                    <div class="rts-banner-area-one mb--30">
            <!-- <div class="container">
                <div class="row">
                    <div class="col-lg-12"> -->
                        <!-- note: If you need this only one banner put this above out of container  -->
                        <div class="category-area-main-wrapper-one">
                            <div class="swiper mySwiper-category-1 swiper-data" data-swiper='{
                                "spaceBetween":1,
                                "slidesPerView":1,
                                "loop": true,
                                "speed": 1000,
                                "autoplay":{
                                    "delay":"2000"
                                },
                                "navigation":{
                                    "nextEl":".swiper-button-next",
                                    "prevEl":".swiper-button-prev"
                                },
                                "breakpoints":{
                                "0":{
                                    "slidesPerView":1,
                                    "spaceBetween": 0},
                                "320":{
                                    "slidesPerView":1,
                                    "spaceBetween":0},
                                "480":{
                                    "slidesPerView":1,
                                    "spaceBetween":0},
                                "640":{
                                    "slidesPerView":1,
                                    "spaceBetween":0},
                                "840":{
                                    "slidesPerView":1,
                                    "spaceBetween":0},
                                "1140":{
                                    "slidesPerView":1,
                                    "spaceBetween":0}
                                }
                                }'>
                                <div class="swiper-wrapper">
                                    <!-- single swiper start -->
                                    @if ($banners && $banners->count())
                                    @foreach ($banners->where('place', 1) as $banner)
                                        @php
                                            $imageUrl = asset('storage/' . $banner->desktop_image);
                                        @endphp

                                        <div class="swiper-slide">
                                            <div class="banner-one banner-left-five-area-start ptb--120"
                                                data-desktop="{{ asset('storage/' . $banner->desktop_image) }}"
                                                data-mobile="{{ asset('storage/' . $banner->mobile_image) }}">

                                                <div class="banner-one-inner-content">
                                                    <span class="pre"></span>
                                                    <h1 class="title"></h1>

                                                    <a href="{{ $banner->link }}" class="rts-btn btn-primary radious-sm with-icon">
                                                        <div class="btn-text">Shop Now</div>
                                                        <div class="arrow-icon"><i class="fa-light fa-arrow-right"></i></div>
                                                        <div class="arrow-icon"><i class="fa-light fa-arrow-right"></i></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @else
                                    <!-- single swiper start -->
                                    <!-- single swiper start -->
                                    <div class="swiper-slide">
                                        <div class="banner-bg-image bg_image bg_one-banner two  ptb--120 ptb_md--80 ptb_sm--60">
                                            <div class="banner-one-inner-content">
                                                <span class="pre">Get up to 30% off on your first $150 purchase</span>
                                                <h1 class="title">
                                                    Do not miss our amazing <br>
                                                    grocery deals
                                                </h1>
                                                <a href="shop-grid-sidebar.html" class="rts-btn btn-primary radious-sm with-icon">
                                                    <div class="btn-text">
                                                        Shop Now
                                                    </div>
                                                    <div class="arrow-icon">
                                                        <i class="fa-light fa-arrow-right"></i>
                                                    </div>
                                                    <div class="arrow-icon">
                                                        <i class="fa-light fa-arrow-right"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- single swiper start -->
                                </div>

                                <button class="swiper-button-next"><i class="fa-regular fa-arrow-right"></i></button>
                                <button class="swiper-button-prev"><i class="fa-regular fa-arrow-left"></i></button>
                            </div>
                        </div>
                    <!-- </div>
                </div>
            </div> -->
        </div>
                </div>

                <div class="col-lg-3">
                    @php
                        $place2 = $banners->where('place', 2)->first();
                    @endphp

                    @if($place2)
                    <div class="banner-five-right-content bg_image"
                        style="background-image:url('{{ asset('storage/' . $place2->desktop_image) }}')">

                        <div class="content-area">
                            <a href="{{ $place2->link }}" class="rts-btn btn-primary">{{ $place2->subtitle }}</a>

                            <h3 class="title"></h3>

                            <a href="{{ $place2->link }}" class="shop-now-goshop-btn">
                                <span class="text">Shop Now</span>
                                <div class="plus-icon"><i class="fa-sharp fa-regular fa-plus"></i></div>
                                <div class="plus-icon"><i class="fa-sharp fa-regular fa-plus"></i></div>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="rts-feature-large-product-area rts-section-gapBottom ">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-6">
                    @php
                        $place3 = $banners->where('place', 3)->first();
                    @endphp

                    @if($place3)
                    <div class="feature-product-area-large-2 bg_image container-zoom"
                        style="background-image:url('{{ asset('storage/' . $place3->desktop_image) }}')">

                        <div class="inner-feature-product-content">

                            <a href="{{ $place3->link }}" class="rts-btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                    @endif

                </div>

                <div class="col-lg-6">
                    @php
                        $place4 = $banners->where('place', 4)->first();
                    @endphp

                    @if($place4)
                    <div class="feature-product-area-large-2 bg_image container-zoom"
                        style="background-image:url('{{ asset('storage/' . $place4->desktop_image) }}')">

                        <div class="inner-feature-product-content">



                            <a href="{{ $place4->link }}" class="rts-btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="rts-shorts-service-area rts-section-gap bg_heading">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <!-- single service area start -->
                    <div class="single-short-service-area-start">
                        <div class="icon-area">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40" cy="40" r="40" fill="white"/>
                                <path d="M55.7029 25.2971C51.642 21.2363 46.2429 19 40.5 19C34.7571 19 29.358 21.2363 25.2971 25.2971C21.2364 29.358 19 34.7571 19 40.5C19 46.2429 21.2364 51.642 25.2971 55.7029C29.358 59.7637 34.7571 62 40.5 62C46.2429 62 51.642 59.7637 55.7029 55.7029C59.7636 51.642 62 46.2429 62 40.5C62 34.7571 59.7636 29.358 55.7029 25.2971ZM40.5 59.4805C30.0341 59.4805 21.5195 50.9659 21.5195 40.5C21.5195 30.0341 30.0341 21.5195 40.5 21.5195C50.9659 21.5195 59.4805 30.0341 59.4805 40.5C59.4805 50.9659 50.9659 59.4805 40.5 59.4805Z" fill="#629D23"/>
                                <path d="M41.8494 39.2402H39.1506C37.6131 39.2402 36.3623 37.9895 36.3623 36.452C36.3623 34.9145 37.6132 33.6638 39.1506 33.6638H44.548C45.2438 33.6638 45.8078 33.0997 45.8078 32.404C45.8078 31.7083 45.2438 31.1442 44.548 31.1442H41.7598V28.3559C41.7598 27.6602 41.1957 27.0962 40.5 27.0962C39.8043 27.0962 39.2402 27.6602 39.2402 28.3559V31.1442H39.1507C36.2239 31.1442 33.8429 33.5253 33.8429 36.452C33.8429 39.3787 36.224 41.7598 39.1507 41.7598H41.8495C43.3869 41.7598 44.6377 43.0106 44.6377 44.548C44.6377 46.0855 43.3869 47.3363 41.8495 47.3363H36.452C35.7563 47.3363 35.1923 47.9004 35.1923 48.5961C35.1923 49.2918 35.7563 49.8559 36.452 49.8559H39.2402V52.6442C39.2402 53.34 39.8043 53.904 40.5 53.904C41.1957 53.904 41.7598 53.34 41.7598 52.6442V49.8559H41.8494C44.7761 49.8559 47.1571 47.4747 47.1571 44.548C47.1571 41.6214 44.7761 39.2402 41.8494 39.2402Z" fill="#629D23"/>
                                </svg>
                                
                        </div>
                        <div class="information">
                            <h4 class="title">Best Prices & Offers</h4>
                            <p class="disc">
                                We prepared special discounts you on grocery products.
                            </p>
                        </div>
                    </div>
                    <!-- single service area end -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <!-- single service area start -->
                    <div class="single-short-service-area-start">
                        <div class="icon-area">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40" cy="40" r="40" fill="white"/>
                                <path d="M55.5564 24.4436C51.4012 20.2884 45.8763 18 40 18C34.1237 18 28.5988 20.2884 24.4436 24.4436C20.2884 28.5988 18 34.1237 18 40C18 45.8763 20.2884 51.4012 24.4436 55.5564C28.5988 59.7116 34.1237 62 40 62C45.8763 62 51.4012 59.7116 55.5564 55.5564C59.7116 51.4012 62 45.8763 62 40C62 34.1237 59.7116 28.5988 55.5564 24.4436ZM40 59.4219C29.2907 59.4219 20.5781 50.7093 20.5781 40C20.5781 29.2907 29.2907 20.5781 40 20.5781C50.7093 20.5781 59.4219 29.2907 59.4219 40C59.4219 50.7093 50.7093 59.4219 40 59.4219Z" fill="#629D23"/>
                                <path d="M42.4009 34.7622H35.0294L36.295 33.4966C36.7982 32.9934 36.7982 32.177 36.295 31.6738C35.7914 31.1703 34.9753 31.1703 34.4718 31.6738L31.0058 35.1398C30.5022 35.6434 30.5022 36.4594 31.0058 36.9626L34.4718 40.429C34.7236 40.6808 35.0536 40.8067 35.3832 40.8067C35.7132 40.8067 36.0432 40.6808 36.295 40.429C36.7982 39.9255 36.7982 39.1094 36.295 38.6059L35.0291 37.3403H42.4009C44.8229 37.3403 46.7934 39.3108 46.7934 41.7328C46.7934 44.1549 44.8229 46.1254 42.4009 46.1254H37.8925C37.1805 46.1254 36.6035 46.7028 36.6035 47.4145C36.6035 48.1265 37.1805 48.7035 37.8925 48.7035H42.4009C46.2446 48.7035 49.3716 45.5765 49.3716 41.7328C49.3716 37.8892 46.2446 34.7622 42.4009 34.7622Z" fill="#629D23"/>
                                </svg>
                                
                        </div>
                        <div class="information">
                            <h4 class="title">100% Return Policy</h4>
                            <p class="disc">
                                We prepared special discounts you on grocery products.
                            </p>
                        </div>
                    </div>
                    <!-- single service area end -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <!-- single service area start -->
                    <div class="single-short-service-area-start">
                        <div class="icon-area">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40" cy="40" r="40" fill="white"/>
                                <path d="M26.2667 26.2667C29.935 22.5983 34.8122 20.5781 40 20.5781C43.9672 20.5781 47.8028 21.7849 51.0284 24.0128L48.5382 24.2682L48.8013 26.8328L55.5044 26.1453L54.8169 19.4422L52.2522 19.7053L52.4751 21.8787C48.8247 19.3627 44.4866 18 40 18C34.1236 18 28.5989 20.2884 24.4437 24.4437C20.2884 28.5989 18 34.1236 18 40C18 44.3993 19.2946 48.6457 21.7437 52.28L23.8816 50.8393C23.852 50.7952 23.8232 50.7508 23.7939 50.7065C21.69 47.5289 20.5781 43.8307 20.5781 40C20.5781 34.8123 22.5983 29.935 26.2667 26.2667Z" fill="#629D23"/>
                                <path d="M58.2564 27.72L56.1184 29.1607C56.148 29.2047 56.1768 29.2493 56.2061 29.2935C58.3099 32.4711 59.4219 36.1693 59.4219 40C59.4219 45.1878 57.4017 50.065 53.7333 53.7333C50.0651 57.4017 45.1879 59.4219 40 59.4219C36.0328 59.4219 32.1972 58.2151 28.9716 55.9872L31.4618 55.7318L31.1987 53.1672L24.4956 53.8547L25.1831 60.5578L27.7478 60.2947L27.5249 58.1213C31.1754 60.6373 35.5135 62 40 62C45.8764 62 51.4011 59.7116 55.5564 55.5563C59.7117 51.4011 62 45.8764 62 40C62 35.6007 60.7055 31.3543 58.2564 27.72Z" fill="#629D23"/>
                                <path d="M28.7407 42.7057L30.4096 41.1632C31.6739 40 31.9142 39.2161 31.9142 38.3564C31.9142 36.7127 30.5108 35.6633 28.4753 35.6633C26.7305 35.6633 25.4788 36.3966 24.8087 37.5093L26.6673 38.546C27.0213 37.9771 27.6029 37.6863 28.2477 37.6863C29.0063 37.6863 29.3856 38.0276 29.3856 38.5966C29.3856 38.9633 29.2845 39.3679 28.5764 40.0254L25.2639 43.123V44.6907H32.1544V42.7057L28.7407 42.7057Z" fill="#629D23"/>
                                <path d="M40.1076 42.9965H41.4224V41.0115H40.1076V39.507H37.7433V41.0115H35.948L39.5512 35.8404H36.9594L32.9894 41.3655V42.9965H37.6674V44.6906H40.1076V42.9965Z" fill="#629D23"/>
                                <path d="M43.6986 45.955L47.8708 34.045H45.7341L41.5618 45.955H43.6986Z" fill="#629D23"/>
                                <path d="M49.995 39.1908V37.8254H52.3213L49.3375 44.6906H52.0685L55.1913 37.4081V35.8404H47.8582V39.1908H49.995Z" fill="#629D23"/>
                                </svg>
                                
                        </div>
                        <div class="information">
                            <h4 class="title">Support 24/7</h4>
                            <p class="disc">
                                We prepared special discounts you on grocery products.
                            </p>
                        </div>
                    </div>
                    <!-- single service area end -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <!-- single service area start -->
                    <div class="single-short-service-area-start">
                        <div class="icon-area">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40" cy="40" r="40" fill="white"/>
                                <path d="M57.0347 37.5029C54.0518 29.3353 48.6248 23.7668 48.3952 23.5339L46.2276 21.3333V29.6016C46.2276 30.3124 45.658 30.8906 44.9578 30.8906C44.2577 30.8906 43.688 30.3124 43.688 29.6016C43.688 23.2045 38.5614 18 32.26 18H30.9902V19.2891C30.9902 25.3093 27.0988 29.646 24.1414 35.2212C21.1581 40.8449 21.3008 47.7349 24.5138 53.2021C27.7234 58.6637 33.5291 62 39.7786 62H40.3686C46.1822 62 51.6369 59.1045 54.9597 54.2545C58.2819 49.4054 59.056 43.0371 57.0347 37.5029ZM52.8748 52.7824C50.0265 56.9398 45.3513 59.4219 40.3686 59.4219H39.7786C34.4416 59.4219 29.4281 56.5325 26.6947 51.8813C23.9369 47.1886 23.8153 41.2733 26.3773 36.4436C29.1752 31.1691 32.9752 26.8193 33.4744 20.662C37.803 21.265 41.1483 25.0441 41.1483 29.6015C41.1483 31.7338 42.8572 33.4687 44.9577 33.4687C47.0581 33.4687 48.767 31.7338 48.767 29.6015V27.9161C50.54 30.2131 53.0138 33.9094 54.6534 38.399C56.3856 43.1416 55.704 48.653 52.8748 52.7824Z" fill="#629D23"/>
                                <path d="M38.6089 40C38.6089 37.8676 36.9 36.1328 34.7996 36.1328C32.6991 36.1328 30.9902 37.8676 30.9902 40C30.9902 42.1324 32.6991 43.8672 34.7996 43.8672C36.9 43.8672 38.6089 42.1324 38.6089 40ZM33.5298 40C33.5298 39.2892 34.0994 38.7109 34.7996 38.7109C35.4997 38.7109 36.0693 39.2892 36.0693 40C36.0693 40.7108 35.4997 41.2891 34.7996 41.2891C34.0994 41.2891 33.5298 40.7108 33.5298 40Z" fill="#629D23"/>
                                <path d="M44.9578 46.4453C42.8573 46.4453 41.1485 48.1801 41.1485 50.3125C41.1485 52.4449 42.8573 54.1797 44.9578 54.1797C47.0583 54.1797 48.7672 52.4449 48.7672 50.3125C48.7672 48.1801 47.0583 46.4453 44.9578 46.4453ZM44.9578 51.6016C44.2577 51.6016 43.688 51.0233 43.688 50.3125C43.688 49.6017 44.2577 49.0234 44.9578 49.0234C45.658 49.0234 46.2276 49.6017 46.2276 50.3125C46.2276 51.0233 45.658 51.6016 44.9578 51.6016Z" fill="#629D23"/>
                                <path d="M32.5466 52.0632L45.2407 36.599L47.1911 38.249L34.4969 53.7132L32.5466 52.0632Z" fill="#629D23"/>
                            </svg>                                
                        </div>
                        <div class="information">
                            <h4 class="title">Great Offer Daily Deal</h4>
                            <p class="disc">
                                We prepared special discounts you on grocery products.
                            </p>
                        </div>
                    </div>
                    <!-- single service area end -->
                </div>
            </div>
        </div>
    </div>

    <section class="home-categories rts-section-gap">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="cover-card-main-over">
            <div class="row">
              <div class="col-lg-12">
                <div class="title-area-between">
                  <h2 class="title-left mb--0">
                    Featured Categories
                  </h2>
                  <div class="next-prev-swiper-wrapper">
                        <div class="swiper-button-prev cat-prev"><i class="fa-regular fa-chevron-left"></i></div>
                        <div class="swiper-button-next cat-next"><i class="fa-regular fa-chevron-right"></i></div>
                    </div>

                </div>
              </div>
            </div>

            {{-- CATEGORY SLIDER --}}
            <!-- rts category area satart -->
            <div class="rts-caregory-area-one">
              <div class="row">
                <div class="col-lg-12">
                  <div class="category-area-main-wrapper-one">
                    <div class="swiper mySwiper-category-1 swiper-data"
                      data-swiper='{
                        "spaceBetween":15,
                        "slidesPerView":8,
                        "loop": true,
                        "speed": 1000,
                        "navigation":{
                         "nextEl":".cat-next",
                          "prevEl":".cat-prev"
                        },
                        "breakpoints":{
                          "0":{
                            "slidesPerView":1,
                            "spaceBetween":15
                          },
                          "340":{
                            "slidesPerView":2,
                            "spaceBetween":15
                          },
                          "480":{
                            "slidesPerView":3,
                            "spaceBetween":15
                          },
                          "640":{
                            "slidesPerView":4,
                            "spaceBetween":15
                          },
                          "840":{
                            "slidesPerView":4,
                            "spaceBetween":15
                          },
                          "1140":{
                            "slidesPerView":6,
                            "spaceBetween":15
                          },
                          "1740":{
                            "slidesPerView":8,
                            "spaceBetween":15
                          }
                        }
                      }'>
                      <div class="swiper-wrapper">

                        {{-- Dynamic category slides --}}
                        @if ($categories && $categories->count())
                          @foreach ($categories as $category)
                            <div class="swiper-slide">
                              <div class="single-category-one height-180">
                                <a href="{{ route('shop.index', ['category' => $category->id]) }}">
                                  @if ($category->icon)
                                    {{-- Icon uploaded from admin (PNG / SVG) --}}
                                    <img
                                      src="{{ asset('storage/' . $category->icon) }}"
                                      alt="{{ $category->name }}"
                                      style="width:80px;height:80px;object-fit:contain;margin:auto;"
                                    >
                                  @else
                                    {{-- Fallback icon --}}
                                    <img
                                      src="{{ asset('assets/images/category/default.png') }}"
                                      alt="{{ $category->name }}"
                                      style="width:80px;height:80px;object-fit:contain;margin:auto;"
                                    >
                                  @endif

                                  <p>{{ $category->name }}</p>
                                  <span>
                                    @if (isset($category->products_count))
                                      {{ $category->products_count }} Items
                                    @else
                                      {{ $category->products()->count() }} Items
                                    @endif
                                  </span>
                                </a>
                              </div>
                            </div>
                          @endforeach
                        @else
                          {{-- Fallback static slide when no categories --}}
                          <div class="swiper-slide">
                            <div class="single-category-one height-180">
                              <a href="{{ route('shop.index') }}">
                                <img src="{{ asset('assets/images/category/01.png') }}" alt="Category">
                                <p>All Products</p>
                                <span>Browse Items</span>
                              </a>
                            </div>
                          </div>
                        @endif

                      </div>

                      {{-- Swiper navigation buttons (match data-swiper config) --}}

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- rts category area end -->

          </div>
        </div>
      </div>
    </div>
  </section>

<section class="bg-white py-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between">
                    <h2 class="title-left pt--30">Featured Products</h2>
                    <div class="next-prev-swiper-wrapper">
                        <div class="swiper-button-prev first-prod-prev"><i class="fa-regular fa-chevron-left"></i></div>
                        <div class="swiper-button-next first-prod-next"><i class="fa-regular fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">

        <div class="swiper first-featured-swiper">
            <div class="swiper-wrapper">

                @forelse($featured as $product)
                    @php
                        $img = $product->images->first();
                        $oldPrice = $product->price * 1.33;
                        $discount = 25;
                    @endphp

                    <div class="swiper-slide">
                        <div class="glass-card product-card h-100 position-relative">

                            <!-- Discount -->
                            <div class="product-discount">{{ $discount }}% OFF</div>

                            <!-- Product Image -->
                            <div class="product-image">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ $img ? asset('storage/' . $img->path) : asset('assets/images/placeholder.png') }}"
                                         alt="{{ $product->name }}">
                                </a>
                            </div>

                            <!-- Title -->
                            <h6 class="product-title">
                                {{ \Illuminate\Support\Str::limit($product->name, 50) }}
                            </h6>

                            <!-- Price -->
                            <div class="price d-flex align-items-baseline">
                                <span class="product-price">BHD{{ number_format($product->price, 3) }}</span>
                                <span class="product-old-price">BHD{{ number_format($oldPrice, 3) }}</span>
                            </div>

                            <!-- Add to cart -->
                            <div class="mt-auto pt-3">
                                <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="premium-btn flex-fill">
                                        <i class="fas fa-shopping-cart me-1"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="swiper-slide text-center">
                        <h4 class="text-muted py-5">No featured products available yet</h4>
                    </div>
                @endforelse

            </div>
        </div>

    </div>
</section>


{{-- PERFECT CSS + WORKING JS --}}
@push('styles')
<style>
    .single-grocery-product-one {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        position: relative;
    }
    .single-grocery-product-one:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .single-grocery-product-one .discount {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ffab1d;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 4px;
        z-index: 10;
    }
    .single-grocery-product-one .thumbnail img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        background: #f9f9f9;
        padding: 20px;
    }
    .single-grocery-product-one .content {
        padding: 16px;
        text-align: left !important;
    }
    .single-grocery-product-one .title a {
        color: #333;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
    }
    .single-grocery-product-one .unit {
        font-size: 13px;
        margin: 4px 0;
    }
    .single-grocery-product-one .current-price {
        font-size: 18px;
    }

    /* Quantity Input */
    .quantity-input {
        display: flex;
        border: 1.5px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
        height: 36px;
        width: 100px;
    }
    .quantity-input .qty-btn {
        width: 32px;
        background: #fff;
        border: none;
        font-size: 16px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
    }
    .quantity-input .qty-input {
        width: 36px;
        text-align: center;
        border: none;
        border-left: 1.5px solid #ddd;
        border-right: 1.5px solid #ddd;
        font-weight: bold;
        background: #fff;
    }

    /* Add to Cart Button - Orange Border → Fill Orange */
    .add-to-cart-btn {
        background: transparent;
        color: #ffab1d;
        border: 2px solid #ffab1d;
        padding: 7px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .add-to-cart-btn:hover {
        background: #ffab1d;
        color: #fff;
    }
    .add-to-cart-btn i {
        font-size: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Fully working quantity buttons
    document.querySelectorAll('.quantity-input').forEach(container => {
        const decrease = container.querySelector('.decrease');
        const increase = container.querySelector('.increase');
        const input = container.querySelector('.qty-input');

        increase.addEventListener('click', () => {
            input.value = parseInt(input.value) + 1;
        });

        decrease.addEventListener('click', () => {
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
</script>
@endpush


{{-- FINAL EKOMART FEATURED Services  --}}
{{-- FINAL EKOMART FEATURED Services  --}}
<section class="bg-white py-5 mb-5">
        <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between">
                    <h2 class="title-left pt--30">Featured Services</h2>
                    <div class="next-prev-swiper-wrapper">
                        <div class="swiper-button-prev second-prod-prev"><i class="fa-regular fa-chevron-left"></i></div>
                        <div class="swiper-button-next second-prod-next"><i class="fa-regular fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">

     

        <!-- SWIPER CONTAINER (nav kept outside visually but still targeted) -->
        <div class="swiper second-featured-swiper">
            <div class="swiper-wrapper">

                @forelse($featured->take(10) as $product)
                    @php
                        $img = $product->images->first();
                        $oldPrice = $product->price * 1.33;
                        $discount = 25;
                    @endphp

                    <div class="swiper-slide">
                        <div class="glass-card product-card h-100 position-relative">

                            <div class="product-discount">{{ $discount }}% OFF</div>

                            <div class="product-image">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ $img ? asset('storage/' . $img->path) : asset('assets/images/placeholder.png') }}"
                                         alt="{{ $product->name }}">
                                </a>
                            </div>

                            <h6 class="product-title">{{ \Illuminate\Support\Str::limit($product->name, 50) }}</h6>

                            <div class="price d-flex align-items-baseline">
                                <span class="product-price">BHD{{ number_format($product->price, 3) }}</span>
                                <span class="product-old-price">BHD{{ number_format($oldPrice, 3) }}</span>
                            </div>

                            <div class="mt-auto pt-3">
                                <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="premium-btn flex-fill">
                                        <i class="fas fa-shopping-cart me-1"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="swiper-slide text-center">
                        <h4 class="text-muted py-5">No featured products available yet</h4>
                    </div>
                @endforelse

            </div>

            <!-- Optional: pagination if you want dots -->
            <!--<div class="swiper-pagination second-featured-pagination"></div>-->
        </div><!-- swiper end -->

    </div>
</section>


@endsection
{{-- PERFECT CSS + WORKING JS --}}
@push('styles')
<style>

/* Premium Hero Section */
.hero-section { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    border-radius: 0 0 40px 40px;
    position: relative;
    overflow: hidden;
    min-height: 80vh;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow-lg);
}
.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}
.hero-content { 
    position: relative;
    z-index: 2;
    max-width: 800px;
    padding: 2rem 1rem;
}
.hero-title { 
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700;
    background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}
.hero-subtitle { 
    font-size: 1.3rem;
    color: rgba(255,255,255,0.95);
    margin-bottom: 2rem;
    font-weight: 400;
}

/* Glass Cards */
.glass-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    box-shadow: var(--shadow-md);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
}
.glass-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.glass-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: var(--shadow-lg);
}
.glass-card:hover::before { opacity: 1; }

/* Banner Cards */
.premium-banner {
    height: 280px;
    background-size: cover !important;
    background-position: center !important;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
}
.premium-banner::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
}
.banner-content {
    position: absolute;
    bottom: 2rem;
    left: 2rem;
    right: 2rem;
    z-index: 2;
    color: white;
}
.banner-title { font-size: 1.6rem; font-weight: 600; margin-bottom: 0.5rem; }

/* Category Cards */
.category-card {
    height: 140px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}
.category-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-gradient);
    margin-bottom: 1rem;
    font-size: 1.8rem;
    color: white;
    box-shadow: var(--shadow-sm);
}
.category-card:hover .category-icon {
    transform: scale(1.1);
    box-shadow: var(--shadow-md);
}
.category-name { font-weight: 600; font-size: 1rem; margin-bottom: 0.25rem; }
.category-count { font-size: 0.85rem; color: #666; }

/* Product Cards */
.product-card {
    height: 380px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
}
.product-image {
    height: 200px;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ed 100%);
}
.product-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.product-discount {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: var(--accent-gradient);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}
.product-title { 
    font-weight: 600;
    font-size: 1rem;
    line-height: 1.4;
    margin-bottom: 0.5rem;
    color: #2d3748;
}
.product-price {
    font-size: 1.3rem;
    font-weight: 700;
    color: #e53e3e;
    margin-bottom: 0.25rem;
}
.product-old-price {
    font-size: 1rem;
    color: #a0aec0;
    text-decoration: line-through;
    margin-left: 0.5rem;
}

/* Buttons */
.premium-btn {
    background: var(--primary-gradient);
    border: none;
    border-radius: 50px;
    padding: 0.8rem 2rem;
    color: white;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}
.premium-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
}
/* Fix layout issues for second featured swiper */
.second-featured-swiper .swiper-slide {
    display: flex;
    align-items: stretch;     /* ensures product card stretches to same height */
    justify-content: center;
    height: auto;
    box-sizing: border-box;
    padding: 8px 0;
}

.second-featured-swiper .glass-card {
    width: 100%;
    display: flex;
    flex-direction: column;
}

/* ensure product-image keeps its height inside swiper */
.second-featured-swiper .product-image { height: 200px; }

/* small responsive tweaks */
@media (max-width: 768px) {
    .second-featured-swiper .product-image { height: 160px; }
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section { min-height: 60vh; border-radius: 0 0 24px 24px; }
    .premium-banner { height: 220px; }
    .product-card { height: 340px; }
    .product-image { height: 160px; }
}
    .single-grocery-product-one {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        position: relative;
    }
    .single-grocery-product-one:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .single-grocery-product-one .discount {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ffab1d;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 4px;
        z-index: 10;
    }
    .single-grocery-product-one .thumbnail img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        background: #f9f9f9;
        padding: 20px;
    }
    .single-grocery-product-one .content {
        padding: 16px;
        text-align: left !important;
    }
    .single-grocery-product-one .title a {
        color: #333;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
    }
    .single-grocery-product-one .unit {
        font-size: 13px;
        margin: 4px 0;
    }
    .single-grocery-product-one .current-price {
        font-size: 18px;
    }

    /* Quantity Input */
    .quantity-input {
        display: flex;
        border: 1.5px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
        height: 36px;
        width: 100px;
    }
    .quantity-input .qty-btn {
        width: 32px;
        background: #fff;
        border: none;
        font-size: 16px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
    }
    .quantity-input .qty-input {
        width: 36px;
        text-align: center;
        border: none;
        border-left: 1.5px solid #ddd;
        border-right: 1.5px solid #ddd;
        font-weight: bold;
        background: #fff;
    }

    /* Add to Cart Button - Orange Border → Fill Orange */
    .add-to-cart-btn {
        background: transparent;
        color: #ffab1d;
        border: 2px solid #ffab1d;
        padding: 7px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .add-to-cart-btn:hover {
        background: #ffab1d;
        color: #fff;
    }
    .add-to-cart-btn i {
        font-size: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof Swiper !== 'undefined') {

        // FIRST Featured Products Swiper
        new Swiper('.first-featured-swiper', {
            loop: true,
            spaceBetween: 24,
            speed: 900,
            autoplay: { delay: 3200, disableOnInteraction: false },
            slidesPerView: 4,

            navigation: {
                nextEl: '.first-prod-next',
                prevEl: '.first-prod-prev'
            },

            observer: true,
            observeParents: true,
            watchOverflow: true,

            breakpoints: {
                0:   { slidesPerView: 1 },
                480: { slidesPerView: 2 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
                1200:{ slidesPerView: 4 }
            }
        });

    }

});

document.addEventListener('DOMContentLoaded', function () {
    // ensure Swiper is available
    if (typeof Swiper === 'undefined') {
        console.warn('Swiper not loaded - second featured swiper not initialized');
        return;
    }

    const el = document.querySelector('.second-featured-swiper');
    if (!el) return;

    // if already initialized (hot reload / turbolinks), destroy first
    if (el.swiper) {
        try { el.swiper.destroy(true, true); } catch(e) {}
    }

    const secondSwiper = new Swiper(el, {
        loop: true,
        spaceBetween: 24,
        speed: 900,
        autoplay: { delay: 3200, disableOnInteraction: false },
        slidesPerView: 4,
        navigation: {
            nextEl: '.second-prod-next',
            prevEl: '.second-prod-prev'
        },
        // optional pagination if required
        // pagination: { el: '.second-featured-pagination', clickable: true },

        // important for Blade/dynamic content so Swiper recalculates sizes
        observer: true,
        observeParents: true,
        watchOverflow: true,

        breakpoints: {
            0:   { slidesPerView: 1 },
            480: { slidesPerView: 2 },
            768: { slidesPerView: 2 },
            992: { slidesPerView: 3 },
            1200:{ slidesPerView: 4 }
        },

        on: {
            init: function () {
                // ensure layout looks correct after init
                this.update();
            },
            imagesReady: function () {
                this.update();
            }
        }
    });

    // quantity buttons behavior (keeps your existing logic)
    document.querySelectorAll('.quantity-input').forEach(container => {
        const decrease = container.querySelector('.decrease');
        const increase = container.querySelector('.increase');
        const input = container.querySelector('.qty-input');

        if (!increase || !decrease || !input) return;

        increase.addEventListener('click', () => {
            input.value = parseInt(input.value || 0) + 1;
        });

        decrease.addEventListener('click', () => {
            if (parseInt(input.value || 0) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });

    // existing banner image handler (keep this)
    document.querySelectorAll('.banner-one').forEach(function(banner) {
        const desktop = banner.dataset.desktop;
        const mobile  = banner.dataset.mobile;
        if (!desktop && !mobile) return;

        if (window.innerWidth <= 768 && mobile) {
            banner.style.backgroundImage = `url('${mobile}')`;
        } else if (desktop) {
            banner.style.backgroundImage = `url('${desktop}')`;
        }
    });

});
</script>

@endpush

    