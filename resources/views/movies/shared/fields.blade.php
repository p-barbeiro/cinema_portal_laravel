@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title" width="md"
                       :readonly="$readonly || ($mode == 'edit')"
                       value="{{ old('title', $movie->title) }}"/>
        <x-field.input name="genre_code" label="Genre" width="md"
                       :readonly="$readonly"
                       value="{{ old('genre_code', $movie->genre->name) }}"/>
        <x-field.input name="year" label="Year" width="md"
                       :readonly="$readonly"
                       value="{{ old('year', $movie->year) }}"/>
        <x-field.input name="synopsis" label="Synopsis" :readonly="$readonly"
                       value="{{ old('synopsis', $movie->synopsis) }}"/>
        <iframe allowfullscreen="" height="315" src="{{$movie->getTrailerEmbedUrl()}}"
                width="420"></iframe>

        {{--            <x-field.input name="ECTS" label="Nº ECTS" width="sm" :readonly="$readonly"--}}
        {{--                            value="{{ old('ECTS', $course->ECTS) }}"/>--}}
        {{--        <x-field.input name="contact" label="Contact" :readonly="$readonly"--}}
        {{--                            value="{{ old('contact', $course->contact) }}"/>--}}
        {{--        <x-field.text-area name="objectives" label="Objectives" :readonly="$readonly"--}}
        {{--                            value="{{ old('objectives', $course->objectives) }}"/>--}}
        {{--        <x-field.text-area name="objectives_pt" label="Objectives (Portuguese)"--}}
        {{--                        :readonly="$readonly"--}}
        {{--                        value="{{ old('objectives_pt', $course->objectives_pt) }}"/>--}}
        {{--    </div>--}}
        {{--    <div class="pb-6">--}}
        {{--        <x-field.image--}}
        {{--            name="image_file"--}}
        {{--            label="Course Image"--}}
        {{--            width="md"--}}
        {{--            :readonly="$readonly"--}}
        {{--            deleteTitle="Delete Image"--}}
        {{--            :deleteAllow="($mode == 'edit') && ($course->imageExists)"--}}
        {{--            deleteForm="form_to_delete_image"--}}
        {{--            :imageUrl="$course->imageUrl"/>--}}
        {{--    </div>--}}
    </div>
</div>
