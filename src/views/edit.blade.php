@extends('icp::master')

@section('title', 'Edit news')

@section('content')

    <div class="box box-warning">
        <form class="form-horizontal" id="form" action="{{icp_route('news.update', $article->id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="return" value="0" />

            @include('icp-news::form')
        </form>
    </div>

@endsection