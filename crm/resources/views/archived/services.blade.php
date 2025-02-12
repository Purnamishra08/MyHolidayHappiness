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
    <div class="srvbanner clearfix" style="background-repeat: no-repeat; background-position: center top; background-image: url('{{ asset("img/syneergy-service.jpg") }}'); background-size: cover;"></div>
    <!-- end banner slider  -->
     <!-- start services section -->
    <section class="service-section" id="services">
        <div class="container">
            <h2 class="section-heading js-scroll fade-in">Our Services</h2>
            <div class="row">
                 <div class="col-md-2"></div>
                <div class="col-md-8 js-scroll fade-in-bottom">
                    
                    <p style="margin-top: 33px;">Housing Stabilization Services (HSS) supports people with disabilities in finding housing; establishing a basic spending plan; creating natural community supports by connecting with landlords; and assisting people with understanding the rules and responsibilities of a lease.</p>
                    <div class="serv2">
                        <h4>Goals of HSS is to:</h4>
                        <ul>
                            <li>Support an individual’s transition into housing </li>
                            <li>Increase long-term stability in housing in the community </li>
                            <li>Avoid future periods of homelessness or institutionalization</li>
                           
                        </ul>
                        
                        <h4>To qualify for HSS, you must meet the following criteria: </h4>
                        <ul>
                            <li>18 years of age and receiving Medical Assistance </li>
                             <li>Have a disability or a disabling condition </li>
                              <li>Be experiencing housing instability</li>
                               <li>Have a need for services due to limitations caused by individual disability </li>
                            
                        </ul>
                        <p><strong>Note:</strong> Admission into Placement Partners HSS program is subject to State of MN Department of Human Services (DHS) Eligibility Verification Review. </p>
                        <h4>Documents needed for DHS Eligibility Verification Review: </h4>
                        <ul>
                            <li>Professional statement of need, OR </li>
                            <li>Medical opinion form, OR</li>
                            <li>Proof of recipient of SSI or SSDI </li>
                        </ul>
                        <h4>AND</h4>
                        <ul>
                            <li>MN Choices Assessment, OR </li>
                            <li>Long term Care Coordination Plan, OR </li>
                            <li>Coordinated Entry Assessment </li>
                            
                        </ul>
                      
                    </div>
                    
                </div>
                <div class="col-md-2"></div>
                <!-- div class="col-md-4 js-scroll fade-in-bottom">
                    <div class="service-item">
                        <div class="service-item-inner outer-shadow">
                            <div class="icon ">
                                <img src="img/img34.png" alt="">
                            </div>
                            <h3>Independent Living Services</h3>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit
                                doloribus, consequuntur eum distinctio libero nobis. Accusantium fuga error facere
                            </p>
                            <a href=""><img src="img/right-arrow.png" alt=""></a>
                        </div>
                    </div>
                </div -->
                <!-- div class="col-md-4 js-scroll fade-in-bottom">
                    <div class="service-item">
                        <div class="service-item-inner outer-shadow">
                            <div class="icon ">
                                <img src="img/img34.png" alt="">
                            </div>
                            <h3>Home Care Services</h3>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit
                                doloribus, consequuntur eum distinctio libero nobis. Accusantium fuga error facere
                            </p>
                            <a href=""><img src="img/right-arrow.png" alt=""></a>
                        </div>
                    </div>
                </div -->
            </div>
        </div>
    </section>
    <!-- end services section -->
    
     
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
                                <div class="qr-code"><img src="img/contact/OQ-code.jpg" alt=""></div>
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