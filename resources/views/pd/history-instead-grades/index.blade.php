@extends('layouts.app')

@section('title', 'บันทึกประวัติแทนเกรดใบยา')

@section('page-title')
  <x-get-page-title menu="" url="/pd/history-instead-grades" />
@stop

@section('content')
  <history-instead-grades-header  :medicinal-leaf-types-h = "{{ json_encode($medicinalLeafTypesH) }}"
                                  :trans-date = "{{ json_encode($transDate) }}"
                                  :trans-btn = "{{ json_encode($transBtn) }}"
                                  :current-date-t-h = "{{ json_encode($currentDateTH) }}">
    
  </history-instead-grades-header>
@endsection