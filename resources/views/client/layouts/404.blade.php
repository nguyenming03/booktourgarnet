@extends('client.layouts.app')
@section('title')
    404 Not Found
@endsection
@section('style')
    <style>
        /* @import url('https://fonts.googleapis.com/css?family=Cabin+Sketch'); */



        h1 {
            font-family: 'Cabin Sketch', cursive;
            font-size: 3em;
            text-align: center;
            opacity: .8;
            order: 1;
        }

        h1 small {
            display: block;
        }

        .site {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            flex-direction: column;
            margin: 0 auto;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            margin-top: 120px;
            margin-bottom: 120px;
        }
    </style>
@endsection

@section('content')
    <div class="site">
        <div class="sketch">
            <div class="bee-sketch red"></div>
            <div class="bee-sketch blue"></div>
        </div>

        <h1>404:
            <small>Không tồn tại</small>
        </h1>
    </div>
@endsection
