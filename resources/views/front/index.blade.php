@extends('front-layouts.master')

@section('content')
    <style type="text/css">
        .img-fluid{
            /*height: 100% !important;*/
            width: 100% !important;
        }
    </style>
    <div id="home" class="home_page">
       <section class="home_banner">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-6">                
                    </div>
                    <div class="col-lg-6 ">
                        <div class="find_property_form">
                            <div class="section_title">
                                <h4>Discover The Best Senior Living Near You</h4>
                            </div>
                            <div class="section_sub_title">
                                <h4>Browse Our Senior Living Directory</h4>
                            </div>
                            <form name="home_filter_property" id="home_filter_property" method="get" action="{{url('').'/properties-list'}}">
                                <select name="care" class="home_property_filter" id="home_property_living">
                                    <option value="">Select Type of Care</option>
                                    @if(!empty($cares))
                                        @foreach($cares as $val)
                                            <option value="{{$val['id']}}">{{$val['care']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <select name="city" class="home_property_filter" id="home_property_cities">
                                    <option value="">Select City</option>
                                    @if(!empty($cities))
                                        @foreach($cities as $val)
                                            <option value="{{$val['id']}}">{{$val['city'].', '.$val['state']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <button type="submit" name="search" id="search" class="home_search_button">Search Now</button>
                            </form>   
                        </div>
                    </div>
                </div>
            </div>
       </section> 
       <section class="Community">
            <div class="container">
                <div class="row no-gutters">
                    <div class="sen_col">
                        <div class="browse_community">
                            <div class="block-title">
                                <h4>It's Time To Find A Senior Living Community You Can Trust</h4>
                            </div>
                            <div class="block_subtitle">
                                <p>My Living Choice can help you find the best new home for you with our list of pre-vetted and reputable communities</p>
                            </div>
                            <div class="br_block_link">
                                <a class="br_comm_link" href="{{url('').'/best-senior-living'}}">Browse Top Communities</a>
                            </div>
                            <a class="trust_cm_link" href="#">Learn why you can trust our certified communities</a>
                        </div>
                    </div>
                    <div class="claim_col">
                        <div class="claim_community">
                            <div class="block-title">
                                <h4>Are you a Senior Living Community?</h4>
                            </div>
                            <div class="block_subtitle">
                                <p>Don’t ignore the thousands who visit My Living Choice looking for their next home. Create or claim your profile today.</p>
                            </div>
                            <div class="br_block_link">
                                <a class="br_comm_link" href="{{url('').'/list-community'}}">Claim Your Community</a>
                            </div>
                            <a class="trust_cm_link" href="#">Learn why you should join My Living Choice</a>
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
                            <img alt="certified" src="{{URL::asset('public/front/images/badge-all-white-300x300.png')}}" />
                        </div>
                    </div>
                    <div class="certified_text_content">
                        <div class="certified_block_title">
                            <h3>Certified Communities <br>You Can Trust.</h3>
                        </div>
                        <div class="certified_block_subtitle">
                            <p>When you see a My Living Choice badge, this means they are a top senior community for you or your loved one.</p>
                        </div>
                    </div>
               </div>
           </div>
       </section>
       <section class="features" style="background-image: url(public/front/images/real-people.png);">
           <div class="container">
               <div class="row no-gutters">
                   <div class="feature_points">
                        <div class="feature_single">
                            <div class="content_holder">
                                <div class="image_box">
                                    <figure class="image-box-img">
                                        <img width="94" height="94" src="{{URL::asset('public/front/images/Layer-5-copy.png')}}"  alt="">
                                    </figure>
                                </div>
                                <div class="img_box_content">
                                    <h3 class="image-box-title">Read Senior Living Reviews</h3>
                                    <p class="image-box-description">We let the public give their opinions on senior living communities. And, we validate each person using a Social Media profile to ensure they are real people. Let those who’ve experienced the community help you discover the perfect home.</p>
                                </div>
                            </div>
                            <div class="content_holder">
                                <div class="image_box">
                                    <figure class="image-box-img">
                                        <img width="94" height="94" src="{{URL::asset('public/front/images/credibility-icon.png')}}"  alt="">
                                    </figure>
                                </div>
                                <div class="img_box_content">
                                    <h3 class="image-box-title">Choose Your Amenities</h3>
                                    <p class="image-box-description">Our property map lets you find the senior living communities near you that have all the amenities you want or need. Don’t waste time digging through websites trying to figure out what they offer. Drill down your search to exactly what you’re looking for.</p>
                                </div>
                            </div>
                            <div class="content_holder">
                                <div class="image_box">
                                    <figure class="image-box-img">
                                        <img width="94" height="94" src="{{URL::asset('public/front/images/detailed-icon.png')}}"  alt="">
                                    </figure>
                                </div>
                                <div class="img_box_content">
                                    <h3 class="image-box-title">Explore Properties Easily</h3>
                                    <p class="image-box-description">View a photo gallery and learn all about what each property offers without having to research many websites. Our property profiles give you all the information you need to determine if a property is the right fit for you or your loved one without having to leave our website.</p>
                                </div>
                            </div>
                        </div>
                   </div>
               </div>
           </div>
       </section>
       <section class="browse_community_bar" style="background-image: url(public/front/images/browse-com-bg.jpg);">
           <div class="container">
               <div class="row no-gutters">
                    <div class="col-lg-6">
                        <div class="bar_title">
                            <p>Explore our list of top senior living communities in your city to find your next home.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 my-auto">
                            <div class="browse_comm_btn">
                                <a href="javascript:void(0)" onclick="goToTop()" class="button-link" role="button">
                                    <span class="content-wrapper">
                                        <span class="button-text">Browse Communities</span>
                                     </span>
                                </a>
                            </div>
                    </div>
               </div>
           </div>
       </section>
       <section class="expert_help">
           <div class="container">
                <div class="row no-gutters">
                    <div class="section_title">
                        <h1 class="heading-title">Our Experts Want to Help You <br> Learn.</h1>
                    </div>
                </div>
                <div class="row homepage-blog-section ">
                    @if(!empty($blogs))
                        @foreach($blogs as $blog)
                            <div class="col-lg-3">
                                <article class="post_article">
                                    <a class="post_thumbnail_link" href="#">
                                        <div class="post_thumbnail">
                                            @if(file_exists(storage_path().'/blogPicture/'.$blog['image']) && !empty($blog['image']))
                                                <img src="{{URL('').'/get_image/blogPicture/'.$blog['image']}}" class="img-fluid" alt="Blog Image">
                                            @else
                                                <img src="{{URL::asset('public/image/no_image.jpg')}}" class="img-fluid" alt="No image found">
                                            @endif
                                        </div>
                                    </a>
                                    <div class="post_text">
                                        <h3 class="post_title">
                                            <a href="{{url('').'/blog/'.$blog['id']}}"> {{$blog['short_description']}}</a>
                                        </h3>
                                        <div class="post_meta-data">
                                            <span class="post-date"> {{date('F d, Y', strtotime($blog['created_at']))}}</span>
                                        </div>
                                    </div>
                                </article>                         
                            </div>
                        @endforeach
                    @endif
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