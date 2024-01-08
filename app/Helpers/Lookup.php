<?php

use App\Models\Lookup\Program;
use App\Models\Lookup\PmLoss;
use App\Models\Lookup\JobType;
use App\Models\Lookup\MaterialRequestStatus;
use App\Models\Lookup\WipStep;
use App\Models\Lookup\FormulaType;
use App\Models\Lookup\IssueType;
use App\Models\Lookup\EmployeeType;
use App\Models\Lookup\EstimateMaterialStatus;
use App\Models\Lookup\ObjectiveofMaterialRequest;
use App\Models\Lookup\RequestMaterialInternalStatus;
use App\Models\Lookup\BatchStatus;
use App\Models\Lookup\MachineGroupf;
use App\Models\Lookup\MachineGroups;
use App\Models\Lookup\MachineType;
use App\Models\Lookup\ManufactureStap;
use App\Models\Lookup\MachineReason;
use App\Models\Lookup\ManufactureType;
use App\Models\Lookup\FeederName;
use App\Models\Lookup\BrakedMachine;
use App\Models\Lookup\CustomerTypeDomestic;
use App\Models\Lookup\CustomerTypeExport;
use App\Models\Lookup\Incoterms;
use App\Models\Lookup\ProductTypeDomestic;
use App\Models\Lookup\ProductTypeExport;
use App\Models\Lookup\PaymentMethodDomestic;
use App\Models\Lookup\PaymentMethodExport;
use App\Models\Lookup\QuotaGroup;
use App\Models\Lookup\BlendType;
use App\Models\Lookup\BomStatus;
use App\Models\Lookup\LeafFormula;
use App\Models\Lookup\SimulationType;
use App\Models\Lookup\BlendFlavour;
use App\Models\Lookup\TestType;
use App\Models\Lookup\ResultSeverityCode;
use App\Models\Lookup\QualityTestingProcessforCigarette;
use App\Models\Lookup\QualityTestingListforCigarette;

use App\Models\Lookup\ValueSetup;
use App\Models\Lookup\ProgramColumn;


function checkProgram($programCode)
{
    //ใช้สำหรับการเรียก model program

    if ($programCode == 'PMS0001') {

        return $lookups = PmLoss::all();

    } elseif ($programCode == 'PMS0002') {

        return $lookups = JobType::all();

    } elseif ($programCode == 'PMS0003') {

        return $lookups = MaterialRequestStatus::all();

    } elseif ($programCode == 'PMS0004') {

        return $lookups = WipStep::all();

    } elseif ($programCode == 'PMS0005') {

        return $lookups = FormulaType::all();

    } elseif ($programCode == 'PMS0006') {

        return $lookups = IssueType::all();
        
    } elseif ($programCode == 'PMS0007') {

        return $lookups = EmployeeType::all();

    } elseif ($programCode == 'PMS0008') {

        return $lookups = EstimateMaterialStatus::all();

    } elseif ($programCode == 'PMS0009') {

        return $lookups = ObjectiveofMaterialRequest::all();

    } elseif ($programCode == 'PMS0010') {

        return $lookups = RequestMaterialInternalStatus::all();

    } elseif ($programCode == 'PMS0011') {

        return $lookups = BatchStatus::all();

    } elseif ($programCode == 'PMS0012') {

        return $lookups = MachineGroupf::all();

    } elseif ($programCode == 'PMS0013') {

        return $lookups = MachineGroups::all();

    } elseif ($programCode == 'PMS0014' || $programCode == 'EMS0003') {

        return $lookups = MachineType::all();

    } elseif ($programCode == 'PMS0015') {

        return $lookups = ManufactureStap::all();

    } elseif ($programCode == 'PMS0016') {

        return $lookups = MachineReason::all();
        
    } elseif ($programCode == 'PMS0017') {

        return $lookups = ManufactureType::all();

    } elseif ($programCode == 'PMS0018') {

        return $lookups = FeederName::all();

    } elseif ($programCode == 'PMS0019') {

        return $lookups = BrakedMachine::all();

    } elseif ($programCode == 'OMS0001') {

        return $lookups = CustomerTypeDomestic::all();

    } elseif ($programCode == 'OMS0002') {

        return $lookups = CustomerTypeExport::all();

    } elseif ($programCode == 'OMS0003') {

        return $lookups = Incoterms::all();

    } elseif ($programCode == 'OMS0004') {

        return $lookups = ProductTypeDomestic::all();

    } elseif ($programCode == 'OMS0005') {

        return $lookups = ProductTypeExport::all();

    } elseif ($programCode == 'OMS0006') {

        return $lookups = PaymentMethodDomestic::all();
        
    } elseif ($programCode == 'OMS0007') {

        return $lookups = PaymentMethodExport::all();

    } elseif ($programCode == 'OMS0008') {

        return $lookups = QuotaGroup::all();

    } elseif ($programCode == 'PDS0001') {

        return $lookups = BlendType::all();

    } elseif ($programCode == 'PDS0002') {

        return $lookups = BomStatus::all();

    } elseif ($programCode == 'PDS0003') {

        return $lookups = SimulationType::all();

    } elseif ($programCode == 'PDS0004') {

        return $lookups = BlendFlavour::all();

    } elseif ($programCode == 'PDS0005') {

        return $lookups = LeafFormula::all();

    } elseif ($programCode == 'QMS0001') {

        return $lookups = TestType::all();

    } elseif ($programCode == 'QMS0002') {

        return $lookups = ResultSeverityCode::all();

    } elseif ($programCode == 'QMS0003') {

        return $lookups = QualityTestingProcessforCigarette::all();

    } elseif ($programCode == 'QMS0004') {

        return $lookups = QualityTestingListforCigarette::all();

    }
    

}

function getNewProgram($programCode)
{
    //ใช้สำหรับการเรียก model program

    if ($programCode == 'PMS0001') {

        return $lookup = new PmLoss;

    } elseif ($programCode == 'PMS0002') {

        return $lookup = new JobType;

    } elseif ($programCode == 'PMS0003') {

        return $lookup = new MaterialRequestStatus;

    } elseif ($programCode == 'PMS0004') {

        return $lookup = new WipStep;

    } elseif ($programCode == 'PMS0005') {

        return $lookups = new FormulaType;

    } elseif ($programCode == 'PMS0006') {

        return $lookups = new IssueType;
        
    } elseif ($programCode == 'PMS0007') {

        return $lookups = new EmployeeType;

    } elseif ($programCode == 'PMS0008') {

        return $lookups = new EstimateMaterialStatus;

    } elseif ($programCode == 'PMS0009') {

        return $lookups = new ObjectiveofMaterialRequest;

    } elseif ($programCode == 'PMS0010') {

        return $lookups = new RequestMaterialInternalStatus;

    } elseif ($programCode == 'PMS0011') {

        return $lookups = new BatchStatus;

    } elseif ($programCode == 'PMS0012') {

        return $lookups = new MachineGroupf;

    } elseif ($programCode == 'PMS0013') {

        return $lookups = new MachineGroups;

    } elseif ($programCode == 'PMS0014' || $programCode == 'EMS0003') {

        return $lookups = new MachineType;

    } elseif ($programCode == 'PMS0015') {

        return $lookups = new ManufactureStap;

    } elseif ($programCode == 'PMS0016') {

        return $lookups = new MachineReason;
        
    } elseif ($programCode == 'PMS0017') {

        return $lookups = new ManufactureType;

    } elseif ($programCode == 'PMS0018') {

        return $lookups = new FeederName;

    } elseif ($programCode == 'PMS0019') {

        return $lookups = new BrakedMachine;

    } elseif ($programCode == 'OMS0001') {

        return $lookups = new CustomerTypeDomestic;

    } elseif ($programCode == 'OMS0002') {

        return $lookups = new CustomerTypeExport;

    } elseif ($programCode == 'OMS0003') {

        return $lookups = new Incoterms;

    } elseif ($programCode == 'OMS0004') {

        return $lookups = new ProductTypeDomestic;

    } elseif ($programCode == 'OMS0005') {

        return $lookups = new ProductTypeExport;

    } elseif ($programCode == 'OMS0006') {

        return $lookups = new PaymentMethodDomestic;
        
    } elseif ($programCode == 'OMS0007') {

        return $lookups = new PaymentMethodExport;

    } elseif ($programCode == 'OMS0008') {

        return $lookups = new QuotaGroup;

    } elseif ($programCode == 'PDS0001') {

        return $lookups = new BlendType;

    } elseif ($programCode == 'PDS0002') {

        return $lookups = new BomStatus;

    } elseif ($programCode == 'PDS0003') {

        return $lookups = new SimulationType;

    } elseif ($programCode == 'PDS0004') {

        return $lookups = new BlendFlavour;

    } elseif ($programCode == 'PDS0005') {

        return $lookups = new LeafFormula;

    } elseif ($programCode == 'QMS0001') {

        return $lookups = new TestType;

    } elseif ($programCode == 'QMS0002') {

        return $lookups = new ResultSeverityCode;

    } elseif ($programCode == 'QMS0003') {

        return $lookups = new QualityTestingProcessforCigarette;

    } elseif ($programCode == 'QMS0004') {

        return $lookups = new QualityTestingListforCigarette;

    }
    
}

function getProgramTest($programCode, $lookupCode)
{
    //ใช้สำหรับการเรียก model program

    if ($programCode == 'PMS0001') {

        return $lookups = PmLoss::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0002') {

        return $lookups = JobType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0003') {

        return $lookups = MaterialRequestStatus::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0004') {

        return $lookups = WipStep::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0005') {

        return $lookups = FormulaType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0006') {

        return $lookups = IssueType::where('lookup_code', $lookupCode)->first();
        
    } elseif ($programCode == 'PMS0007') {

        return $lookups = EmployeeType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0008') {

        return $lookups = EstimateMaterialStatus::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0009') {

        return $lookups = ObjectiveofMaterialRequest::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0010') {

        return $lookups = RequestMaterialInternalStatus::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0011') {

        return $lookups = BatchStatus::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0012') {

        return $lookups = MachineGroupf::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0013') {

        return $lookups = MachineGroups::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0014' || $programCode == 'EMS0003') {

        return $lookups = MachineType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0015') {

        return $lookups = ManufactureStap::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0016') {

        return $lookups = MachineReason::where('lookup_code', $lookupCode)->first();
        
    } elseif ($programCode == 'PMS0017') {

        return $lookups = ManufactureType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0018') {

        return $lookups = FeederName::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PMS0019') {

        return $lookups = BrakedMachine::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'OMS0001') {

        return $lookups = CustomerTypeDomestic::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'OMS0002') {

        return $lookups = CustomerTypeExport::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'OMS0003') {

        return $lookups = Incoterms::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'OMS0004') {

        return $lookups = ProductTypeDomestic::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'OMS0005') {

        return $lookups = ProductTypeExport::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'OMS0006') {

        return $lookups = PaymentMethodDomestic::where('lookup_code', $lookupCode)->first();
        
    } elseif ($programCode == 'OMS0007') {

        return $lookups = PaymentMethodExport::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'OMS0008') {

        return $lookups = QuotaGroup::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PDS0001') {

        return $lookups = BlendType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PDS0002') {

        return $lookups = BomStatus::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PDS0003') {

        return $lookups = SimulationType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PDS0004') {

        return $lookups = BlendFlavour::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'PDS0005') {

        return $lookups = LeafFormula::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'QMS0001') {

        return $lookups = TestType::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'QMS0002') {

        return $lookups = ResultSeverityCode::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'QMS0003') {

        return $lookups = QualityTestingProcessforCigarette::where('lookup_code', $lookupCode)->first();

    } elseif ($programCode == 'QMS0004') {

        return $lookups = QualityTestingListforCigarette::where('lookup_code', $lookupCode)->first();

    }
    
}

function getProgramMenu()
{
    return $programs = Program::orderBy('program_code', 'asc')->get();
}

function getDuplicate($program, $request, $lookup)
{
    $user        = auth()->user();
    $userOrgCode = $user->organization ? $user->organization->organization_code : '';
    // dd($program, $request->all(), $lookup);

    if ($program->program_code == 'PPS0002') {
        if ($request->ATTRIBUTE2) {
            if ($lookup) {
                $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('attribute2', 'Y')
                                ->first();
            } else {
                $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('attribute2', 'Y')
                                ->first();
            }

            return $checkDuplicate;

        } else {
            return null;
        }

        
        // dd('getDuplicate', $program, $lookup, $checkDuplicate);

    }

    if ($program->program_code == 'PPS0008' || $program->program_code == 'PPS0009') {
        // dd($program, $request->all(), $lookup);
        if ($lookup) {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', '!=', $lookup->lookup_code)
                            ->where('attribute1', $request->ATTRIBUTE1)
                            ->first();
        } else {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('attribute1', $request->ATTRIBUTE1)
                            ->first();
        }

        return $checkDuplicate;
    }
    
    if ($program->program_code == 'PMS0003' || $program->program_code == 'PMS0005' || $program->program_code == 'PMS0008' || 
        $program->program_code == 'PMS0009' || $program->program_code == 'PMS0011' || $program->program_code == 'PMS0024' || 
        $program->program_code == 'PMS0025' || $program->program_code == 'PMS0026' || $program->program_code == 'PMS0034') {

        if ($lookup) {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', '!=', $lookup->lookup_code)
                            ->where('description', $request->DESCRIPTION)
                            ->first();
        } else {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('description', $request->DESCRIPTION)
                            ->first();
        }

        return $checkDuplicate;
    }

    if ($program->program_code == 'PMS0001') {
        if ($lookup) {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', '!=', $lookup->lookup_code)
                            ->where('description', $request->DESCRIPTION)
                            ->where('attribute1', $lookup->attribute1)
                            ->first();
        } else {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('description', $request->DESCRIPTION)
                            ->where('attribute1', $userOrgCode)
                            ->first();
        }

        return $checkDuplicate;

    }

    if ($program->program_code == 'PMS0012' || $program->program_code == 'PMS0013') {

        if ($request->TAG) {
            if ($lookup) {
                $checkDuplicateTag = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('tag', $request->TAG)
                                ->where('attribute4', $lookup->attribute4)
                                ->first();
            } else {
                // dd('11');
                $checkDuplicateTag = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('tag', $request->TAG)
                                ->where('attribute4', $userOrgCode)
                                ->first();
            }
        } 
        if ($request->ATTRIBUTE1) {
            if ($lookup) {
                $checkDuplicateAttribute = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('attribute1', $request->ATTRIBUTE1)
                                ->where('attribute4', $lookup->attribute4)
                                ->first();
            } else {
                // dd('11');
                $checkDuplicateAttribute = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('attribute1', $request->ATTRIBUTE1)
                                ->where('attribute4', $userOrgCode)
                                ->first();
            }
        }
        if ($checkDuplicateTag || $checkDuplicateAttribute) {
            return true;
        } else {
            return false;
        }
        

        // return $checkDuplicate;
        
    }

    if ($program->program_code == 'PMS0027') {
        if ($lookup) {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', '!=', $lookup->lookup_code)
                            ->where('description', $request->DESCRIPTION)
                            ->where('attribute1', $lookup->attribute1)
                            ->first();
        } else {
            $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('description', $request->DESCRIPTION)
                            ->where('attribute1', $userOrgCode)
                            ->first();
        }

        return $checkDuplicate;

    }

    // EAM
    if ($program->program_code == 'EMS0004') {
        if ($request->DESCRIPTION) {
            if ($lookup) {
                $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('description', $request->DESCRIPTION)
                                ->first();
            } else {
                $checkDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('description', $request->DESCRIPTION)
                                ->first();
            }

            return $checkDuplicate;

        } else {
            return null;
        }
    }
}

function checkColumnEnable($programCode, $lookup, $columnName)
{
    $column = ProgramColumn::where('program_code', $programCode)
                            ->where('column_name', $columnName)
                            ->first();
    if ($column->enable_flag == 'N') {
        return true;
    } else {
        return false;
    }
    dd('getDataValue', $programCode, $lookup, $columnName, $column, $column->enable_flag);
}