<div class="table-responsive mini-scroll-bar" style="max-height: 250px; overflow: auto;">
    <table class="table">
        <thead>
            <tr>
                <th>
                    Seq
                </th>
                <th>
                    Position
                </th>
                <th>
                    Approver
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($hierarchy)
                @forelse ($hierarchy->namePositions as $namePosition)
                    <tr>
                        <td>
                            {{ $namePosition->seq }}
                        </td>
                        <td>
                            {{ optional($namePosition->position)->name }}
                        </td>
                        <td>
                            {{ optional(optional(optional($namePosition->position)->defaultApprover)->user)->name ?? 'No User' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100">
                            <h5>
                                ไม่มีข้อมูล
                            </h5>
                        </td>
                    </tr>
                @endforelse
            @else
                <tr>
                    <td class="text-center" colspan="100">
                        <h5>
                            ไม่มีข้อมูล
                        </h5>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>