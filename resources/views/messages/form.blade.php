<?php //die(var_dump('<pre>', '<h3>data</h3>', $data, '</pre>')) ?>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Titre' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ $message->title or ''}}" required>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Content' }}</label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" required>{{ $message->content or ''}}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sender_id') ? 'has-error' : ''}}">
    {{--<label for="sender_id" class="control-label">{{ 'Sender Id' }}</label>--}}
    <input class="form-control" name="sender_id" type="hidden" id="sender_id" value="{{ $message->sender_id or
    $data['receiver_id']}}" >
    {!! $errors->first('sender_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('receiver_id') ? 'has-error' : ''}}">
    {{--<label for="receiver_id" class="control-label">{{ 'Receiver Id' }}</label>--}}
    <input class="form-control" name="receiver_id" type="hidden" id="receiver_id" value="{{ $message->receiver_id or
    $data['sender_id']}}" >
    {!! $errors->first('receiver_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('receiver_id') ? 'has-error' : ''}}">
    {{--<label for="receiver_id" class="control-label">{{ 'Receiver Id' }}</label>--}}
    <input class="form-control" name="post_id" type="hidden" id="post_id" value="{{ $message->post_id or
    $data['post_id']}}" >
    {!! $errors->first('post_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
