@extends('layouts.app')
@section('titulo', 'Dashboard Aluno')
@section('conteudo')
    <h4>Bem-vindo, {{ auth()->user()->name }}!</h4>
    <p>Painel do Aluno</p>
@endsection