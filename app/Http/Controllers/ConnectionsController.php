<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request as RequestRequest;
use Illuminate\Support\Facades\Auth;

class ConnectionsController extends Controller
{
    public function index(RequestRequest $form_request)
    {

        $query = Auth::user()->Connections();
        $count = $query->count();
        $connections = $query->offset($form_request->skipCounter)->limit($form_request->takeAmount)->get();

        $html = '';
        foreach ($connections as $connection)
            $html .= view('components.connection', compact('connection'))->render();

        return response()->json(['content' => $html, 'count' => $count], 200);
    }


    public function destroy(RequestRequest $form_request)
    {

        $q = \App\Models\Request::where(function ($q) use ($form_request) {
            $q->where('user_id', $form_request->userId)
                ->where('request_id', $form_request->connectionId);
             })
            ->orWhere(function ($q) use ($form_request) {
                $q->where('user_id', $form_request->connectionId)
                    ->where('request_id', $form_request->userId);
            })
            ->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
