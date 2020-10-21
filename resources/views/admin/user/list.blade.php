<div class="panel-heading">
    <div class="row">
        <div class="form-group">
            <div class="col-md-3">
                <label class="col-md-4 control-label" style="margin-top:8px;">Search:</label>
                <div class="col-md-8">
                    <input type="text" name="search" id="search" class="form-control input-xs" placeholder="Search" value="{{ Session::get('search_user') }}" onkeydown="if (event.keyCode == 13) { user_list_load(); }">
                </div>
            </div>
            <div class="col-md-2">
                <button  id='btn_search' type="button" class="btn btn-xs btn-primary" onclick="user_list_load()">Go</button>
                <button type="button" id='btn_show_all' class="btn btn-xs btn-default" onclick="ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_user')}}?reset=true')">Reset</button>
            </div>
            <div class="pull-right col-md-2">
                <label class="col-md-4 control-label" style="margin-top:8px;">Show:</label>
                <div class="col-md-8">
                    <select class="form-control simple_dropdown input-xs" id="show" name="show" onchange="user_list_load();">
                        @if(!empty(\Config::get('constants.PAGINATION_SLOTS')))
                            @foreach(\Config::get('constants.PAGINATION_SLOTS') as $ps)
                                <option {{ (Session::get('user_show') == $ps)?"selected":"" }}>{{$ps}}</option>
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
                    <th style="width: 10%;" class="text-primary">Profile Picture</th>
                    <th style="width: 20%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_user?field=users.name&sort={{Session::get("user_sort")=="asc"?"desc":"asc"}}')">
                            Name
                            @if(Session::get('user_field')=='users.name')
                                @if(Session::get('user_sort')=='asc')
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
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_user?field=users.email&sort={{Session::get("user_sort")=="asc"?"desc":"asc"}}')">
                            Email
                            @if(Session::get('user_field')=='users.email')
                                @if(Session::get('user_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 10%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_user?field=user_type&sort={{Session::get("user_sort")=="asc"?"desc":"asc"}}')">
                            User Type
                            @if(Session::get('user_field')=='user_type')
                                @if(Session::get('user_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 17%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_user?field=updated_at&sort={{Session::get("user_sort")=="asc"?"desc":"asc"}}')">
                            Updated At
                            @if(Session::get('user_field')=='updated_at')
                                @if(Session::get('user_sort')=='asc')
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
                @if(isset($users) && !empty($users))
                    @foreach($users as $user)
                        <tr>
                            <td>
                                @if(file_exists(storage_path().'/userProfilePicture/'.$user->profile_image) && !empty($user->profile_image))
                                    <a href="{{URL('').'/get_image/userProfilePicture/'.$user->profile_image}}" data-popup="lightbox">
                                        <img src="{{URL('').'/get_image/userProfilePicture/'.$user->profile_image}}" class="img-rounded img-preview">
                                    </a>
                                @else
                                    <a href="{{URL::asset('public/image/user_avatar.png')}}" data-popup="lightbox">
                                        <img src="{{URL::asset('public/image/user_avatar.png')}}" class="img-rounded img-preview">
                                    </a>
                                @endif
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->user_type}}</td>
                            <td>{{format_datetime_blade($user->updated_at)}}</td>
                            <td>
                                <ul class="icons-list text-center">
                                    <li><a href="{{url(\Config::get('constants.ADMIN_URL'))}}/user/{{$user->id}}/edit"><i class="icon-pencil7 text-primary"></i></a></li>
                                    <li><a href="javascript:void(0);" onclick="delete_conf_common('{{$user->id}}','User','users','User','{{url(\Config::get('constants.ADMIN_URL').'list_user')}}','URL');"><i class="icon-trash text-danger"></i></a></li>
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
            Showing {{$users->firstItem()}} to {{$users->lastItem()}} of {{$users->total()}} entries  
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            <div class="pull-right">{!! str_replace('/?','?',$users->render()) !!}</div>
        </div>
    </div>          
</div>

<style type="text/css">
    .img-preview{
        max-height: 40px !important;
    }
</style>