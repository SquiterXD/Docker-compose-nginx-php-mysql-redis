@extends('layouts.app')

@section('title', 'เคลมประกันภัย')

@section('page-title')
    <x-get-page-title menu="" url="/ir/claim-accounting" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> ข้อมูลรายละเอียดการเคลมประกันภัย (Detail Claim Insurance) </h5>
                </div>
                <div class="ibox-content pt-1">
                    <claim-accounting-form
                        :claim="{{ json_encode($claimHeader) }}"
                        :claim-policy-group="{{ json_encode($claimPolicyGroup) }}"
                        :claim-apply-detail="{{ json_encode($claimApplyDetail) }}"
                        :claim-apply-comp="{{ json_encode($claimApplyComp) }}"
                        :policy-groups="{{ json_encode($policyGroups) }}"
                        :policy-group-sets="{{ json_encode($policyGroupSets) }}"
                        :companies="{{ json_encode($companies) }}"
                        :file-insurance="{{ json_encode($fileInsurance) }}"
                        :file-approve="{{ json_encode($fileApprove) }}"
                        :file-all="{{ json_encode($fileAll) }}"
                        :user="{{ json_encode($user) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :profile="{{ json_encode($profile) }}"
                        :purl="{{ json_encode($url) }}">
                    </claim-accounting-form>
                </div>
            </div>
        </div>
    </div>
@endsection