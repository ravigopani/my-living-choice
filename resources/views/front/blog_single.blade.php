@extends('front-layouts.master')

@section('content') 
	<div class="avada-page-titlebar-wrapper">
        <div class="fusion-page-title-bar">
            <div class="fusion-page-title-bar-breadcrumbs">
                <div class="container">
                    <div class="fusion-page-title">
                        <div class="row align-content-center no-gutters">
                            <div class="col-12">
                                <div class="fusion-page-title-wrapper">
                                    <h1>{{$blog['title']}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
               
    <div class="elementor-element-populated">
        <div class="container">
            <div class="fusion-row ">            
                <div class="elementor-widget-container">
                    <div class="elementor-image">
                    	@if(file_exists(storage_path().'/blogPicture/'.$blog['image']) && !empty($blog['image']))
                            <img class="img-fluid" src="{{URL('').'/get_image/blogPicture/'.$blog['image']}}" alt="Blog Image">
                        @else
                            <img class="img-fluid" src="{{URL::asset('public/image/no_image.jpg')}}" alt="No image found">
                        @endif
                    </div>
                </div>
            </div>
            <div class="elementor-page-title">
                <div class="elementor-widget-title">
                    <h1>{{$blog['title']}}</h1>
                </div>
            </div>
            <div class="area-tetxt">                    
            	@php 
            		echo $blog['long_description'];
            	@endphp
            </div>
  
            <div class=" elementor-widget">
                <div classs="recent-posts">
                    <h5>Recent Posts</h5>
                    <div class="recent-link">
                        <div class="row no-gutters">
                        	@if(!empty($blogs))
                        		@foreach($blogs as $val)
                        			<div class="col-md-6"><li><a href="{{url('').'/blog/'.$val['id']}}">{{$val['title']}}</a></li></div>
                        		@endforeach
                        	@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection