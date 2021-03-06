
@extends('layout')

@section('title')
    User: {{ $user->email }}
@stop

@section('content')
<h2>Authorship</h2>
@foreach($categories as $category)
    <h3>{{{ $category->name }}}</h3>
    <ul>
        @foreach($category->submissions()->by($user->id)->get() as $submission)
            <li>{{link_to_route('submission.show', e($submission->title),
            array($submission->id)) }}</li>
            @endforeach
    </ul>
    {{ link_to_route('category.submission', 'New submission', array($category->id, $user->id)) }}
    @endforeach

<h2>Reviewership</h2>

<h3>Keywords</h3>
<ul>
    @foreach($user->keywords as $keyword)
        <li>{{{ $keyword->keyword }}}</li>
    @endforeach
</ul>


@foreach($categories as $category)

    <h3>{{{ $category->name }}}</h3>
    {{ $user->categoriesReviewing->contains($category->id)
        ? ''
        : link_to_action(
            'CategoryCon@getVolunteerToReview',
            'Volunteer to review for this category',
            array($category->id,  $user->id)) }}

    @foreach($user->reviews as $review)
        @if($review->submission->category->id == $category->id)
        <div>
            <h4>({{$review->submission->id}})
                {{{$review->submission->title}}}</h4>
            <ul>
                @foreach($review->submission->documents as $document)
                <li>{{link_to_action('DocumentCon@download', e($document->name), array($user->id, $document->id))}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    @endforeach

@endforeach


@stop
