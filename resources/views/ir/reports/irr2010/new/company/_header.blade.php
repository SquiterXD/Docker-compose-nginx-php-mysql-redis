
    <div class="row">
        <div  style=" width:20%;"> <b> Program Code : {{$program->program_code}}</b> </div>
        <div style="width:60%;" align="center"> <b> การยาสูบแห่งประเทศไทย </b> </div>
        <div style="width:10%;" align="right"> <b> วันที่ : </b> </div>
        <div style="width:10%;" align="left"> <b> {{ ' '. parseToDateTh(now()) }} </b> </div>
    </div>
    <div class="row">
        <div  style=" width:20%;"> <b> </b> </div>
        <div style="width:60%;" align="center"> <b> ชุดที่: {{ $policySetDes }}</b> </div>
        <div style="width:10%;" align="right"> <b> เวลา : </b> </div>
        <div style="width:10%;" align="left"> <b> {{ date('H:i', strtotime(now())) }} </b> </div>
    </div>
    <div class="row">
        <div  style=" width:20%;"> <b> </b> </div>
        <div style="width:60%;" align="center"> <b> {{$program->description}}</b> </div>
        <div style="width:10%;" align="right"> <b> หน้า :  </b> </div>
        <div style="width:10%;" align="left">
            <b>
                <div style="content: counter(page);">
                </div>
            </b>
        </div>
    </div>

    <div class="row">
        <div  style=" width:20%;"> <b> </b> </div>
        <div style="width:60%;" align="center"> <b>
            {{ $companies->where('company_id', $companyId)->first()->company_name }}
        </b> </div>
        <div style="width:10%;" align="right"> <b>  </b> </div>
        <div style="width:10%;" align="left">
            <b>
            </b>
        </div>
    </div>


