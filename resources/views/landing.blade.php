@extends('layouts.landing')

@section('title', 'Pondok Pesantren RTQ Kawali — Beranda')

@section('content')
    @include('partials.navbar')
    @include('partials.hero')
    @include('partials.about')
    @include('partials.programs')
    @include('partials.facilities')
    @include('partials.footer')
@endsection
