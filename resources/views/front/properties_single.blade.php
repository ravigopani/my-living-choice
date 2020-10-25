@extends('front-layouts.master')
 @section('content')
     <div id="property_single" class="property_single_page">
        @if(!empty($property['header_image']) && file_exists(storage_path().'/propertyImage/'.$property['header_image']))
            @php
                $backgroundImageUrl = url('').'/get_image/propertyImage/'.$property['header_image']; 
            @endphp
        @else
            @php
                $backgroundImageUrl = url('').'/public/image/no_img.png'; 
            @endphp
        @endif
        <section class="property_bg" style="background-image: url({{$backgroundImageUrl}});">
             <div class="container">
                 <div class="content-wrapper">
                 </div>
             </div>
        </section>
        <section class="propery_main">
             <div class="container">
                 <div class="row no-gutters">
                     <div class="col-20">
                         <div class="img_wrapper">
                            <div class="propery_img">
                                @if(!empty($property['logo_image']) && file_exists(storage_path().'/propertyImage/'.$property['logo_image']))
                                    <img class="img-fluid" src="{{URL('').'/get_image/propertyImage/'.$property['logo_image']}}" alt="{{$property['name']}}" />
                                @else
                                    <img class="img-fluid" src="{{url('').'/public/image/no_img.png'}}" alt="{{$property['name']}}" />
                                @endif
                            </div>
                         </div>
                    </div>
                     <div class="col-80">
                        <div class="property_detail_wrapper d-flex">
                            <div class="col-70">
                                <div class="property_name">
                                    <h1 class="heading-title">{{$property['name']}}</h1>
                                </div>
                                <div class="property_address_box">
                                    <p>{{$property['address']}}</p>
                                    <p>{{$property['city']}} {{$property['state']}} {{$property['zip']}}</p>
                                </div>
                                <div class="property_rating">
                                    <div class="elementor-widget-container">
                                        <span class="rate-head">
                                            <span class="total-rate">0</span>
                                            <div class="star-rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                        </span>
                                        <p class="total-review">0 User Reviews</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-30">
                                <div class="property_site_link">
                                    <div class="address leftwebsite-link mb-10">
                                        <a class="green-btn" href="{{$property['website']}}" target="_blank">Visit Website</a>
                                    </div>
                                </div>
                                <div class="property_contact_phone">
                                    <h3 class="detail-address">Phone Number</h3>
                                    <div class="phone-box">
                                        <a href="tel:319-775-2920">{{$property['phone_number']}}</a>
                                    </div>
                                </div>
                                <div class="property_contact_phone" style="margin-top: 5px;">
                                    <h3 class="detail-address">Contact Name</h3>
                                    <div class="phone-box">
                                        <a href="tel:319-775-2920">{{$property['contact_name']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
        </section>
        <section class="property_amenties">
             <div class="container">
                 <div class="row no-gutters ">
                    <div class="amentie_wrapper w-100">
                        <div class="amentie_title ">
                            <h2 class="heading-title">Amenties</h2>
                        </div>
                        <div class="amentie_list_wrapper">
                            <ul class="icon-box">
                                @php
                                    $property_amenties = !empty($amenities) ? explode(',', $property['amenities']) : []; 
                                @endphp
                                @if(!empty($amenities))
                                    @foreach($amenities as $val)
                                        @if(in_array($val['id'], $property_amenties))
                                            <li class="icon"><i class="fa fa-check"></i>{{$val['amenity']}}</li>
                                        @else
                                            <li class="icon"><i class="fa fa-times"></i>{{$val['amenity']}}</li>
                                        @endif
                                    @endforeach
                                @else
                                @endif
                            </ul>
                        </div>
                    </div>
                 </div>
             </div>
        </section>
        <section class="property_amenties">
            <div class="container">
                <div class="row no-gutters ">
                   <div class="amentie_wrapper w-100">
                       <div class="amentie_title ">
                           <h2 class="heading-title">Living Types</h2>
                       </div>
                       <div class="amentie_list_wrapper">
                        <ul class="icon-box">
                            @if(!empty($cares))
                                @foreach($cares as $val)
                                    @php $temp_check = false; @endphp
                                    @foreach($property['cares'] as $val1)
                                        @if($val['id'] == $val1['id'])
                                            @php $temp_check = true; @endphp
                                        @endif
                                    @endforeach
                                    @if($temp_check)
                                        <li class="icon"><i class="fa fa-check"></i>{{$val['care']}}</li>
                                    @else
                                        <li class="icon"><i class="fa fa-times"></i>{{$val['care']}}</li>
                                    @endif
                                @endforeach
                            @else
                            @endif
                       </div>
                   </div>
                </div>
            </div>
        </section>
        <section class="property_description_section">
            <div class="container">
                <div class="row no-gutters">
                    <div class="property_content_wrapper">
                        <div class="amentie_title">
                            <h2 class="heading-title">Description</h2>
                        </div>
                        <div class="property_description">
                            <div class="property-content-detail">
                                <p>{{$property['short_description']}}</p>
                                <p>{{$property['long_description']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="property_gallery">
            <div class="container">
                <div class="row no-gutters">
                    <div class="gallery_wrapper w-100">
                        <div class="amentie_title">
                            <h2 class="heading-title">Property Gallery</h2>
                        </div>
                        <div class="row property-gallery"> 
                            @if(!empty($property['gallery']))
                                @foreach($property['gallery'] as $val)
                                    @if(file_exists(storage_path().'/propertyGallery/'.$val['property_id'].'/'.$val['file_path']))
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <a data-fancybox="gallery" href="{{URL('').'/get_image/propertyGallery/'.$val['file_path'].'/'.$val['property_id']}}">
                                            <img class="img-fluid" src="{{URL('').'/get_image/propertyGallery/'.$val['file_path'].'/'.$val['property_id']}}">
                                        </a>
                                    </div>
                                    @else
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <a data-fancybox="gallery" href="{{URL::asset('public/image/no_image.jpg')}}">
                                                <img class="img-fluid" src="{{URL::asset('public/image/no_image.jpg')}}">
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="property_location">
            <div class="container">
                <div class="row no-gutters">
                    <div class="location_wrapper w-100">
                        <div class="amentie_title">
                            <h2 class="heading-title">Location</h2>
                        </div>
                        <div class="map">
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=1239%201st%20Ave%20SE%20D&amp;t=m&amp;z=10&amp;output=embed&amp;iwloc=near" aria-label="1239 1st Ave SE D"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="property_social">
            <div class="container">
                <div class="row no-gutters">
                    <div class="social_content_wrapper">
                        <div class="amentie_title">
                            <h2 class="sec-title">Connect With Us</h2>
                        </div>
                        <div class="icon_wapper f-social-icon prop-share">
                            <ul>
                                @if($property['facebook_link'])
                                    <li class="s-fb">
                                        <a href="{{$property['facebook_link']}}"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                @endif
                                @if($property['twitter_link'])
                                    <li class="s-fv">
                                        <a href="{{$property['twitter_link']}}"><i class="fab fa-twitter-f"></i></a>
                                    </li>
                                @endif
                                @if($property['linkedin_link'])
                                    <li class="s-pintrest">
                                        <a href="{{$property['linkedin_link']}}"><i class="fab fa-linkedin"></i></a>
                                    </li>
                                @endif
                                @if($property['instagram_link'])
                                    <li class="s-fv">
                                        <a href="{{$property['instagram_link']}}"><i class="fab fa-twitter-f"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Section class="property_review">
            <div class="container">
                <div class="review_wrapper">
                    <div class="row no-gutters">
                        <div class="amentie_title col-lg-6">
                            <h2 class="heading-title">Reviews</h2>
                        </div>
                        <div class="col-lg-6 text-right">
                            <form name="submit_review_form" id="submit_review_form" action="https://www.mylivingchoice.com/write-review/" method="post">
                                <input type="hidden" name="review_property_id" id="review_property_id" value="7937">
                                <input type="submit" name="review_property_button" id="review_property_button" value="Write A Review">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </Section>
        <section class="property_community_bar" style="background-image: url(../public/front/images/browse-com-bg.jpg);">
            <div class="container">
                <div class="row no-gutters">
                     <div class="col-lg-6">
                         <div class="bar_title">
                             <p>Explore many other top senior living communities in your city.</p>
                         </div>
                     </div>
                     <div class="col-lg-6 my-auto">
                             <div class="browse_comm_btn">
                                 <a href="#browse" class="button-link" role="button">
                                     <span class="content-wrapper">
                                         <span class="button-text">Browse Communities</span>
                                      </span>
                                 </a>
                             </div>
                     </div>
                </div>
            </div>
        </section>
    </div>
@endsection