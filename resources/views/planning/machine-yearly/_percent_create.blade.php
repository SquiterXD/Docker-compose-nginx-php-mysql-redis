<div class="row col-12">
    <div class="col-md-2"></div>
    <div class="col-md-8" style="background: #f3f3f3; border-radius: 5px; padding: 0px;">
        <div class="progress-bar" style="width: {{ $percentCreate }}%; background-color: #05a675; height: 30px; border-radius: 5px;"
            role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
            กำลังสร้างประมาณกำลังการผลิตประจำปี {{ $search['budget_year'] }} : {{ number_format($percentCreate, 2) }}%
        </div>
    </div>
</div>