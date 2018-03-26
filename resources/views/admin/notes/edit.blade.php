@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.notes.title')</h3>
    
    {!! Form::model($note, ['method' => 'PUT', 'route' => ['admin.notes.update', $note->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('property_id', trans('global.notes.fields.property').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('property_id', $properties, old('property_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('property_id'))
                        <p class="help-block">
                            {{ $errors->first('property_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('note_text', trans('global.notes.fields.note-text').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('note_text', old('note_text'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('note_text'))
                        <p class="help-block">
                            {{ $errors->first('note_text') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

