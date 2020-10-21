@extends('front-layouts.master')

@section('content') 
    <div id="blog" class="blog_page">
        <section class="blog_banner" style="background-image: url(public/front/images/blog-banner-img.png);">
            <div class="container">
                <div class="row no-gutters justify-content-center row_pad">
                    <div class="banner_title">
                        <h1 class="heading-title">Search Articles</h1>
                    </div>
                    <div class="search_form_wrapper">
                        {{-- <form class="search-form" role="search" action="#" method="get"> --}}
                            <div class="search-form_container">
                                <input placeholder="Search"class="search-form__input" type="search" name="s" title="Search" id="search" value="">
                                 <button id="search_button" class="search-form__submit" type="button" title="Search" aria-label="Search">Search</button>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>  
                <div class="row no-gutters has-sidebar">
                    <div class="col-lg-8 article_area"></div>
                    <div class="col-lg-4 sidebar"></div>
                </div>
            </div>
        </section>
        <section class="blog-content">
            <div class="container">
                <div class="row no-gutters has-sidebar">
                    <div class="col-lg-8 article_area" id="blog_list">
                        
                    </div>
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar_wrapper">
                            <div class="top_article">
                                <div class="article_sidebar_title">
                                    <h4 class="heading-title">Top Articles</h4>
                                </div>
                                <div class="top_article_list">
                                    <div class="blog_list_container">
                                        @if(!empty($top_articles))
                                            @foreach($top_articles as $value)
                                                <article class="post-grid-item">
                                                    <div class="article-post__card">
                                                        <div class="article-post__text">
                                                            <h3 class="article-post__title"><a href="#">{{$value['short_description']}}</a>
                                                            </h3>
                                                        </div>
                                                        <div class="article-post__meta-data">
                                                            <span class="article-post-date">{{date('F d, Y', strtotime($value['created_at']))}}</span>
                                                        </div>
                                                    </div>
                                                </article>
                                            @endforeach
                                        @else
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tag_cloud">
                                <div class="tag_cloud-wrapper">
                                    <div class="tag_sidebar_title">
                                        <h6 class="heading-title">Tags</h6>
                                    </div>
                                    <div class="tag_wrapper">
                                        <a href="#" class="tag-cloud-link" aria-label="assisted living (3 items)">assisted living</a>
                                        <a href="#" class="tag-cloud-link" aria-label="Kansas City (1 item)">Kansas City</a>
                                        <a href="#" class="tag-cloud-link" aria-label="los angeles (1 item)">los angeles</a>
                                        <a href="#" class="tag-cloud-link " aria-label="memory care (1 item)">memory care</a>
                                        <a href="#" class="tag-cloud-link " aria-label="retirement centers (1 item)">retirement centers</a>
                                        <a href="#" class="tag-cloud-link" aria-label="senior living (7 items)">senior living</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(function(){
            load_blod_data();
            $('#search_button').click(function(){
                load_blod_data($('#search').val());
            });
        });


        function load_blod_data(search = '', page = 1)
        {
            $(".loading").show();
            $.ajax({
                type: "POST", 
                url: BASE_URL+'blog-list-data',  // no base url required filename is includes baseurl.
                data: {
                    search:search,
                    page:page
                },
                success: function (data) {
                    if(data.status == 'error')
                    {
                        show_notification(data.status,data.message);
                    }
                    else
                    {
                        $('#blog_list').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Whoops, looks like something went wrong");
                },
                complete:function(result){
                    $(".loading").hide();           
                }
            });
        }
    </script>
@endsection