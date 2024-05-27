@php
    $disableStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div>
    <label for="inputCode">Code</label>
    <input type="text" name="code" id="inputCode" {{ $disableStr }}
           value="{{$genre->code}}">
</div>
<div>
    <label for="inputName">Name</label>
    <input type="text" name="name" id="inputName" {{ $disableStr }} value="{{$genre->name}}">
</div>
<div>
    <label for="inputCustom">Custom</label>
    <input type="text" name="custom" id="inputCustom" {{ $disableStr }}
           value="{{$genre->custom}}">
</div>
