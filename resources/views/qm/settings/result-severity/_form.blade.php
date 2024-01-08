<table class="table">
    <thead>
        <th class="text-center">ลำดับที่</th>
        <th class="text-center">ระดับความรุนแรง</th>
        <th class="text-center">รายละเอียด ระดับความรุนแรง</th>
        <th class="text-center">วิธีการป้องกันและกำจัดมอดยาสูบ</th>
    </thead>
    <tbody>
        @foreach ($lookups as $lookup)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $lookup->meaning }}</td>
                <td class="text-center">{{ $lookup->description }}</td>
                {{-- <td>
                    <input type="text" class="form-control" value="{{$lookup->meaning}}" disabled>
                </td>
                <td>
                    <input type="text" class="form-control" value="{{$lookup->description}}" disabled>
                </td> --}}
                <td>
                    {{-- 'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_folmula_qty]' --}}
                    <input type="text" class="form-control" name="{{$lookup->lookup}}[attribute10]" value="{{$lookup->attribute10}}">
                    {{-- <input type="text" class="form-control" name="'attribute10[{{$lookup->lookup}}]'" value="{{$lookup->attribute10}}"> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>