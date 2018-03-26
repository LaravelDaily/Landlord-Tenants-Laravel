<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">

            <div class="col-xs-12 form-group">
                {!! Form::label('receiver', 'Recipient', ['class' => 'control-label']) !!}

                @if(isset($users))
                    {!! Form::select('receiver', $users, old('receiver'), ['class' => 'form-control select2']) !!}
                @elseif(isset($user))
                    {!! Form::text('receiver', old('receiver', $user ? $user : ''), ['class' => 'form-control', 'disabled']) !!}
                @endif
            </div>

            <div class="col-xs-12 form-group">
                {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}

                @if(!isset($user))
                    {!! Form::text('subject', old('subject', isset($topic) ? $topic->subject : ''), ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('subject', old('subject', isset($topic) ? $topic->subject : ''), ['class' => 'form-control', 'disabled']) !!}
                @endif

                @if ($errors->has('subject'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-xs-12 form-group">
                {!! Form::label('content', 'Message', ['class' => 'control-label']) !!}
                {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('content'))
                    <p class="help-block">
                        {{ $errors->first('content') }}
                    </p>
                @endif
            </div>


        </div>
    </div>
</div>
@section('javascript')
    @parent

@stop