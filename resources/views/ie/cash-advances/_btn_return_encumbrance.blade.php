<form action="{{ route('ie.cash-advances.return_encumbrance') }}" method="POST"
    onsubmit="confirm('Are you really sure to return encumbrances?')"
    class="ml-auto mb-0 d-inline">
        @csrf
        <button class="btn btn-secondary" type="submit" class="btn btn-link btn-sm tw-text-red">
            <i class="fa fa-money"></i> Return Encumbrance
        </button>
</form>