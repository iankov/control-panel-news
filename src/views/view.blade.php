@extends('icp::master')

@section('title', 'View news')

@section('content')
    <style>
        div.p{margin: 1em 0;}
        .block_img{margin: 10px 0; text-align: center;}
        .block_img img{width: 700px;}
        .block_frame{margin: 10px 0; text-align: center;}
    </style>

    <div class="box">
        <div class="box-header">
            <form action="{{icp_route('news.delete', $article->id)}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="DELETE">

                <a href="{{icp_route('news')}}" class="btn btn-default">Cancel</a>
                <a href="{{icp_route('news.edit', $article->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                <button type="submit" onclick="return confirm('Are you sure you want to remove this page?')" class="btn btn-danger"><i class="fa fa-remove"></i>&nbsp;Delete</button>
            </form>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <h1>{{$article->title}}</h1>

            <div>
                {{$article->category->title or 'No Category'}}
            </div>
            {{$article->created_at->format('Y-m-d H:i:s')}}

            <div class="content">
                {!! $article->content !!}
            </div>

            <div class="author">
                {{$article->source}}
            </div>
        </div>
    </div>

@endsection