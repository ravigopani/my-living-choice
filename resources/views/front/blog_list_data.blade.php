<div class="article_wrapper">
    @if(!empty($blogs['data']))
        @foreach($blogs['data'] as $blog)
            <article class="post_article">
                <a class="post__thumbnail__link" href="javascript:void(0)">
                    <div class="post__thumbnail">
                        @if(file_exists(storage_path().'/blogPicture/'.$blog['image']) && !empty($blog['image']))
                            <img src="{{URL('').'/get_image/blogPicture/'.$blog['image']}}" class="img-fluid" alt="Blog Image">
                        @else
                            <img src="{{URL::asset('public/image/no_image.jpg')}}" class="img-fluid" alt="No image found">
                        @endif
                    </div>
                </a>
                <div class="post__text">
                    <h4 class="post__title">
                        <a href="{{url('').'/blog/'.$blog['id']}}">{{$blog['short_description']}}</a>
                    </h4>
                    <div class="post__meta-data">
                        <span class="post-date">{{date('F d, Y', strtotime($blog['created_at']))}}</span>
                    </div>
                    <div class="post__excerpt">
                        <p>{{substr($blog['long_description'], 0, 72) }}</p>
                    </div>
                    <a class="post__read-more" href="{{url('').'/blog/'.$blog['id']}}">More</a>
                </div>
            </article>
        @endforeach
    @else
    @endif
</div>

<?php
    $prev_page = $next_page = '' ;
    if (!empty($blogs['prev_page_url'])) {
        $prev_page = getPagefromUrl($blogs['prev_page_url']);

    }
    if (!empty($blogs['next_page_url'])) {
        $next_page = getPagefromUrl($blogs['next_page_url']);
    }
?>

@if(!empty($blogs['data']))
<nav class="blog-pagination" role="navigation" aria-label="Pagination">
    <a class="page-numbers prev {{!empty($prev_page)?'paginate_button pointer':'disabled not-allowed'}}" data-page="{{!empty($prev_page)?$prev_page:''}}">&lt;</a>
    @php 
        $start_from = getPageStartCount($blogs['current_page']);
    @endphp
    @for ($i = $start_from; $i < ($start_from+5); $i++)             
        @if($i<=$blogs['last_page'])             
            @if($i < ($blogs['current_page']+5) )
                <a class="pointer paginate_button" data-page="{{$i}}"><span aria-current="page" class="page-numbers <?if ($blogs['current_page']==$i) {echo "current not-allowed";}?>">{{$i}}</span></a>
            @endif
        @endif
    @endfor
    <a class="page-numbers next {{!empty($next_page)?'paginate_button pointer':'disabled not-allowed'}}" data-page="{{!empty($next_page)?$next_page:''}}">&gt;</a>		
</nav>
@endif

<script type="text/javascript">
    $('.paginate_button').click(function(){
        load_blod_data($('#search').val(),$(this).data('page'));
    });
</script>