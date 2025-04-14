<div>
    <strong><i class="fa fa-archive mr-1"></i> Frame Code</strong>

    <p class="text-muted">
        {{ $order->frame_prescription->frame_code }}
    </p>

    <hr>

    <strong><i class="fa fa-user mr-1"></i> Gender</strong>

    <p class="text-muted">{{ $order->frame_prescription->frame_stock->hq_stock->gender }}
    </p>

    <hr>

    <strong><i class="fa  fa-industry mr-1"></i> Shape</strong>

    <p class="text-muted">
        {{ $order->frame_prescription->frame_stock->hq_stock->frame_shape->shape }}</p>

    <hr>

    <strong><i class="fa fa-creative-commons mr-1"></i> Color</strong>

    <p class="text-muted">
        {{ $order->frame_prescription->frame_stock->hq_stock->frame_color->color }}</p>

    <hr>

    <strong><i class="fa  fa-map-signs mr-1"></i> Workshop</strong>

    <p class="text-muted">{{ $order->workshop->name }}</p>
</div>