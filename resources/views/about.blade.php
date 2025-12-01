@extends('layouts.theme')

@section('title', 'About — Future Mission Holding Company')

@section('content')

<!-- ABOUT: Banner -->
<div class="about-banner-area-bg rts-section-gap bg_iamge">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="inner-content-about-area text-center">
          <h1 class="title">Your Trusted Partner in Construction and Services</h1>
          <p class="disc mx-auto" style="max-width:900px;">
            FUTURE MISSION HOLDING COMPANY is a proud Saudi-owned company based in Al Jubail, Eastern Province — the heart of the Kingdom’s industrial sector. Since inception, our vision has been clear: to be the preferred general contracting partner for Saudi Arabia’s dynamic industrial landscape. We combine deep local knowledge with international best practices to deliver reliable, high-quality services across Insulation, Scaffolding, Civil, Mechanical, IT and Marine. Driven by a dedicated team, we prioritize safety, precision and client satisfaction.

          </p>
          <a href="{{ route('contact') ?? url('/contact') }}" class="rts-btn btn-primary">Contact Us</a>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- ABOUT + Services -->
<div class="rts-about-area rts-section-gap2">
  <div class="container">
    <div class="row align-items-center g-5">

      <div class="col-lg-4">
        <div class="thumbnail-left">
          <img src="{{ asset('assets/images/about/02.jpg') }}" alt="Future Mission"
               class="img-fluid rounded"
               style="width:100%; height:auto; object-fit:cover;">
        </div>
      </div>

      <div class="col-lg-8">
        <div class="about-content-area-1">
          <h2 class="title">Comprehensive Construction Solutions</h2>
          <p class="disc">
            Expertise in Insulation, Scaffolding, Civil, Mechanical, IT and Marine services...
          </p>

          <div class="check-main-wrapper">
            <div class="single-check-area">Insulation Services — reliable solutions...</div>
            <div class="single-check-area">Scaffolding Services — efficient solutions...</div>
            <div class="single-check-area">Civil Infrastructure — planning & design...</div>
            <div class="single-check-area">Mechanical & Marine — maintenance & overhauls...</div>
            <div class="single-check-area">IT Services — cost-effective digital solutions...</div>
            <div class="single-check-area">Crew & Seafarer Recruitment — one-stop solution...</div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>


<!-- TEAM -->
<div class="meet-our-expart-team rts-section-gap2">
  <div class="container">
    <div class="title-center-area-main text-center">
      <h2 class="title">Meet Our Expert Team</h2>
      <p class="disc mx-auto" style="max-width: 700px;">
        Driven by a dedicated team of engineers, project managers and technicians...
      </p>
    </div>

    <div class="row g-4 mt-4">

      @foreach([1,2,3,4] as $i)
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="single-team-style-one">
          <a href="#" class="thumbnail d-block">
            <img src="{{ asset('assets/images/team/0'.$i.'.jpg') }}"
                 class="img-fluid w-100 rounded"
                 style="height:280px; object-fit:cover;"
                 alt="team member">
          </a>
          <div class="bottom-content-area">
            <div class="top">
              <h3 class="title">Team Member {{ $i }}</h3>
              <span class="designation">Designation</span>
            </div>
            <div class="bottom">
              <a href="#" class="number"><i class="fa-solid fa-phone-rotary"></i> +25896 3158 3228</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</div>


<!-- WHY CHOOSE US -->
<div class="rts-service-area rts-section-gap2 bg_light-1">
  <div class="container">

    <div class="title-center-area-main text-center">
      <h2 class="title">Why You Choose Us?</h2>
      <p class="disc mx-auto" style="max-width: 700px;">
        We combine local expertise with international standards...
      </p>
    </div>

    <div class="row g-4 mt-4">

      @foreach([1,2,3] as $n)
      <div class="col-lg-4 col-md-6">
        <div class="single-service-area-style-one">

          <div class="icon-area text-center">
            <img src="{{ asset('assets/images/service/0'.$n.'.svg') }}"
                 class="img-fluid"
                 style="width:70px; height:auto;"
                 alt="service icon">
          </div>

          <div class="bottom-content text-center">
            <h3 class="title">Service Title {{ $n }}</h3>
            <p class="disc">Short description of the service provided...</p>
          </div>

        </div>
      </div>
      @endforeach

    </div>

  </div>
</div>


<!-- Testimonials -->
<div class="rts-cuystomers-feedback-area rts-section-gap2">
  <div class="container">

    <div class="title-center-area-main">
      <h2 class="title-left">Customer Feedbacks</h2>
    </div>

    <div class="swiper mySwiper-category-1">
      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="single-customers-feedback-area">

            <div class="top-thumbnail-area d-flex justify-content-between align-items-center">

              <div class="left d-flex">
                <img src="{{ asset('assets/images/testimonial/01.png') }}"
                     class="img-fluid me-3"
                     style="width:60px; height:60px; object-fit:contain;">
                <div class="information">
                  <h4 class="title">Andrew D. Smith</h4>
                  <span>Manager</span>
                </div>
              </div>

              <div class="right">
                <img src="{{ asset('assets/images/testimonial/02.png') }}"
                     class="img-fluid"
                     style="width:50px; height:50px; object-fit:contain;">
              </div>

            </div>

            <div class="body-content mt-3">
              <p class="disc">“Future Mission delivered on time with full safety & quality.”</p>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>
</div>


<!-- CTA -->
<div class="rts-section-gap bg_iamge">
  <div class="container text-center">
    <h3 class="title">Your Trusted Partner in Industrial Construction</h3>
    <p class="disc">Head Office: Office #1, Ground Floor, Jubail...</p>
    <a href="{{ route('contact') ?? url('/contact') }}" class="rts-btn btn-primary">Submit an Inquiry</a>
  </div>
</div>

@endsection
