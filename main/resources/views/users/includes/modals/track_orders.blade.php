<div class="modal fade" id="trackOrderModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Track Order
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Status</th>
                            <th>Workshop</th>
                            <th>TAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->order_track as $track)
                            <tr>
                                <td>
                                    {{ date('d-m-Y', strtotime($track->track_date)) }}
                                </td>
                                <td>
                                    {{ $track->user->first_name }} {{ $track->user->last_name }}
                                </td>
                                <td>
                                    {{ $track->track_status }}
                                </td>
                                <td>
                                    {{ $track->workshop->name }}
                                </td>
                                <td>
                                    {{ $track->tat }}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->