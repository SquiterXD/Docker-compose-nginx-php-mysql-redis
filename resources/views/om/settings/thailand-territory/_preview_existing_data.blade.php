<hr>
<h4 class="m-l-xs"><strong> Datas that already exit in database by thambon id from excel </strong></h4>
<div class="table-responsive">
    <table class="table table-striped text-left text-nowrap">
        <thead>
            <tr>
                <th class="text-center">
                    <div>Tambon ID</div>
                </th>
                <th>
                    <div>Tambon Thai</div>
                </th>
                <th>
                    <div>Tambon English</div>
                </th>
                <th>
                    <div>District Thai</div>
                </th>
                <th>
                    <div>District English</div>
                </th>
                <th>
                    <div>Province Thai</div>
                </th>
                <th>
                    <div>Province English</div>
                </th>
                <th>
                    <div>Region Thai</div>
                </th>
                <th>
                    <div>Region English</div>
                </th>
            </tr>
        </thead>
        <tbody>
            @if(count($thailandTerritories)>0)
            @foreach ($thailandTerritories ?? [] as $thailandTerritory)
            <tr>
                <td class="text-center">{{ $thailandTerritory->tambon_id }}</td>
                <td>{{ $thailandTerritory->tambon_thai }}</td>
                <td>{{ $thailandTerritory->tambon_eng }}</td>
                <td>{{ $thailandTerritory->district_thai }}</td>
                <td>{{ $thailandTerritory->district_eng }}</td>
                <td>{{ $thailandTerritory->province_thai }}</td>
                <td>{{ $thailandTerritory->province_eng }}</td>
                <td>{{ $thailandTerritory->region_thai }}</td>
                <td>{{ $thailandTerritory->region_eng }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No data record duplicate</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<hr>
