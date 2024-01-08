<table style="border: 1px solid black;">
    <tr>
        <td style="border: 1px solid black;">1</td>
        <td style="border: 1px solid black;">2</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;">Choooomm</td>
        <td style="border: 1px solid black;">Yooook</td>
    </tr>
</table>

 <table>
    @foreach ($tests as $item)
        <tr>
            <td>{{ $item->item_code }}</td>
            <td>{{ $item->item_description }}</td>
        </tr>
    @endforeach
 </table>