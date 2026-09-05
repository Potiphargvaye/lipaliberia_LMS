@extends('layouts.admin')

@section('title', ' LIPA Quiz Results')

@section('content')
    @livewire('admin.quizzes.results', ['quiz' => $quiz])
@endsection
