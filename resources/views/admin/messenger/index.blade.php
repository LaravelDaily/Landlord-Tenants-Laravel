@extends('admin.messenger.template')

@section('title', $title)

@section('messenger-content')
    <div class="row">
        <div class="col-md-12">
            <div class="list-group">
                @forelse($topics as $topic)
                    <div class="row list-group-item">
                        <div class="col-xs-4 col-md-4">
                            <a href="{{ route('admin.messenger.show', [$topic->id]) }}" class="{{$topic->unread()?'unread':false}}">
                                {{ $topic->otherPerson()->name }}
                            </a>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            <a href="{{ route('admin.messenger.show', [$topic->id]) }}" class="{{$topic->unread()?'unread':false}}">
                                {{ $topic->subject }}
                            </a>
                        </div>
                        <div class="col-xs-2 text-right">{{ $topic->sent_at->diffForHumans() }}</div>
                        <div class="col-xs-1 text-center">
                            {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('Are you sure?');",
                                    'route' => ['admin.messenger.destroy', $topic->id])) !!}
                            {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @empty
                    <div class="row list-group-item">
                        You have no messages.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .messenger-table tr:first-child td {
            border-top: 0 !important;
        }
        .unread {
            font-weight: bold;
            color:black;
        }
    </style>

@endsection