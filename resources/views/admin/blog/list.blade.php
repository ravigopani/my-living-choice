<div class="panel-heading">
    <div class="row">
        <div class="form-group">
            <div class="col-md-3">
                <label class="col-md-4 control-label" style="margin-top:8px;">Search:</label>
                <div class="col-md-8">
                    <input type="text" name="search" id="search" class="form-control input-xs" placeholder="Search" value="{{ Session::get('search_blog') }}" onkeydown="if (event.keyCode == 13) { blog_list_load(); }">
                </div>
            </div>
            <div class="col-md-2">
                <button  id='btn_search' type="button" class="btn btn-xs btn-primary" onclick="blog_list_load()">Go</button>
                <button type="button" id='btn_show_all' class="btn btn-xs btn-default" onclick="ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_blog')}}?reset=true')">Reset</button>
            </div>
            <div class="pull-right col-md-2">
                <label class="col-md-4 control-label" style="margin-top:8px;">Show:</label>
                <div class="col-md-8">
                    <select class="form-control simple_dropdown input-xs" id="show" name="show" onchange="blog_list_load();">
                        @if(!empty(\Config::get('constants.PAGINATION_SLOTS')))
                            @foreach(\Config::get('constants.PAGINATION_SLOTS') as $ps)
                                <option {{ (Session::get('blog_show') == $ps)?"selected":"" }}>{{$ps}}</option>
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
                    <th style="width: 10%;" class="text-primary">BLog pic.</th>
                    <th style="width: 25%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_blog?field=blogs.title&sort={{Session::get("blog_sort")=="asc"?"desc":"asc"}}')">
                            Title
                            @if(Session::get('blog_field')=='blogs.title')
                                @if(Session::get('blog_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 40%;">
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_blog?field=blogs.short_description&sort={{Session::get("blog_sort")=="asc"?"desc":"asc"}}')">
                            Description
                            @if(Session::get('blog_field')=='blogs.short_description')
                                @if(Session::get('blog_sort')=='asc')
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
                        <a href="javascript:void(0)" onClick="javascript:ajaxLoad('list_blog?field=updated_at&sort={{Session::get("blog_sort")=="asc"?"desc":"asc"}}')">
                            Updated At
                            @if(Session::get('blog_field')=='updated_at')
                                @if(Session::get('blog_sort')=='asc')
                                    <i class="icon-arrow-up5"></i>
                                @else
                                    <i class="icon-arrow-down5"></i>
                                @endif
                            @else
                                <i class="icon-menu-open"></i>
                            @endif
                        </a>
                    </th>
                    <th style="width: 10%;" class="text-primary text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($blogs) && !empty($blogs))
                    @foreach($blogs as $blog)
                        <tr>
                            <td>
                                @if(file_exists(storage_path().'/blogPicture/'.$blog->image) && !empty($blog->image))
                                    <a href="{{URL('').'/get_image/blogPicture/'.$blog->image}}" data-popup="lightbox">
                                        <img src="{{URL('').'/get_image/blogPicture/'.$blog->image}}" class="img-rounded img-preview">
                                    </a>
                                @else
                                    <a href="{{URL::asset('public/image/no_image.jpg')}}" data-popup="lightbox">
                                        <img src="{{URL::asset('public/image/no_image.jpg')}}" class="img-rounded img-preview">
                                    </a>
                                @endif
                            </td>
                            <td>{{$blog->title}}</td>
                            <td>{{$blog->short_description}}</td>
                            <td>{{format_datetime_blade($blog->updated_at)}}</td>
                            <td>
                                <ul class="icons-list text-center">
                                    <li><a href="{{url(\Config::get('constants.ADMIN_URL'))}}/blog/{{$blog->id}}/edit"><i class="icon-pencil7 text-primary"></i></a></li>
                                    <li><a href="javascript:void(0);" onclick="delete_conf_common('{{$blog->id}}','Blog','blogs','Blog','{{url(\Config::get('constants.ADMIN_URL').'list_blog')}}','URL');"><i class="icon-trash text-danger"></i></a></li>
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
            Showing {{$blogs->firstItem()}} to {{$blogs->lastItem()}} of {{$blogs->total()}} entries  
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            <div class="pull-right">{!! str_replace('/?','?',$blogs->render()) !!}</div>
        </div>
    </div>          
</div>

<style type="text/css">
    .img-preview{
        max-height: 40px !important;
    }
</style>