var skeletonId = 'skeleton';
var contentId = 'content';
var loadMoreId = 'load_more_btn_parent';
var tab = 'suggestions';
var skipCounter = 0;
var takeAmount = 10;


function getRequests(mode) {
    $('#' + skeletonId).removeClass('d-none');

    var form = ajaxForm([
        ["skipCounter", skipCounter],
        ["takeAmount", takeAmount],
        ['mode', mode]
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_requests', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#' + skeletonId).addClass('d-none');
        skipCounter += 10;

        $('#' + contentId).html(response['content']);

        if (response['count'] <= 10)
            $('#' + loadMoreId).addClass('d-none');
        else
            $('#' + loadMoreId).removeClass('d-none');
    }
}

function getMoreRequests(mode) {
    // Optional: Depends on how you handle the "Load more"-Functionality
    $('#' + skeletonId).removeClass('d-none');

    var form = ajaxForm([
        ["skipCounter", skipCounter],
        ["takeAmount", takeAmount],
        ['mode', mode]
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_requests', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#' + skeletonId).addClass('d-none');
        skipCounter += 10;

        $('#' + contentId).append(response['content']);

        if (skipCounter >= response['count'])
            $('#' + loadMoreId).addClass('d-none');
    }
}

function getConnections() {
    $('#' + skeletonId).removeClass('d-none');

    var form = ajaxForm([
        ["skipCounter", skipCounter],
        ["takeAmount", takeAmount],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_connections', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#' + skeletonId).addClass('d-none');
        skipCounter += 10;
        console.log(response);
        $('#' + contentId).html(response['content']);

        if (response['count'] <= 10)
            $('#' + loadMoreId).addClass('d-none');
        else
            $('#' + loadMoreId).removeClass('d-none');
    }
}

function getMoreConnections() {
    // Optional: Depends on how you handle the "Load more"-Functionality
    $('#' + skeletonId).removeClass('d-none');

    var form = ajaxForm([
        ["skipCounter", skipCounter],
        ["takeAmount", takeAmount],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_connections', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#' + skeletonId).addClass('d-none');
        skipCounter += 10;

        $('#' + contentId).append(response['content']);

        if (skipCounter >= response['count'])
            $('#' + loadMoreId).addClass('d-none');
    }
}

function getConnectionsInCommon(userId, connectionId) {
    $('#connections_in_common_skeletons_' + connectionId).removeClass('d-none');
    $('#content_' + connectionId).addClass('d-none');

    var form = ajaxForm([
        ["skipCounter", 0],
        ["takeAmount", takeAmount],
        ["userId", userId],
        ["connectionId", connectionId],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_connection_in_common', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#content_' + connectionId).html(response['content']);

        $('#connections_in_common_skeletons_' + connectionId).addClass('d-none');
        $('#content_' + connectionId).removeClass('d-none');

        if (response['count'] <= 10)
            $('#load_more_connections_in_common_' + connectionId).addClass('d-none');
        else
            $('#load_more_connections_in_common_' + connectionId).removeClass('d-none');
    }
}

function getMoreConnectionsInCommon(userId, connectionId) {
    // Optional: Depends on how you handle the "Load more"-Functionality
    $('#connections_in_common_skeletons_' + connectionId).removeClass('d-none');

    var skipCounter =  parseInt($('#load_more_connections_in_common_' + connectionId).attr('data-skipCounter'));
    var form = ajaxForm([
        ["skipCounter", skipCounter],
        ["takeAmount", takeAmount],
        ["userId", userId],
        ["connectionId", connectionId],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_connection_in_common', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#connections_in_common_skeletons_' + connectionId).addClass('d-none');

        skipCounter += 10;
        $('#load_more_connections_in_common_' + connectionId).attr('data-skipCounter',skipCounter)

        $('#content_' + connectionId).append(response['content']);

        if (skipCounter >= response['count'])
            $('#load_more_connections_in_common_' + connectionId).addClass('d-none');
    }
}

function getSuggestions() {

    $('#' + skeletonId).removeClass('d-none');

    var form = ajaxForm([
        ["skipCounter", skipCounter],
        ["takeAmount", takeAmount],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_suggestions', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#' + skeletonId).addClass('d-none');
        skipCounter += 10;

        $('#' + contentId).html(response['content']);

        if (response['count'] <= 10)
            $('#' + loadMoreId).addClass('d-none');
        else
            $('#' + loadMoreId).removeClass('d-none');
    }
}

function getMoreSuggestions() {
    // Optional: Depends on how you handle the "Load more"-Functionality
    $('#' + skeletonId).removeClass('d-none');

    var form = ajaxForm([
        ["skipCounter", skipCounter],
        ["takeAmount", takeAmount],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, ['response']]
    ];

    // GET
    ajax('/get_suggestions', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(response) {
        $('#' + skeletonId).addClass('d-none');
        skipCounter += 10;

        $('#' + contentId).append(response['content']);

        if (skipCounter >= response['count'])
            $('#' + loadMoreId).addClass('d-none');
    }
}

function sendRequest(userId, suggestionId) {
    var form = ajaxForm([
        ["userId", userId],
        ["suggestionId", suggestionId],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, [suggestionId, 'response']]
    ];

    // GET
    ajax('/add_request', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(suggestionId, response) {
        if (response.status = 'success')
            $('#suggestion_' + suggestionId).remove();
        countReset('suggestion_count', 'sent_request_count');
    }
}

function deleteRequest(userId, requestId) {
    var form = ajaxForm([
        ["userId", userId],
        ["requestId", requestId],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, [requestId, 'response']]
    ];

    // GET
    ajax('/delete_request', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(suggestionId, response) {
        if (response.status = 'success')
            $('#request_' + requestId).remove();
    }

    countReset('sent_request_count', 'suggestion_count');
}

function acceptRequest(userId, requestId) {
    var form = ajaxForm([
        ["userId", userId],
        ["requestId", requestId],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, [requestId, 'response']]
    ];

    // GET
    ajax('/accept_requests', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(suggestionId, response) {
        if (response.status = 'success')
            $('#request_' + requestId).remove();
        countReset('received_request_count', 'connection_count');
    }
}

function removeConnection(userId, connectionId) {
    var form = ajaxForm([
        ["userId", userId],
        ["connectionId", connectionId],
    ]);

    var functionsOnSuccess = [
        [onSuccessFunction, [connectionId, 'response']]
    ];

    // GET
    ajax('/delete_connections', 'POST', functionsOnSuccess, form);

    function onSuccessFunction(connectionId, response) {
        if (response.status = 'success')
            $('#connection_' + connectionId).remove();
        countReset('connection_count', 'suggestion_count');
    }
}

function changeTab(tabName) {
    $('#' + contentId).html('');
    $('#' + loadMoreId).addClass('d-none');
    tab = tabName;
    skipCounter = 0;
    takeAmount = 10;

    if (tab == 'suggestions') {
        getSuggestions();
    }
    if (tab == 'sent_requests') {
        getRequests('sent')
    }
    if (tab == 'received_requests') {
        getRequests('received')
    }
    if (tab == 'connections') {
        getConnections()
    }

}

function loadMore() {

    if (tab == 'suggestions') {
        getMoreSuggestions()
    }
    if (tab == 'sent_requests') {
        getMoreRequests('sent')
    }
    if (tab == 'received_requests') {
        getMoreRequests('received')
    }
    if (tab == 'connections') {
        getMoreConnections()
    }

}

function countReset(firstId, secondId) {
    if (firstId != null) {
        $('#' + firstId).text(parseInt($('#' + firstId).text()) - 1);
    }
    if (secondId != null) {
        $('#' + secondId).text(parseInt($('#' + secondId).text()) + 1);
    }
}

$(function () {
    getSuggestions();
});
