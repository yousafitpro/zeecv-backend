
<style>
    .info-box {
        border: dotted 2px gray;
        padding: 10px;
    }

    .btn-secondary {
        font-weight: bold;
    }
    .btn-secondary:hover {
        font-size: 20px;
    }
</style>

<div class="card">
    <div class="card-header">
        <h3>User Logs & Orders</h3>
    </div>
    <div class="card-body">
        <table id="notesTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th width="50%">Note</th>
                    <th>Type</th>
                    <th>Duration</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notes as $index => $note)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $note->user->name ?? '—' }}</td>
                        <td>
                            {{ Str::limit($note->note, 50, '...') }}
                            @if(strlen($note->note) > 50)
                                <button type="button"
                                    class="btn btn-sm btn-primary view-note-btn"
                                    data-toggle="modal"
                                    data-target="#viewNoteModal"
                                    data-note="{{ $note->note }}">
                                    View
                                </button>
                            @endif
                        </td>
                        <td>{{ $note->type }}</td>
                        <td>
                            @if($note->call_start && $note->call_end)
                                @php
                                    $start = \Carbon\Carbon::parse($note->call_start);
                                    $end = \Carbon\Carbon::parse($note->call_end);
                                    echo $end->diff($start)->format('%H:%I:%S');
                                @endphp
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $note->created_at->format('d M Y, h:i A') }}</td>
                        <td>{{ $note->updated_at->format('d M Y, h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- View Note Modal -->
<div class="modal fade" id="viewNoteModal" tabindex="-1" role="dialog" aria-labelledby="viewNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewNoteModalLabel">Note Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="noteContent" style="white-space: pre-wrap;"></p>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('view-note-btn')) {
            const noteText = e.target.getAttribute('data-note') || 'No note available';
            document.getElementById('noteContent').textContent = noteText;
        }
    });
});
</script>
