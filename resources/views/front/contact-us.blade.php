@extends('front-layouts.master')

@section('content')	
	<div id="contactus" class="contact_page">
	    <section class="contact_title_bar" style="background-image: url(public/front/images/contactus.png);">
	        <div class="container">
	            <div class="row no-gutters">
	                <div class="col-lg-6"></div>
	                <div class="col-lg-6 col-spacing">
	                    <div class="block_title">
	                        <h1 class="heading-title">Can we help?</h1>
	                    </div>
	                    <div class="block_subtitle">
	                        <p>If you have a question about our website or need our help with something, please reach out to us below</p>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </section>
	    <section class="contact_form">
	        <div class="container">
	            <div class="row no-gutters justify-content-center">
	                <div class="col-lg-8">
	                    <div class="form_wrapper">
	                        <div class="form_title text-center">
	                            <h2 class="email-text">Send us an Email</h2>
	                            <p>(*) all fields are required</p>
	                        </div>

                         	@if(Session::has('status'))
                         		@if(Session::get('status') == 'success')
				                	<div class="alert alert-success">{{ Session::get('message') }}</div>
				                @else
				                	<div class="alert alert-danger">{{ Session::get('message') }}</div>
				                @endif
				            @endif

	                        <div class="form-section">
	                            <div class="form-container text-center">
	                                <form method="post" action="{{url('').'/contact-us'}}">
	                                	@csrf
	                                    <div class="form-row">
	                                        <div class="form-group col-md-6">
	                                          <input type="text" class="form-control" placeholder="Your name" name="first_name" required maxlength="128">
	                                        </div>
	                                        <div class="form-group col-md-6">
	                                          <input type="text" class="form-control" placeholder="Last Name*" name="last_name" required maxlength="128">
	                                        </div>
	                                      </div>
	                                    <div class="form-row">
	                                      <div class="form-group col-md-6">
	                                        <input type="email" class="form-control" id="contactemail" placeholder="Your Email*" name="email" required maxlength="128">
	                                      </div>
	                                      <div class="form-group col-md-6">
	                                        <input type="text" id="contactphone" class="form-control" placeholder="Your Phone*" data-mask="(###) ###-####? x########" autocomplete="tel" novalidate="" name="phone_number" required maxlength="12">
	                                      </div>
	                                    </div>
	                                    <div class="form-row">
	                                        <div class="form-group col-md-12">
	                                            <textarea rows="5" class="form-control " id="contactaddress" placeholder="Your message*" name="message" required maxlength="512"></textarea>
	                                        </div>
	                                    </div>
	                                    <button type="submit" class="send_msg_btn">Send Message</button>
	                                </form>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </section>
	    <section class="contact_map">
	        <div class="map_container">
	            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=7280%20NW%2087th%20Terrace%20Suite%20C210%20Kansas%20City%2C%20MO%2064153&amp;t=m&amp;z=10&amp;output=embed&amp;iwloc=near" aria-label="7280 NW 87th Terrace Suite C210 Kansas City, MO 64153"></iframe>
	        </div>
	    </section>
	</div>
@endsection