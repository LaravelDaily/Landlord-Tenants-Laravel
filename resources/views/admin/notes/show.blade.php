@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.notes.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.notes.fields.property')</th>
                            <td field-key='property'>{{ $note->property->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.notes.fields.user')</th>
                            <td field-key='user'>{{ $note->user->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.notes.fields.note-text')</th>
                            <td field-key='note_text'>{!! $note->note_text !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.notes.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
