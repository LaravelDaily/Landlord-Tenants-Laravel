@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.documents.title')</h3>
    
    {!! Form::model($document, ['method' => 'PUT', 'route' => ['admin.documents.update', $document->id], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('property_id', trans('global.documents.fields.property').'*', ['class' => 'control-label']) !!}
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
                    {!! Form::label('document', trans('global.documents.fields.document').'*', ['class' => 'control-label']) !!}
                    {!! Form::hidden('document', old('document')) !!}
                    @if ($document->document)
                        <a href="{{ asset(env('UPLOAD_PATH').'/' . $document->document) }}" target="_blank">Download file</a>
                    @endif
                    {!! Form::file('document', ['class' => 'form-control']) !!}
                    {!! Form::hidden('document_max_size', 2) !!}
                    <p class="help-block"></p>
                    @if($errors->has('document'))
                        <p class="help-block">
                            {{ $errors->first('document') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('global.documents.fields.name').'', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

