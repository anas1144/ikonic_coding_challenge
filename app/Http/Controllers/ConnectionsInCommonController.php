<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Request as RequestRequest;


class ConnectionsInCommonController extends Controller
{
    public function index(RequestRequest $formFequest)
    {

        $query = User::whereIn('id', User::find($formFequest->userId)->connections()->pluck('id'))
            ->whereIn('id',User::find($formFequest->connectionId)->connections()->pluck('id'));
        $count = $query->count();
        $connectionInCommons = $query->offset($formFequest->skipCounter)->limit($formFequest->takeAmount)->get();

        $html = '';
        foreach ($connectionInCommons as $connectionInCommon)
            $html .= view('components.connection_in_common', compact('connectionInCommons'))->render();

        return response()->json(['content' => $html, 'count' => $count], 200);
    }
}
