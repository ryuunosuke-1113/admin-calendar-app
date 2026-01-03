@extends('layouts.admin')

@section('content')
  <h1>Calendar</h1>
  <div id="calendar"></div>
@endsection

@push('scripts')
  @vite('resources/js/admin-calendar.js')
@endpush
