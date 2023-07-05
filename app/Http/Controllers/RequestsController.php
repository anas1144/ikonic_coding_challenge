<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as RequestRequest;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    public function index(RequestRequest $formFequest)
    {

        $mode = $formFequest->mode;
        $query = Auth::user();
        if ($mode == 'sent')
            $query = $query->pendingRequestsTo();
        else
            $query = $query->pendingRequestsFrom();
        $count = $query->count();
        $requests = $query->offset($formFequest->skipCounter)->limit($formFequest->takeAmount)->get();

        $html = '';
        foreach ($requests as $request)
            $html .= view('components.request', compact('request', 'mode'))->render();

        return response()->json(['content' => $html, 'count' => $count], 200);
    }

    public function store(RequestRequest $formFequest)
    {

        \App\Models\Request::create(
            [
                'user_id' => $formFequest->userId,
                'request_id' => $formFequest->suggestionId,
                'accepted' => 0
            ]
        );

        return response()->json(['status' => 'success'], 200);
    }

    public function update(RequestRequest $formFequest)
    {

        \App\Models\Request::create(
            [
                'user_id' => $formFequest->userId,
                'request_id' => $formFequest->requestId,
                'accepted' => 1
            ]
        );

        \App\Models\Request::where('user_id', $formFequest->requestId)
            ->where('request_id', $formFequest->userId)
            ->update(['accepted'=>1]);

        return response()->json(['status' => 'success'], 200);
    }

    public function destroy(RequestRequest $formFequest)
    {

        $q = \App\Models\Request::where('user_id', $formFequest->userId)
            ->where('request_id', $formFequest->requestId)
            ->delete();

        return response()->json(['status' =>  'success'], 200);
    }
}
