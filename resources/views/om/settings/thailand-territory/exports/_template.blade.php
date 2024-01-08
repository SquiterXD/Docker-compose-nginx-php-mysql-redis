<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table>
        <thead>
            <tr style="border-bottom: 1px solid #000000;">
                <th style="font-weight:bold;">TERRITORY_FILE_NAME</th>
                <th style="font-weight:bold;">TambonID</th>
                <th style="font-weight:bold;">TambonThai</th>
                <th style="font-weight:bold;">TambonEng</th>
                <th style="font-weight:bold;">TambonThaiShort</th>
                <th style="font-weight:bold;">TambonEngShort</th>
                <th style="font-weight:bold;">PostCodeMain</th>
                <th style="font-weight:bold;">PostCodeAll</th>
                <th style="font-weight:bold;">PostalCodeRemark</th>
                <th style="font-weight:bold;">DistrictID</th>
                <th style="font-weight:bold;">DistrictThai</th>
                <th style="font-weight:bold;">DistrictEng</th>
                <th style="font-weight:bold;">DistrictThaiShort</th>
                <th style="font-weight:bold;">DistrictEngShort</th>
                <th style="font-weight:bold;">ProvinceID</th>
                <th style="font-weight:bold;">ProvinceThai</th>
                <th style="font-weight:bold;">ProvinceEng</th>
                <th style="font-weight:bold;">RegionID</th>
                <th style="font-weight:bold;">RegionThai</th>
                <th style="font-weight:bold;">RegionEng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($thailandTerritories as $thailandTerritory)
            <tr>
                <td>{{ $thailandTerritory->territory_file_name }}</td>
                <td>{{ $thailandTerritory->tambon_id }}</td>
                <td>{{ $thailandTerritory->tambon_thai }}</td>
                <td>{{ $thailandTerritory->tambon_eng }}</td>
                <td>{{ $thailandTerritory->tambon_thai_short }}</td>
                <td>{{ $thailandTerritory->tambon_eng_short }}</td>
                <td>{{ $thailandTerritory->postcode_main }}</td>
                <td>{{ $thailandTerritory->postcode_all }}</td>
                <td>{{ $thailandTerritory->postal_code_remark }}</td>
                <td>{{ $thailandTerritory->district_id }}</td>
                <td>{{ $thailandTerritory->district_thai }}</td>
                <td>{{ $thailandTerritory->district_eng }}</td>
                <td>{{ $thailandTerritory->district_thai_short }}</td>
                <td>{{ $thailandTerritory->district_eng_short }}</td>
                <td>{{ $thailandTerritory->province_id }}</td>
                <td>{{ $thailandTerritory->province_thai }}</td>
                <td>{{ $thailandTerritory->province_eng }}</td>
                <td>{{ $thailandTerritory->region_id }}</td>
                <td>{{ $thailandTerritory->region_thai }}</td>
                <td>{{ $thailandTerritory->region_eng }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
