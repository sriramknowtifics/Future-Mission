<footer class="premium-footer">
    <div class="footer-top">
        <div class="container">
            <div class="row footer-row">

                <!-- ABOUT -->
                <div class="col-lg-3 col-md-6 col-12 footer-col">
                    <h4 class="footer-title">About Future Mission</h4>
                    <p class="footer-desc">
                        Future Mission is your trusted online marketplace delivering quality
                        products, fast shipping, and reliable customer support.
                        Shop confidently — satisfaction guaranteed.
                    </p>

                    <div class="footer-contact">
                        <p><i class="fa-solid fa-phone"></i> +973 35549994</p>
                        <p><i class="fa-solid fa-envelope"></i> Info@fmce.bh</p>
                        <p>
                            <i class="fa-solid fa-location-dot"></i>
                            Office #101, First Floor, Building 1273, Road 1223, Block 1012,
                            Al Hamala – 37638, BAHRAIN
                        </p>
                    </div>
                </div>

                <!-- SHOP -->
                <div class="col-lg-2 col-md-6 col-6 footer-col">
                    <h4 class="footer-title">Shop</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('shop.index',['category'=>1]) }}">Appliances</a></li>
                        <li><a href="{{ route('shop.index',['category'=>15]) }}">Electronics</a></li>
                        <li><a href="{{ route('shop.index',['category'=>3]) }}">Lighting</a></li>
                        <li><a href="{{ route('shop.index',['category'=>11]) }}">Power Storage</a></li>
                      
                    </ul>
                </div>

                <!-- CUSTOMER CARE -->
                <div class="col-lg-2 col-md-6 col-6 footer-col">
                    <h4 class="footer-title">Customer Care</h4>
                    <ul class="footer-links">
                        <li><a href="#">Returns & Refunds</a></li>
                        <li><a href="{{route('faq')}}">FAQs</a></li>
                    </ul>
                </div>

                <!-- USEFUL LINKS -->
                <div class="col-lg-2 col-md-6 col-6 footer-col">
                    <h4 class="footer-title">Useful Links</h4>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Report an Issue</a></li>
                        <li><a href="#">Affiliate Program</a></li>
                        <li><a href="{{ route('register.vendor') }}">Become a Seller</a></li>
                    </ul>
                </div>

                <!-- NEWSLETTER -->
                <div class="col-lg-3 col-md-6 col-12 footer-col">
                    <h4 class="footer-title">Stay Updated</h4>
                    <p class="footer-desc">
                        Join our newsletter to receive exclusive deals & updates.
                    </p>

                    <form class="newsletter-form">
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit">Subscribe</button>
                    </form>

                    <div class="footer-social">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- COPYRIGHT -->
    <div class="footer-bottom">
        <div class="container text-center">
            <p>© {{ date('Y') }} Future Mission. All Rights Reserved.</p>
        </div>
    </div>
</footer>
