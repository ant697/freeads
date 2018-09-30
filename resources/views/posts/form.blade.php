<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Titre' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ $post->title or ''}}" required>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Content' }}</label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" required>{{ $post->content or ''}}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('picture1') ? 'has-error' : ''}}">
    <label for="picture1" class="control-label">{{ 'Picture1' }}</label>
    <input class="form-control" name="picture1" type="file" id="picture1" value="{{ $post->picture1 or ''}}" >
    {!! $errors->first('picture1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('picture2') ? 'has-error' : ''}}">
    <label for="picture2" class="control-label">{{ 'Picture2' }}</label>
    <input class="form-control" name="picture2" type="file" id="picture2" value="{{ $post->picture2 or ''}}" >
    {!! $errors->first('picture2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('picture3') ? 'has-error' : ''}}">
    <label for="picture3" class="control-label">{{ 'Picture3' }}</label>
    <input class="form-control" name="picture3" type="file" id="picture3" value="{{ $post->picture3 or ''}}" >
    {!! $errors->first('picture3', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('picture4') ? 'has-error' : ''}}">
    <label for="picture4" class="control-label">{{ 'Picture4' }}</label>
    <input class="form-control" name="picture4" type="file" id="picture4" value="{{ $post->picture4 or ''}}" >
    {!! $errors->first('picture4', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('picture5') ? 'has-error' : ''}}">
    <label for="picture5" class="control-label">{{ 'Picture5' }}</label>
    <input class="form-control" name="picture5" type="file" id="picture5" value="{{ $post->picture5 or ''}}" >
    {!! $errors->first('picture5', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    <label for="price" class="control-label">{{ 'Price' }}</label>
    <input class="form-control" name="price" type="number" id="price" value="{{ $post->price or ''}}" required>
    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('category') ? 'has-error' : ''}}">
    <label for="category" class="control-label">{{ 'Category' }}</label>
    <select name="category" class="form-control" id="category" >
    @foreach (json_decode('{"Multimedia":"Multimedia","Immobilier":"Immobilier","Vehicules":"Vehicules","Loisirs":"Loisirs","Materiel Pro":"Materiel Pro","Services":"Services","Maison":"Maison"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($post->category) && $post->category == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
    </select>
    {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
</div>
{{--<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">--}}
    {{--<label for="user_id" class="control-label">{{ 'User Id' }}</label>--}}
    {{--<input class="form-control" name="user_id" type="number" id="user_id" value="{{ $post->user_id or ''}}" >--}}
    {{--{!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}--}}
{{--</div>--}}


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
