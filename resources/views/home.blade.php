@extends('parts.template')

@section('title')
	Home
@endsection


@section('content')
	<div class="page-loader">
		<div class="page-loader__spinner">
			<svg viewBox="25 25 50 50">
				<circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
			</svg>
		</div>
	</div>

	<font color="#b2b2b2" size="5"><b>DASHBOARD</b></font><br>
	<br>
	<!--
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Index</li>
        </ol>
    -->

@endsection
