<div class="panel-heading">
    <div class="row">
        <div class="form-group">
            <div class="col-md-3">
                <label class="col-md-4 control-label" style="margin-top:8px;">Search:</label>
                <div class="col-md-8">
                    <input type="text" name="search" id="search" class="form-control input-xs" placeholder="Search" value="{{ Session::get('search_city') }}" onkeydown="if (event.keyCode == 13) { cities_list_load() }">
                </div>
            </div>
            <div class="col-md-2">
                <button  id='btn_search' type="button" class="btn btn-xs btn-primary" onclick="cities_list_load()">Go</button>
                <button type="button" id='btn_show_all' class="btn btn-xs btn-default" onclick="ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_city')}}?reset=true')">Reset</button>
            </div>
            <div class="pull-right col-md-2">
                <label class="col-md-4 control-label" style="margin-top:8px;">Show:</label>
                <div class="col-md-8">
                    <select class="form-control simple_dropdown input-xs" id="show" name="show" onchange="cities_list_load();">
                        @if(!empty(\Config::get('constants.PAGINATION_SLOTS')))
                            @foreach(\Config::get('constants.PAGINATION_SLOTS') as $ps)
                                <option {{ (Session::get('city_show') == $ps)?"selected":"" }}>{{$ps}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel-body">
    <div class="table-responsive">
        <table class="table" id="table_city">
            <thead>
                <tr>
                    <th>
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_city?field=cities.city&sort={{Session::get("city_sort")=="asc"?"desc":"asc"}}')">
                            City
                            @if(Session::get('city_field')=='cities.city')
                                @if(Session::get('city_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 10%;" class="text-center">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_city?field=status&sort={{Session::get("city_sort")=="asc"?"desc":"asc"}}')">
                            Status
                            @if(Session::get('city_field')=='status')
                                @if(Session::get('city_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_city?field=updated_at&sort={{Session::get("city_sort")=="asc"?"desc":"asc"}}')">
                            Updated At
                            @if(Session::get('city_field')=='updated_at')
                                @if(Session::get('city_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 13%;" class="text-primary text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($cities) && !empty($cities))
                    @foreach($cities as $city)
                        <tr>
                            <td>{{$city->city}}</td>
                            <td class="text-center">
                                @if($city->status == 'A')
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">In Active</span>
                                @endif
                            </td>
                            <td class="text-center">{{format_datetime_blade($city->updated_at)}}</td>
                            <td>
                                <ul class="icons-list text-center">
                                    <li class="switchery-xs">
                                        <input type="checkbox" class="switch active_inactive_switch" onchange="active_inactive_common('{{$city->id}}','City','cities','City','{{url(\Config::get('constants.ADMIN_URL').'list_city')}}','URL');" {{$city->status == 'A' ? 'checked="checked"' : ''}}>
                                    </li>
                                    <li><a href="javascript:void(0);" onclick="edit_city_modal({{$city->id}});"><i class="icon-pencil7 text-primary"></i></a></li>
                                    <li><a href="javascript:void(0);" onclick="delete_conf_common('{{$city->id}}','City','cities','City','{{url(\Config::get('constants.ADMIN_URL').'list_city')}}','URL');"><i class="icon-trash text-danger"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="4">No Data found.</td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

    <div class="datatable-footer">
        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
            Showing {{$cities->firstItem()}} to {{$cities->lastItem()}} of {{$cities->total()}} entries  
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            <div class="pull-right">{!! str_replace('/?','?',$cities->render()) !!}</div>
        </div>
    </div>          
</div>