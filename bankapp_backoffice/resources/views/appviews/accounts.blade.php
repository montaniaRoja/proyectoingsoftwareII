@extends('layouts.app')
@section('title', 'Cuentas')
@section('content')
    @livewire('customer-accounts-component', ['customerId' => request()->customerId])
@endsection
