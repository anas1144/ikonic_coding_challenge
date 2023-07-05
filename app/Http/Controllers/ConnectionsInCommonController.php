<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Request as RequestRequest;


class ConnectionsInCommonController extends Controller
{
    public function index(RequestRequest $form_request)
    {

        $query = User::whereIn('id', User::find($form_request->userId)->connections()->pluck('id'))
            ->whereIn('id',User::find($form_request->connectionId)->connections()->pluck('id'));
        $count = $query->count();
        $connection_in_commons = $query->offset($form_request->skipCounter)->limit($form_request->takeAmount)->get();

        $html = '';
        foreach ($connection_in_commons as $connection_in_common)
            $html .= view('components.connection_in_common', compact('connection_in_common'))->render();

        return response()->json(['content' => $html, 'count' => $count], 200);
    }
}
