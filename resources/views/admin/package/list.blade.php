<div class="panel-heading">
    <div class="row">
        <div class="form-group">
            <div class="col-md-3">
                <label class="col-md-4 control-label" style="margin-top:8px;">Search:</label>
                <div class="col-md-8">
                    <input type="text" name="search" id="search" class="form-control input-xs" placeholder="Search" value="{{ Session::get('search_package') }}" onkeydown="if (event.keyCode == 13) { packages_list_load() }">
                </div>
            </div>
            <div class="col-md-2">
                <button  id='btn_search' type="button" class="btn btn-xs btn-primary" onclick="packages_list_load()">Go</button>
                <button type="button" id='btn_show_all' class="btn btn-xs btn-default" onclick="ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_package')}}?reset=true')">Reset</button>
            </div>
            <div class="pull-right col-md-2">
                <label class="col-md-4 control-label" style="margin-top:8px;">Show:</label>
                <div class="col-md-8">
                    <select class="form-control simple_dropdown input-xs" id="show" name="show" onchange="packages_list_load();">
                        @if(!empty(\Config::get('constants.PAGINATION_SLOTS')))
                            @foreach(\Config::get('constants.PAGINATION_SLOTS') as $ps)
                                <option {{ (Session::get('package_show') == $ps)?"selected":"" }}>{{$ps}}</option>
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
        <table class="table" id="table_package">
            <thead>
                <tr>
                    <th>
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_package?field=packages.package&sort={{Session::get("package_sort")=="asc"?"desc":"asc"}}')">
                            Package
                            @if(Session::get('package_field')=='packages.package')
                                @if(Session::get('package_sort')=='asc')
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
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_package?field=status&sort={{Session::get("package_sort")=="asc"?"desc":"asc"}}')">
                            Status
                            @if(Session::get('package_field')=='status')
                                @if(Session::get('package_sort')=='asc')
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
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_package?field=updated_at&sort={{Session::get("package_sort")=="asc"?"desc":"asc"}}')">
                            Updated At
                            @if(Session::get('package_field')=='updated_at')
                                @if(Session::get('package_sort')=='asc')
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
                @if(isset($packages) && !empty($packages))
                    @foreach($packages as $package)
                        <tr>
                            <td>{{$package->package}}</td>
                            <td class="text-center">
                                @if($package->status == 'A')
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">In Active</span>
                                @endif
                            </td>
                            <td class="text-center">{{format_datetime_blade($package->updated_at)}}</td>
                            <td>
                                <ul class="icons-list text-center">
                                    <li class="switchery-xs">
                                        <input type="checkbox" class="switch active_inactive_switch" onchange="active_inactive_common('{{$package->id}}','Package','packages','Package','{{url(\Config::get('constants.ADMIN_URL').'list_package')}}','URL');" {{$package->status == 'A' ? 'checked="checked"' : ''}}>
                                    </li>
                                    <li><a href="javascript:void(0);" onclick="edit_package_modal({{$package->id}});"><i class="icon-pencil7 text-primary"></i></a></li>
                                    <li><a href="javascript:void(0);" onclick="delete_conf_common('{{$package->id}}','Package','packages','Package','{{url(\Config::get('constants.ADMIN_URL').'list_package')}}','URL');"><i class="icon-trash text-danger"></i></a></li>
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
            Showing {{$packages->firstItem()}} to {{$packages->lastItem()}} of {{$packages->total()}} entries  
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            <div class="pull-right">{!! str_replace('/?','?',$packages->render()) !!}</div>
        </div>
    </div>          
</div>