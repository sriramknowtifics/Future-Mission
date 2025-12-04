@extends('layouts.theme')
@section('title', 'Contact Us')

@section('content')
<!-- CONTACT HERO -->
<section class="contact-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We’re here to help you with orders, products, services and support.</p>
    </div>
</section>

<!-- CONTACT BODY -->
<section class="contact-wrapper">
    <div class="container">
        <div class="row g-4">

            <!-- CONTACT FORM -->
            <div class="col-lg-7">
                <div class="shadow-box contact-box">

                    <h2 class="section-title">Send Us a Message</h2>

                    <form action="#" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Your Name</label>
                            <input type="text" placeholder="Enter your name" required>
                        </div>

                        <div class="form-group">
                            <label>Your Email</label>
                            <input type="email" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" placeholder="Enter your phone">
                        </div>

                        <div class="form-group">
                            <label>Your Message</label>
                            <textarea rows="5" placeholder="Write your message..." required></textarea>
                        </div>

                        <button type="submit" class="btn-submit">Submit Message</button>
                    </form>

                </div>
            </div>

            <!-- CONTACT INFORMATION -->
            <div class="col-lg-5">
                <div class="shadow-box contact-info">

                    <h2 class="section-title">Get in Touch</h2>
                    <p class="desc">
                        Have questions about an order, product or service?  
                        Our team is ready to support you.
                    </p>

                    <div class="info-item">
                        <i class="fa-solid fa-phone"></i>
                        <p><strong>Phone:</strong> +973 35549994</p>
                    </div>

                    <div class="info-item">
                        <i class="fa-solid fa-envelope"></i>
                        <p><strong>Email:</strong> info@fmce.bh</p>
                    </div>

                    <div class="info-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <p>
                            <strong>Address:</strong>  
                            Office #101, First Floor, Bldg 1273, Road 1223,  
                            Block 1012, Al Hamala – 37638, Bahrain
                        </p>
                    </div>

                    <h3 class="section-title" style="margin-top: 25px;">Business Hours</h3>

                    <ul class="hours-list">
                        <li><strong>Monday–Friday:</strong> 8:00 AM – 6:00 PM</li>
                        <li><strong>Saturday:</strong> 9:00 AM – 5:00 PM</li>
                        <li><strong>Sunday:</strong> Closed</li>
                    </ul>

                </div>
            </div>

        </div>

        <!-- MAP -->
        <div class="map-box">
            <div class="map-holder">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7241.696302810715!2d50.456!3d26.102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjbCsDA2JzA3LjIiTiA1MMKwMjcnMjUuNiJF!5e0!3m2!1sen!2sbh!4v1700000000000" 
                    width="100%" 
                    height="380"
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

    </div>
</section>
@endsection