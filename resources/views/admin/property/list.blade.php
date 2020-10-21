<div class="panel-heading">
    <div class="row">
        <div class="form-group">
            <div class="col-md-3">
                <label class="col-md-4 control-label" style="margin-top:8px;">Search:</label>
                <div class="col-md-8">
                    <input type="text" name="search" id="search" class="form-control input-xs" placeholder="Search" value="{{ Session::get('search_property') }}" onkeydown="if (event.keyCode == 13) { property_list_load(); }">
                </div>
            </div>
            <div class="col-md-2">
                <button  id='btn_search' type="button" class="btn btn-xs btn-primary" onclick="property_list_load()">Go</button>
                <button type="button" id='btn_show_all' class="btn btn-xs btn-default" onclick="ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_property')}}?reset=true')">Reset</button>
            </div>
            <div class="pull-right col-md-2">
                <label class="col-md-4 control-label" style="margin-top:8px;">Show:</label>
                <div class="col-md-8">
                    <select class="form-control simple_dropdown input-xs" id="show" name="show" onchange="property_list_load();">
                        @if(!empty(\Config::get('constants.PAGINATION_SLOTS')))
                            @foreach(\Config::get('constants.PAGINATION_SLOTS') as $ps)
                                <option {{ (Session::get('property_show') == $ps)?"selected":"" }}>{{$ps}}</option>
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
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 10%;" class="text-primary">Logo</th>
                    <th style="width: 20%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_property?field=name&sort={{Session::get("property_sort")=="asc"?"desc":"asc"}}')">
                            Property Name
                            @if(Session::get('property_field')=='name')
                                @if(Session::get('property_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 20%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_property?field=address&sort={{Session::get("property_sort")=="asc"?"desc":"asc"}}')">
                            Property Location
                            @if(Session::get('property_field')=='address')
                                @if(Session::get('property_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 15%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_property?field=contact_email&sort={{Session::get("property_sort")=="asc"?"desc":"asc"}}')">
                            Contact info
                            @if(Session::get('property_field')=='contact_email')
                                @if(Session::get('property_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 15%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_property?field=website&sort={{Session::get("property_sort")=="asc"?"desc":"asc"}}')">
                            Website
                            @if(Session::get('property_field')=='website')
                                @if(Session::get('property_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 15%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_property?field=updated_at&sort={{Session::get("property_sort")=="asc"?"desc":"asc"}}')">
                            Updated At
                            @if(Session::get('property_field')=='updated_at')
                                @if(Session::get('property_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 5%;" class="text-primary text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($properties) && !empty($properties))
                    @foreach($properties as $property)
                        <tr>
                            <td>
                                @if(file_exists(storage_path().'/propertyImage/'.$property->logo_image) && !empty($property->logo_image))
                                    <a href="{{URL('').'/get_image/propertyImage/'.$property->logo_image}}" data-popup="lightbox">
                                        <img src="{{URL('').'/get_image/propertyImage/'.$property->logo_image}}" class="img-rounded img-preview">
                                    </a>
                                @else
                                    <a href="{{URL::asset('public/image/user_avatar.png')}}" data-popup="lightbox">
                                        <img src="{{URL::asset('public/image/user_avatar.png')}}" class="img-rounded img-preview">
                                    </a>
                                @endif
                            </td>
                            <td>{{$property->name}}</td>
                            <td>{{$property->address}}</td>
                            <td>
                                <i class="icon-mention"></i> : {{$property->contact_email}}<br/>
                                <i class="icon-mobile3"></i> : {{$property->phone_number}}
                            </td>
                            <td>{{$property->website}}</td>
                            <td>{{format_datetime_blade($property->updated_at)}}</td>
                            <td>
                                <ul class="icons-list text-center">
                                    <li><a href="{{url(\Config::get('constants.ADMIN_URL'))}}/property/{{$property->id}}/edit"><i class="icon-pencil7 text-primary"></i></a></li>
                                    <li><a href="javascript:void(0);" onclick="delete_conf_common('{{$property->id}}','Property','properties','Property','{{url(\Config::get('constants.ADMIN_URL').'list_property')}}','URL');"><i class="icon-trash text-danger"></i></a></li>
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
            Showing {{$properties->firstItem()}} to {{$properties->lastItem()}} of {{$properties->total()}} entries  
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            <div class="pull-right">{!! str_replace('/?','?',$properties->render()) !!}</div>
        </div>
    </div>          
</div>

<style type="text/css">
    .img-preview{
        max-height: 40px !important;
    }
</style>