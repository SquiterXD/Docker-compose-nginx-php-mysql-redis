@extends('layouts.app')

@section('title', 'Report Info')

@section('page-title')
  <h2><x-get-program-code url="/ir/settings/report-info" />: ข้อมูลรายงาน</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>IR</a>
    </li>
    <li class="breadcrumb-item">
        <a>Settings</a>
    </li>
    <li class="breadcrumb-item active">
      <strong><x-get-program-code url="/ir/settings/report-info" />: ข้อมูลรายงาน</strong>
    </li>
  </ol>
@stop

@section('page-title-action')

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>
                        Report
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $program)
                                    <tr>
                                        <td>
                                            {{ $program->program_code }} : {{ $program->description }}
                                        </td>
                                        <td>
                                            <a type="button" href="{{ route('ir.settings.report-info.show', $program->program_code) }}" class="btn btn-xs btn-info">
                                                info
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(isset($programs))
                        <div class="text-right">
                            {{ $programs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
