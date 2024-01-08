{!! Form::open(['route' => ['ir.settings.product-groups.index'] , "method" => "get" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
    
    <group-products-search-componies    :policy-set-headers = "{{ json_encode($policySetHeaders) }}"
                                        :asset-groups = "{{ json_encode($assetGroups) }}"
                                        :search = "{{ json_encode($search) }}"
                                        :group-products = "{{ json_encode($groupProducts) }}"
                                        :desc-field-searches = "{{ json_encode($descFieldSearches) }}">
    </group-products-search-componies>

    <div class="row clearfix text-right">
        <div class="col" style="margin-top: 15px; margin-right: 5px;">
            <button class="{{ $btnTrans['search']['class']. ' btn-sm' }}" type="submit"> 
                <i class="{{ $btnTrans['search']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['search']['text'] }} 
            </button>
            <a  type="button" 
                href="{{ route('ir.settings.product-groups.index') }}" 
                class="btn btn-warning btn-sm" 
                type="button"> 
                <i class="fa fa-undo"></i> รีเซ็ต  
            </a>
        </div>
    </div>

{!! Form::close() !!}