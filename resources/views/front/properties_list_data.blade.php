<div class="row no-gutters">
    <div class="property_wrapper col-lg-12">

        @if(!empty($properties))
            @foreach($properties['data'] as $val)
                <div class="property-list">
                    <div class="first-section clearfix">
                        <div class="property-list-box">
                            <a href="https://www.mylivingchoice.com/propertyheritage-specialty-care">
                                <img src="https://www.mylivingchoice.com/wp-content/uploads/2020/08/Care-Initiatives-Heritage.jpg" alt="logo">
                            </a>
                        </div>
                        <div class="property-info">
                            <div class="property-headerinfo clearfix">
                                <div class="p-inner-right">
                                    <h2 class="property-title dd">
                                        <a href="https://www.mylivingchoice.com/property/heritage-specialty-care/ ">{{$val['name']}}</a>
                                    </h2>
                                    <div class="desc">
                                        @php
                                            $cares_str = '';
                                            if(!empty($val['cares'])){
                                                foreach ($val['cares'] as $val1) {
                                                    $cares_str .= $cares[$val1['care_id']].', ';
                                                }
                                            }
                                        @endphp
                                        {{$cares_str}}
                                    </div>
                                </div>
                                <div class="website-link">
                                    <a class="green-btn " href="https://www.mylivingchoice.com/property/heritage-specialty-care/ ">View Profile</a>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex2">
                                    <ul class="gallery_container">
                                        <li>
                                            <div class="mlc_gallery_container">
                                                <span class="mlc_gallery_close">
                                                    <a data-fancybox="gallery" href="https://www.mylivingchoice.com/wp-content/uploads/2020/08/Heritage-R2H.2.jpg" rel="gallery7937">
                                                        <img src="https://www.mylivingchoice.com/wp-content/uploads/2020/08/Heritage-R2H.2-150x150.jpg">
                                                    </a>
                                                </span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="mlc_gallery_container">
                                                <span class="mlc_gallery_close">
                                                    <a data-fancybox="gallery" href="https://www.mylivingchoice.com/wp-content/uploads/2020/08/HeritageRehabEntrance.jpg" rel="gallery7937">
                                                        <img src="https://www.mylivingchoice.com/wp-content/uploads/2020/08/HeritageRehabEntrance-150x150.jpg">
                                                    </a>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-container clearfix">
                        <div class="pacakge-section"></div>
                        <div class="visit-website">
                            <div class="package_name">
                                @if($val['package'] != 'No Plan')
                                    MyLivingChoice <b>{{$val['package']}}</b> Partner
                                @endif
                            </div>
                            <a class="details-btn" href="https://www.careinitiatives.org/heritage-specialty-care/" target="_blank">Visit Website</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        @endif
    </div>

    <?php
        $prev_page = $next_page = '' ;
        if (!empty($properties['prev_page_url'])) {
            $prev_page = getPagefromUrl($properties['prev_page_url']);

        }
        if (!empty($properties['next_page_url'])) {
            $next_page = getPagefromUrl($properties['next_page_url']);
        }
    ?>

    <div class="property-pagination col-lg-12">
        <a class="page-numbers prev {{!empty($prev_page)?'paginate_button pointer':'disabled not-allowed'}}" data-page="{{!empty($prev_page)?$prev_page:''}}">« Previous</a>
        @php 
            $start_from = getPageStartCount($properties['current_page']);
        @endphp
        @for ($i = $start_from; $i < ($start_from+5); $i++)             
        @if($i<=$properties['last_page'])             
            @if($i < ($properties['current_page']+5) )
                    @if($properties['current_page']==$i)
                        <a><span aria-current="page" class="page-numbers current disabled not-allowed" data-page="{{$i}}">{{$i}}</span></a>
                    @else
                        <a class="page-numbers paginate_button pointer" data-page="{{$i}}">{{$i}}</a>
                    @endif
                @endif
            @endif
        @endfor
        <a class="page-numbers next {{!empty($next_page)?'paginate_button pointer':'disabled not-allowed'}}" data-page="{{!empty($next_page)?$next_page:''}}">Next »</a>
    </div>
</div>

<script type="text/javascript">
    $('.paginate_button').click(function(){
        load_property_data($(this).data('page'));
    });
</script>