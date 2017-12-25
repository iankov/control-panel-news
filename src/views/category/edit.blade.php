@extends('icp::master')

@section('title', 'Edit news category')

@section('content')

    <div class="box box-warning">
        <form class="form-horizontal" id="form" action="{{icp_route('news.category.update', $category->id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">

            @include('icp-news::category.form')
        </form>
    </div>

@endsection