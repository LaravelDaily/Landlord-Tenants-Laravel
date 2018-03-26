@extends('admin.messenger.template')

@section('title', 'New message')

@section('messenger-content')

    <div class="row">
        <div class="col-md-12">
            {{--{!! Form::open(['route' => ['admin.messenger.save'], 'method' => 'POST', 'novalidate', 'class' => 'stepperForm validate']) !!}--}}
            {!! Form::model($topic, ['method' => 'PUT', 'route' => ['admin.messenger.update', $topic->id]]) !!}

            @include('admin.messenger.form-partials.fields')

            {!! Form::submit('Reply', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@stop
