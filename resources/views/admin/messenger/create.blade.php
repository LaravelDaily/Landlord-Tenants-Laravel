@extends('admin.messenger.template')

@section('title', 'New message')

@section('messenger-content')

    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => ['admin.messenger.store'], 'method' => 'POST', 'novalidate', 'class' => 'stepperForm validate']) !!}

            @include('admin.messenger.form-partials.fields')

            {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@stop
