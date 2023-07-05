<div class="my-2 shadow text-white bg-dark p-1" id="connection_{{ $connection->id }}">
    <div class="d-flex justify-content-between">
        <table class="ms-1">
            <td class="align-middle">{{ $connection->name }}</td>
            <td class="align-middle"> -</td>
            <td class="align-middle">{{ $connection->email }}</td>
            <td class="align-middle">
        </table>
        <div>
            <button
                onclick="getConnectionsInCommon({{ \Illuminate\Support\Facades\Auth::id() }}, {{ $connection->id }})"
                style="width: 220px"
                id="get_connections_in_common_{{ $connection->id }}"
                class="btn btn-primary {{ $connection->connectionInCommon->count() == 0 ? 'disabled':'' }}"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapse_{{ $connection->id }}"
                aria-expanded="false"
                aria-controls="collapseExample">
                Connections in common ({{ $connection->connectionInCommon->count() }})
            </button>
            <button id="create_request_btn_{{ $connection->id }}" class="btn btn-danger me-1"
                    onclick="removeConnection({{ \Illuminate\Support\Facades\Auth::id() }}, {{ $connection->id }})"
            >Remove Connection
            </button>
        </div>

    </div>
    <div class="collapse" id="collapse_{{ $connection->id }}">

        <div id="content_{{ $connection->id }}" class="p-2">
            {{-- Display data here --}}
        </div>
        <div id="connections_in_common_skeletons_{{ $connection->id }}">
            {{-- Paste the loading skeletons here via Jquery before the ajax to get the connections in common --}}
            @for ($i = 0; $i < 10; $i++)
                <x-skeleton/>
            @endfor
        </div>
        <div class="d-flex justify-content-center w-100 py-2">
            <button
                onclick="getMoreConnectionsInCommon({{ \Illuminate\Support\Facades\Auth::id() }}, {{ $connection->id }})"
                data-skipCounter="10"
                class="btn btn-sm btn-primary d-none"
                id="load_more_connections_in_common_{{ $connection->id }}">Load
                more
            </button>
        </div>
    </div>
</div>
