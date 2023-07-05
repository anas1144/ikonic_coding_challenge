<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as RequestRequest;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    public function index(RequestRequest $form_request)
    {

        $mode = $form_request->mode;
        $query = Auth::user();
        if ($mode == 'sent')
            $query = $query->pendingRequestsTo();
        else
            $query = $query->pendingRequestsFrom();
        $count = $query->count();
        $requests = $query->offset($form_request->skipCounter)->limit($form_request->takeAmount)->get();

        $html = '';
        foreach ($requests as $request)
            $html .= view('components.request', compact('request', 'mode'))->render();

        return response()->json(['content' => $html, 'count' => $count], 200);
    }

    public function store(RequestRequest $form_request)
    {

        \App\Models\Request::create(
            [
                'user_id' => $form_request->userId,
                'request_id' => $form_request->suggestionId,
                'accepted' => 0
            ]
        );

        return response()->json(['status' => 'success'], 200);
    }

    public function update(RequestRequest $form_request)
    {

        \App\Models\Request::create(
            [
                'user_id' => $form_request->userId,
                'request_id' => $form_request->requestId,
                'accepted' => 1
            ]
        );

        \App\Models\Request::where('user_id', $form_request->requestId)
            ->where('request_id', $form_request->userId)
            ->update(['accepted'=>1]);

        return response()->json(['status' => 'success'], 200);
    }

    public function destroy(RequestRequest $form_request)
    {

        $q = \App\Models\Request::where('user_id', $form_request->userId)
            ->where('request_id', $form_request->requestId)
            ->delete();

        return response()->json(['status' =>  'success'], 200);
    }
}
