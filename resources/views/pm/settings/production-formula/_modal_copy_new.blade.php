<div class="modal fade" id="copy_{{ $header->recipe_id }}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('pm.settings.production-formula.copy', $header->recipe_id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">คัดลอกสูตร</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-left">
                    <copy-production-formula
                        :items="{{ json_encode($items) }}"
                        :oprns="{{ json_encode($oprns) }}"
                        :machine-types="{{ json_encode($machineTypes) }}"
                        :wip-steps="{{ json_encode($wipSteps) }}"
                        :default-value="{{ json_encode($header)}}"
                        :wip-step-headers="{{ json_encode($wipStepHeaders) }}"
                        :oprn-class="{{ json_encode($oprnClass) }}"
                        :formula-types="{{ json_encode($formulaTypes) }}"
                        :period-years="{{ json_encode($periodYears) }}"
                    >
                    </copy-production-formula>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"> <i class="fa fa-times"></i> ยกเลิก</button>
                    <button class="btn btn-primary btn-sm"> <i class="fa fa-save"></i> บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

