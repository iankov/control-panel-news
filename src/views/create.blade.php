@extends('icp::master')

@section('title', 'Create news')

@section('content')

    <div class="box box-warning">
        <form class="form-horizontal" id="form" action="{{icp_route('news.store')}}" method="post">
            {{csrf_field()}}
            @include('icp-news::form')
        </form>
    </div>

@endsection