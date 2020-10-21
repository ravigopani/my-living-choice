<div class="navbar navbar-inverse bwhite">
	<div class="navbar-header">
		<a class="navbar-brand p0" href="{{url('/admin/')}}" title="Admin Home">
			<img src="{{URL::asset('public/image/My-Living-Choice-Logo.png')}}" alt="Site Logo" class="m0 w100 h100">
		</a>

		<ul class="nav navbar-nav pull-right visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
		</ul>
	</div>

	<div class="navbar-collapse collapse" id="navbar-mobile">
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="{{url('/')}}" title="Go to website" class="cblack">
					<i class="icon-display4"></i>&nbsp;&nbsp; Go to website
					{{-- <span class="visible-xs-inline-block position-right"> Go to website</span> --}}
				</a>
			</li>

			@yield('navbar-link')
			
		</ul>
	</div>
</div>