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
    <div class="srvbanner clearfix" style="background-repeat: no-repeat; background-position: center top; background-image: url('{{ asset("img/referral-synergy.jpg") }}'); background-size: cover;"></div>
    <!-- end banner slider  -->
    <!-- start inner section -->
    <section>
        <div class="container">
                <div class="row">
               <div class="entry-content">
          
                                
                            </div>
                            
     
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <h2 style="text-align: center;font-size: 27px; font-weight: bold;">Send Referrals</h2>
<p style="text-align: center;"><strong>Do you know someone who could benefit from our Housing Stabilization Services? <br> <a href="#" target="_blank" rel="noopener noreferrer">If so, we would love to hear from you!</a>.</strong></p>
<p style="text-align: center;">Kindly fill out the form below and we will take care of the rest. <br>Thank you for choosing <strong>Synergy Wellness! <br>  We appreciate your referrals</strong> </p>
	            				<div class="appoint-section clearfix">
					<div class="top-icon"><img src="/synergywellness/img/form-top.png" alt=""></div>
					<form id="appointment_form_main" action="{{ URL::to('/submit-referrals') }}" method="post" >
						  @csrf
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="first_name" id="app-name" class="required" placeholder="First Name*" title="* Please provide your name" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="last_name" id="app-number" class="required" placeholder="Last Name" title="* Please provide your last name." required>
							</div>
						</div>

						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input  type="text" onfocus="(this.type='date')" name="dob" id="datepicker" class="required hasDatepicker" autocomplete="off" placeholder="Birthday" title="* Please provide your Birthday" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="email" name="email" id="app-email" class="required email" placeholder="Email Address" title="* Please provide a valid email address" required>
							</div>
						</div>
						
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="tel" name="contact_number" id="app-name" class="required" autocomplete="off" placeholder="Contact Number*" title="* Please provide your contact number" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="address" id="app-name" class="required" placeholder="Address*" title="* Please provide a valid address"required>
							</div>
						</div>
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="emerg_name" id="app-name" class="required" autocomplete="off" placeholder="Emergency Contact Name" title="* Please provide your Emergency Contact Name" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="tel" name="emerg_number" id="app-name" class="required" placeholder="Emergency Contact Number" title="* Please provide Emergency contact Number" required>
							</div>
						</div>
						
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="ref_agenc_name" id="app-name" class="required" autocomplete="off" placeholder="Referring Agency" title="* Please provide your Referring Agency" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="case_manager_name" id="app-name" class="required" placeholder="Case Manager" title="* Please provide Case Manager Name" required>
							</div>
						</div>
						
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="case_manager_number" id="app-name" class="required" autocomplete="off" placeholder="Case Manager Number" title="* Please provide your Case Manager Number" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="email" name="case_manager_email" id="app-name" class="required" placeholder="Case manager Email" title="* Please provide Case manager Email" required>
							</div>
						</div>
						
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="reason_of_referral" id="app-name" class="required" autocomplete="off" placeholder="Reason for Referral" title="* Please provide Reason for Referral" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="client_PMI" id="app-name" class="required" placeholder="Client PMI" title="* Please provide Client PMI" required>
							</div>
						</div>
						
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="guardian_name" id="app-name" class="required" autocomplete="off" placeholder="Guardian Name" title="* Please provide Guardian Name" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="text" name="diagnosis_code" id="app-name" class="required" placeholder="Diagnosis code" title="* Please provide Diagnosis code" required>
							</div>
						</div>
						
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input  type="text" onfocus="(this.type='date')" name="anticipated_date" id="app-name" class="required" autocomplete="off" placeholder="Anticipated start date" title="* Please provide Anticipated start date" required>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 ">
								<input type="tel" name="guardian_phone" id="app-name" class="required" placeholder="Guardian Phone" title="* Please provide Guardian Phone" required>
							</div>
						</div>

						<!-- div class="row">
							<div class=" col-lg-12 col-md-12 col-sm-12">
								<textarea name="message" id="app-message" class="required" cols="50" rows="1" placeholder="Message" title="* Please provide your message" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 175px;"></textarea>
								<input type="hidden" name="action" value="make_appointment">
								<input type="hidden" name="nonce" value="29b0b5d027">
							</div>
						</div -->

												<div class="row">
							<div class="col-sm-12 col-md-6">
								<input type="submit" name="Submit" class="btn" value="Submit Request">
								
							</div>
							
							<div class="col-sm-12">
								<div id="message-sent"></div>
								<div id="error-container"></div>
							</div>
						</div>
					</form>
				</div>
				</div>
				            <div class="col-md-2"></div>
				            </div></div>
                           
    </section>
    <!-- end inner section -->

@endsection

@section('js')

  <script>

  </script>

@endsection