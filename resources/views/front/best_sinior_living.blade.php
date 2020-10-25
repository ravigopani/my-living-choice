@extends('front-layouts.master')
@section('content')
    <div id="best-senior-living" class="best_senior_living_page">
        <section class="browser_list_bar" style="background-image: url(public/front/images/top-living-choices4-1.png);">
                <div class="container">
                    <div class="row no-gutters text-center">
                        <div class="listing_title text-center col-lg-12">
                            <h1 class="heading-title">Top Senior Living Communities and Senior Care
                            </h1>
                        </div>
                        <div class="listing_description col-lg-12">
                            <p>We’ve compiled a list of the top living communities and care options for seniors in most of the major cities in the United States. Please choose your preferred living option below to explore our available lists.</p>
                        </div>
                        <div class="listing_form col-lg-12">
                            <form>
                                <label>Browse List</label>
                                <select id="top_listing_search" name="top_listing_search" class="designed toplist">
                                    <option value="" data-url="">Top List</option>
                                    @if(!empty($cares))
                                        @foreach($cares as $val)
                                            <option value="{{$val['id']}}">{{$val['care']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
        <section class="property_filter">
            <div class="container">
                <div class="row no-gutters" id="property_data">                    
                </div>
            </div>  
        </section>
    </div>

    <script type="text/javascript">
        $(function(){
            getSiniorLivingData();
            $('#top_listing_search').on('change',function(){
                getSiniorLivingData($(this).val());
            });
        });

        function getSiniorLivingData(care = ''){
            $.ajax({
                type: "POST", 
                url: BASE_URL+'get-property-by-care',  // no base url required filename is includes baseurl.
                data: {
                    care:care
                },
                success: function (data) {
                    if(data.status == 'error')
                    {
                        alert("Whoops, looks like something went wrong");
                    }
                    else
                    {
                        $('#property_data').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Whoops, looks like something went wrong");
                },
                complete:function(result){
                }
            });

        }

    </script>
@endsection