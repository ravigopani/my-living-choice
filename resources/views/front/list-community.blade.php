@extends('front-layouts.master')

@section('content')    
    <div id="list-community" class="list_community_page">
        <section class="community_title_bar" style="background-image: url(public/front/images/get-listed-opt-2x-scaled.jpg);">
            <div class="row no-gutters">
                <div class="col-lg-6"></div>
                <div class="col-lg-6">
                    <div class="content_wrpper">
                        <div class="community_title">
                            <h1 class="heading-title">Advertise your Senior Living Community to shoppers for free!</h1>
                        </div>
                        <div class="community_description">
                            <p class="heading-subtitle">Add or Claim your listing by reaching out to us below.</p>
                        </div>
                        @if(Session::has('status'))
                            @if(Session::get('status') == 'success')
                                <div class="alert alert-success">{{ Session::get('message') }}</div>
                            @else
                                <div class="alert alert-danger">{{ Session::get('message') }}</div>
                            @endif
                        @endif
                        <div class="advertise_from_wrapper">
                            <form method="post" action="{{url('').'/list-community'}}">
                                @csrf
                                <div class="form-group"> 
                                    <input type="text" class="form-control" placeholder="Your Name" name="name" required>
                                </div>
                                <div class="form-group"> 
                                    <input type="text" class="form-control"  placeholder="Your Phone" mask="(###) ###-####? x########" name="phone" required>
                                </div>
                                <div class="form-group"> 
                                <input type="email" class="form-control"  placeholder="Your Email" name="email" required>
                                </div>
                                <div class="form-group">
                                <input type="text" class="form-control"  placeholder="Community Website" name="website" required>
                                </div>
                                <div class="form-group form-check">
                                    <span class="radio_text">Interested in paid advertising?</span>
                                    <input type="radio" id="radioyes" name="paid_advertising" value="Yes" checked>
                                    <label for="radioyes"  class="radio-inline">Yes</label>
                                    <input type="radio" id="radiono" name="paid_advertising" value="No">
                                    <label for="radiono" class="radio-inline">No</label>
                                </div>
                                <div class="form_submit">
                                    <button type="submit" class="btn custom_submitnow">Submit now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="listing_features">
            <div class="container">
                <div class="row no-gutters justify-content-center">
                    <div class="listing_wrapper text-center">
                        <div class="img_head">
                           <img class="img-fluid" src="public/front/images/MLC-logo-2x.png" alt="mlclogo"/>
                        </div> 
                        <div class="listing_description">
                           <p>Many people visit My Living Choice every day to find and research the properties that will be the best fit for them or a loved one. Don’t miss the opportunity to be featured in our directory as a Top Senior Living Community for our shoppers. We make it easy to get discovered by the ones ready to take the next step.</p>
                        </div>
                        <div class="divider">
                            <span class="divider-separator"></span>
                        </div>
                        <div class="why_us_head">
                            <h2 class="heading-title">Why List With Us?</h2>
                        </div>
                        <div class="why_us_desc">
                            <p>Listing your community is free! Here are the advantages</p>
                        </div>
                    </div>
                    
                </div>
                <div class="img_box_wrapper">
                    <div class="row">
                        <div class="col-lg-4 text-center">
                            <div class="img_box">
                                <div class="box_icon">
                                    <img class="img-fluid" src="public/front/images/icon1.png" alt="esay discovery"/>
                                </div>
                                <div class="box_text">
                                    <h3 class="box-title">Easy Discovery</h3>
                                    <p class="box-description">Our many visitors will be able to find and research your property quickly and easily, with contact information right on your profile. This will provide the opportunity for direct leads without even requiring a visit to your website.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="img_box">
                                <div class="box_icon">
                                    <img class="img-fluid" src="public/front/images/icon2.png" alt="Leads"/>
                                </div>
                                <div class="box_text">
                                    <h3 class="box-title">Pre-Qualified Leads</h3>
                                    <p class="box-description">Our beautiful Property Profiles help Senior Living Shoppers research and filter by exactly the services they want and need. When an interested client reaches out, they already know what you have to offer and are ready to take the next step.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="img_box">
                                <div class="box_icon">
                                    <img class="img-fluid" src="public/front/images/icon3.png" alt="Advertising"/>
                                </div>
                                <div class="box_text">
                                    <h3 class="box-title">Cost-Effective Advertising</h3>
                                    <p class="box-description">We have low cost advertising options to give your profile top visibility and exposure, ensuring that you are one of the first properties seen by interested visitors. Our ROI has beat any other digital advertising available!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="certified_bar" style="background-image: url(public/front/images/cerified-bg.jpg);">
            <div class="container">
                <div class="row no-gutters">
                     <div class="certified_bar_content">
                         <div class="block_img">
                             <img alt="certified" src="public/front/images/badge-all-white-300x300.png" />
                         </div>
                     </div>
                     <div class="certified_text_content">
                         <div class="certified_block_title">
                             <h3>Add Our Top Choice Reward Badge To Your Website</h3>
                         </div>
                         <div class="certified_block_subtitle">
                             <p>Show off your status as a top community on MyLivingChoice by adding our badge to your website, helping visitors know your property has been recognized.</p>
                         </div>
                     </div>
                </div>
            </div>
        </section>
        <section class="get_started">
            <div class="container">
                <div class="row no-gutters">
                    <div class="getstarted_title col-lg-12 text-center">
                        <h2 class="heading-title">Ready to get your property listed?</h2>
                    </div>
                    <div class="getstarted_btn col-lg-12 text-center">
                        <a href="javascript:void(0)" class="elementor-button-link elementor-button elementor-size-md" role="button" onclick="goToTop()">Get Started</a>
                    </div>
                </div>
            </div>
        </section>
    </div>  

    <script type="text/javascript">
        function goToTop(){
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
    </script>
@endsection