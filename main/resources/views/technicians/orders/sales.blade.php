<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Len Power</th>
                <th>Lens Type</th>
                <th>Lens Material</th>
                <th>Eye</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>
                        @if ($sale->lens->hq_lens)
                            {{ $sale->lens->hq_lens->power }}
                        @endif
                    </td>
                    <td>
                        @if ($sale->lens->hq_lens)
                            {{ $sale->lens->hq_lens->lens_type->type }}
                        @endif
                    </td>
                    <td>
                        @if ($sale->lens->hq_lens)
                            {{ $sale->lens->hq_lens->lens_material->title }}
                        @endif
                    </td>
                    <td>
                        @if ($sale->eye)
                            {{ $sale->eye }}
                        @else
                            <a href="javascript:void(0)" data-id="{{ $sale->id }}"
                                class="btn btn-sm btn-link addEyeBtn">
                                Add Eye
                            </a>
                        @endif
                    </td>
                    <td>
                        {{ $sale->quantity }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <p class="text-center text-muted">No Lenses Added For This Order</p>
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>
