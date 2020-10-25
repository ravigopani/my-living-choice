@php $cares_array = []; @endphp
@if(!empty($cares))
    @foreach($cares as $value)
        @php 
            $cares_array[] = $value['id'];
        @endphp
    @endforeach
@endif

@if(!empty($cities))
    @foreach($cities as $val1)

        @php $check = false; @endphp
        @if(!empty($properties))
            @foreach($properties as $val2)
                @if($val1['id'] == $val2['city_id'] && in_array($val2['care_id'], $cares_array))
                    @php $check = true; break; @endphp
                @endif
            @endforeach
        @endif

        @if($check)
            <div class="property_detail-single col-lg-12">
                <div class="propery_title col-lg-12">
                    <h2><a href="#">{{$val1['city']}}, {{$val1['state']}}</a></h2>
                </div>
                <ul>
                    @if(!empty($cares))
                        @foreach($cares as $val2)
                            @php $check = false; @endphp
                            @foreach($properties as $val3)
                                @if($val2['id'] == $val3['care_id'] && $val1['id'] == $val3['city_id'])
                                    @php $check = true; break; @endphp
                                @endif
                            @endforeach
                            @if($check)
                                <li><a href="{{url('').'/properties-list?care_id='.$val3['care_id'].'&city_id='.$val3['city_id']}}">Top {{$val2['care']}} in {{$val1['city']}}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        @endif
    @endforeach
@endif
