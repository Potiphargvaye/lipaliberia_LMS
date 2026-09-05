@extends('layouts.admin')

@section('title', 'LIPA Assignment Submissions')

@section('content')
    @livewire('admin.assignments.submissions', ['assignment' => $assignment])
@endsection
