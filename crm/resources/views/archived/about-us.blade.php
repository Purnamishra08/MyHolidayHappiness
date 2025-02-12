@extends('layout.master')


@section('title', $title)

@section('description', $description)

@section('keywords', $keywords)

@section('css')

<style type="text/css">

  

</style>

@endsection

@section('content')

   <!-- start banner slider  -->
    <div class="srvbanner clearfix" style="background-repeat: no-repeat; background-position: center top; background-image: url('{{ asset("img/synergy-about.jpg") }}'); background-size: cover;"></div>
    <!-- end banner slider  -->
    <!-- start about us section -->
    <section class="about-section" id="about-us">
        <div class="container">
            <h2 class="section-heading js-scroll fade-in">About Synergy Wellness</h2>
            <div class="row align-items-center">
                <div class="col-md-6 text-center js-scroll slide-left">
                    <img  src="{{ asset('img/synergy-abt.jpg') }}"  class="about-image-page" alt="">
                </div>
                <div class="col-md-6 js-scroll slide-right">
                    <p class="desc"><a href="{{ URL::to('/') }}">Synergy Wellness LLC</a> is committed to providing exceptional housing stabilization services to those in need. Our passionate and empathetic team understands that finding and maintaining stable housing can be a challenging journey, which is why we offer personalized solutions tailored to each client’s unique needs. We believe that everyone deserves a safe, secure, and comfortable place to call home, and we’re dedicated to making that a reality for our clients.</p>
                        <p class="desc">We empower and uplift communities by eliminating housing insecurity and providing holistic support that promotes independence, self-sufficiency, and overall well-being. We believe that stable housing is the foundation for a better life, and we’re committed to helping individuals and families achieve that stability.</p>
                        
                        
                </div>
            </div>
            
        </div>
    </section>
    <!-- end about us section -->
    
     
      <!-- start contact section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <h2 class="section-heading js-scroll fade-in"> Contact us</h2>
            <p class="desc text-center mb-5 pb-4 js-scroll fade-in" >Wellness is the best gift you can give yourself. Visit our center today.</p>
            <h5>Contact us Monday-Friday, 9 AM - 5 PM</h5>
            <div class="row">
                <div class="col-md-6 js-scroll fade-in-bottom">
                    <ul class="px-3">
                        <li class="footer-list contact-page">
                            <div class="footer-link-address">
                                <div>
                                    <svg fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z">
                                        </path>
                                    </svg>
                                </div>
                                <p>7900 Excelsior Blvd, Suite#104A Hopkins MN 55343</p>
                            </div>
                        </li>
                        <li class="footer-list contact-page">
                            <div class="footer-link-address">
                                <svg fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                                    </path>
                                </svg>
                                <p>
                                    +1 612-404-4594
                                    <br>
                                </p>


                            </div>
                        </li>
                        <li class="footer-list">
                            <div class="footer-link-address contact-page contact-footer-list">
                                <svg fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z">
                                    </path>
                                </svg>
                                <p>info@synergywellnessmn.com</p>
                                <div class="qr-code"><img src="{{ asset('img/contact/OQ-code.jpg') }}" alt=""></div>
                            </div>
                        </li>

                    </ul>
                </div>
                <div class="col-md-6 js-scroll fade-in-bottom">
                    <form action="{{ URL::to('/submit-contact-us') }}" class="contact-frm"  method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="field">
                                    <input type="text" placeholder="Full Name*" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field">
                                    <input type="text" placeholder="Email Address" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="field">
                                    <textarea placeholder="Message" name="message" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="btn submit-btn ">
                                    <input type="submit" value="SUBMIT">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- end contact section -->

@endsection

@section('js')

  <script>

  </script>

@endsection