<div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card shadow  text-white bg-dark">
      <div class="card-header">Coding Challenge - Network connections</div>
      <div class="card-body">
        <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
          <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn" onclick="changeTab('suggestions')">
              Suggestions
              (<span id="suggestion_count">{{ getSuggestionCount() }}</span>)</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn" onclick="changeTab('sent_requests')">
              Sent Requests
              (<span id="sent_request_count">{{ getRequestsToCount() }}</span>)</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn" onclick="changeTab('received_requests')">
              Received Requests
              (<span id="received_request_count">{{ getRequestsFromCount() }}</span>)</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
            <label class="btn btn-outline-primary" for="btnradio4" id="get_connections_btn" onclick="changeTab('connections')">
                Connections
                (<span id="connection_count">{{ getConnectionCount() }}</span>)</label>
        </div>
        <hr>
        <div id="content">
          {{-- Display data here --}}
        </div>



        <div id="skeleton" class="d-none">
          @for ($i = 0; $i < 10; $i++)
            <x-skeleton />
          @endfor
        </div>

{{--        <span class="fw-bold">"Load more"-Button</span>--}}
        <div class="d-flex justify-content-center mt-2 py-3 d-none" id="load_more_btn_parent">
          <button class="btn btn-primary" onclick="loadMore()" id="load_more_btn" >Load more</button>
        </div>
      </div>
    </div>
  </div>
</div>


