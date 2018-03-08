@if ($ticket->status == 'open')
<div class="progress mt-1 bg-light">
    <div class="progress-bar bg-danger" style="width:33.3%">
        Open
    </div>
</div>
@elseif ($ticket->status == 'assigned')
<div class="progress mt-1 bg-light">
    <div class="progress-bar bg-warning" style="width:66.6%">
        Assigned
    </div>
</div>
@elseif ($ticket->status == 'closed_success')
<div class="progress mt-1 bg-light">
    <div class="progress-bar bg-success" style="width:100%">
        Finished
    </div>
</div>
@elseif ($ticket->status == 'closed_error')
<div class="progress mt-1 bg-light">
    <div class="progress-bar bg-danger" style="width:100%">
        Closed/Failed
    </div>
</div>
@endif