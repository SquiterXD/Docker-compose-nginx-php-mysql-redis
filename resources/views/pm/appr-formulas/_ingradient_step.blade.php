<div class="mt-5">
    <h4>ขั้นตอนการผลิต</h4>
    <div class="col-md-5 mt-2 mb-2">
        <label> <b>ประเภทสิ่งผลิต</b> </label>
        <label>{{ $ingredient->routing->routing_no }}</label>
    </div>
    <div class="col-md-5">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr> 
                        <th>ลำดับขั้นตอน</th>
                        <th>ขั้นตอนการทำงาน</th>
                        <th>ชื่อขั้นตอนการทำงาน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wipSteps->where('routing_id', $ingredient->routing_id)->sortBy('routingstep_no') as $wipStep)
                        <tr>
                            <td>{{ $wipStep->routingstep_no }}</td>
                            <td>{{ $wipStep->oprn_class_desc }}</td>
                            <td>{{ $wipStep->oprn_desc }}</td>
                        </tr>
                        {{-- <tr>
                            <td style="background-color:{{ $ingredient->checkRouting($wipStep->oprn_id) ? '#C6C9C4' : '' }}">{{ $wipStep->routingstep_no }}</td>
                            <td style="background-color:{{ $ingredient->checkRouting($wipStep->oprn_id) ? '#C6C9C4' : '' }}">{{ $wipStep->oprn_class_desc }}</td>
                            <td style="background-color:{{ $ingredient->checkRouting($wipStep->oprn_id) ? '#C6C9C4' : '' }}">{{ $wipStep->oprn_desc }}</td>
                        </tr> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>