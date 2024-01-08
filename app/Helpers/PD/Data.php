<?php
    function historyDescriptions()
    {
        return (object)[
            "description"       => 'Header',
            "remark_formula"    => 'Header',
            "raw_material_num"  => 'วัตถุดิบ',
            "actual_qty"        => 'วัตถุดิบ',
            "actual_uom"        => 'วัตถุดิบ',
            "mix_desc"          => 'วิธีผสม',
            "instruction_desc"  => "วิธีใช้",
            "field_desc"        =>  (object)[
                                        "description"       => 'รายละเอียด',
                                        "remark_formula"    => 'หมายเหตุ',
                                        "raw_material_num"  => 'รหัสวัตถุดิบ',
                                        "actual_qty"        => 'ปริมาณที่ใช้',
                                        "actual_uom"        => 'หน่วย',
                                        "mix_desc"          => 'รายละเอียด',
                                        "instruction_desc"  => "รายละเอียด",
                                    ]
        ];
    }


    function findOrg($orgCode)
    {
        return \DB::connection('oracle')->table('mtl_parameters')
            ->where('organization_code', $orgCode)
            ->first();
    }
