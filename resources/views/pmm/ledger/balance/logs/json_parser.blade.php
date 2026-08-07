@if (isset($data['data_obj']))
<div class="row">
    @foreach($data['data_obj'] as $key => $value)
    @if(is_array($value))
        @if(is_admin())
        <div class="col-md-6 mb-3">
            <div class="border rounded p-3 shadow-sm bg-light h-100">
                <h6 class="text-muted mb-1" style="font-size: 0.85rem; text-transform: capitalize;">
                    {{ str_replace('_', ' ', $key) }}
                </h6>
                <div style="font-size: 0.95rem; color: #212529;">
                    @if(is_array($value))
                        <pre class="bg-white p-2 rounded" style="font-size: 0.85rem;">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                    @elseif(is_null($value))
                        <em class="text-muted">NULL</em>
                    @else
                        {{ $value }}
                    @endif
                </div>
            </div>
        </div>
        @endif
    @else
    <div class="col-md-6 mb-3">
        <div class="border rounded p-3 shadow-sm bg-light h-100">
            <h6 class="text-muted mb-1" style="font-size: 0.85rem; text-transform: capitalize;">
                {{ str_replace('_', ' ', $key) }}
            </h6>
            <div style="font-size: 0.95rem; color: #212529;">
                @if(is_array($value))
                    <pre class="bg-white p-2 rounded" style="font-size: 0.85rem;">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                @elseif(is_null($value))
                    <em class="text-muted">NULL</em>
                @else
                    {{ $value }}
                @endif
            </div>
        </div>
    </div>
    @endif

    @endforeach
</div>

@endif
