@extends('front-layouts.master')

@section('content') 
<div id="city_property_list" class="property_list_page">
    <section class="city_titlebar" style="background-image: url(public/front/images/hero_topseniorliving-scaled.jpg);">
        <div class="container">
            <div class="row no-gutters justify-content-center">
                <div class="title_area">
                    <div class="city_bar_title">
                        <h1 class="heading-title">
                            @if(!empty($care['care']) && !empty($city['city']))
                                {{$care['care']}} in {{$city['city']}}
                            @else
                                Property
                            @endif
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="property_list_main">
        <div class="container" id="property-data">
            
         </div>
    </section>
</div>

<script type="text/javascript">
    $(function(){
        load_property_data();
    });


    function load_property_data(page = 1)
    {
        $(".loading").show();
        $.ajax({
            type: "POST", 
            url: BASE_URL+'properties-list-data',  // no base url required filename is includes baseurl.
            data: {
                care_id: '{{@$care['id']}}',
                city_id: '{{@$city['id']}}',
                page: page
            },
            success: function (data) {
                if(data.status == 'error')
                {
                    show_notification(data.status,data.message);
                }
                else
                {
                    $('#property-data').html(data);
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