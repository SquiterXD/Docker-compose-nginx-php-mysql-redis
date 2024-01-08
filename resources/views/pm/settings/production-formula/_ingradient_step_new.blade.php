<div class="mt-5">
    <h4>ขั้นตอนการผลิต</h4>
    <div class="col-md-5 mt-2 mb-2">
        <label> <b>ประเภทสิ่งผลิต</b> </label>
        <label>{{ $header->routing ? $header->routing->routing_desc : '' }}</label>
    </div>
    <div class="col-md-5">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr> 
                        {{-- <th>ลำดับขั้นตอน</th> --}}
                        <th>ขั้นตอนการทำงาน</th>
                        <th>ชื่อขั้นตอนการทำงาน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wipSteps->where('routing_id', $header->routing_id)->sortBy('routingstep_no') as $wipStep)
                        <tr>
                            {{-- <td>{{ $wipStep->routingstep_no }}</td> --}}
                            <td>{{ $wipStep->oprn_class_desc }}</td>
                            <td>{{ $wipStep->oprn_desc }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>