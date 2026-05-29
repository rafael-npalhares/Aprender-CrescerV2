@extends('layouts.app')
@section('titulo', 'Dashboard Professor')
@section('conteudo')
    <h4>Bem-vindo, {{ auth()->user()->name }}!</h4>
    <p>Painel do Professor</p>
@endsection