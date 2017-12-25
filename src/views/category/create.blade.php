@extends('icp::master')

@section('title', 'Create news category')

@section('content')

    <div class="box box-warning">
        <form class="form-horizontal" id="form" action="{{icp_route('news.category.store')}}" method="post">
            {{csrf_field()}}
            @include('icp-news::category.form')
        </form>
    </div>

@endsection