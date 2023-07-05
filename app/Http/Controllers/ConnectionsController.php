<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request as RequestRequest;
use Illuminate\Support\Facades\Auth;

class ConnectionsController extends Controller
{
    public function index(RequestRequest $formFequest)
    {

        $query = Auth::user()->Connections();
        $count = $query->count();
        $connections = $query->offset($formFequest->skipCounter)->limit($formFequest->takeAmount)->get();

        $html = '';
        foreach ($connections as $connection)
            $html .= view('components.connection', compact('connection'))->render();

        return response()->json(['content' => $html, 'count' => $count], 200);
    }


    public function destroy(RequestRequest $formFequest)
    {

        $q = \App\Models\Request::where(function ($q) use ($formFequest) {
            $q->where('user_id', $formFequest->userId)
                ->where('request_id', $formFequest->connectionId);
             })
            ->orWhere(function ($q) use ($formFequest) {
                $q->where('user_id', $formFequest->connectionId)
                    ->where('request_id', $formFequest->userId);
            })
            ->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
