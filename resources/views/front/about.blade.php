@extends('front-layouts.master')

@section('content')
    <div id="aboutus" class="aboutus_page">
        <section class="aboutus_title_bar" style="background-image: url(public/front/images/Layer-28.png);">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-6">
                        <div class="block_title">
                            <h1 class="heading-title">We want to help <br> empower you to <br>
                                take the next step.</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="goal_section">
                <div class="row no-gutters ">
                    <div class="col-lg-12 text-center">
                        <div class="aboutus_title text-center">
                            <h2 class="heading-title">We believe in the power of research and choice in helping <br>make the right decision for you and your family.</h2>
                        </div>
                        <div class="divider">
                            <span class="divider-separator"></span>
                        </div>
                        <div class="section_description container text-left">
                            <p class="subtitle">
                                There are many services that exist that help place you or your loved one in a Senior Living home. While it’s good to have someone to help with this process, we feel it is important to provide a tool allowing you to do your own research and help make your own decisions. The goal of our Senior Living Directory is to help you find the best options for you or your loved one, to ensure you pick the best living environment for your or their needs.
                            </p>
                        </div>
                    </div>
                </div>
        </section>
        <section class="our_goal">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-pad">
                        <div class="image_wrapper">
                            <img src="public/front/images/Layer-29-2.png" alt="ourgoal people"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="our_goal_title">
                            <h2 class="heading-title">Our Goals</h2>
                        </div>
                        <div class="goal_img_box_wrapper">
                            <div class="goal_img_box">
                                <div class="icon-box">
                                    <p class="icons abouticon1">Help with you and your family’s decision in finding the best environment for you or your loved one.</p>
                                </div>
                                <div class="icon-box">
                                    <p class="icons abouticon2">Provide powerful, simple, and digestable information all in one place so you can explore your Senior Living options</p>
                                </div>
                                <div class="icon-box">
                                    <p class="icons abouticon3">Give you the tools to filter and discover exactly who will meet the needs you have or the amenties you desire</p>
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
                                <p>Explore our Senior Living Directory to find the top communites in your area.</p>
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
                                                <a href="#"> {{$blog['short_description']}}</a>
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
@endsection