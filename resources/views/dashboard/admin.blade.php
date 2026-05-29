@extends('layouts.admin')
@section('titulo', 'Dashboard Admin')
@section('conteudo')
    <h4>Bem-vindo, {{ auth()->user()->name }}!</h4>
    <p>Painel do Administrador</p>
@endsection