<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request as RequestRequest;
use Illuminate\Support\Facades\Auth;

class SuggestionsController extends Controller
{
    public function index(RequestRequest $formFequest)
    {
        $currentUserId = Auth::id();
        $query = User::whereNotIn('id', function ($q) use ($currentUserId) {
            $q->select('request_id')
                ->from('requests')
                ->where('user_id', $currentUserId);
        })->whereNotIn('id', function ($q) use ($currentUserId) {
            $q->select('user_id')
                ->from('requests')
                ->where('request_id', $currentUserId);
        })->where('id', '!=', $currentUserId);

        $count = $query->count();
        $suggestions = $query->offset($formFequest->skipCounter)->limit($formFequest->takeAmount)->get();

        $html = '';
        foreach ($suggestions as $suggestion)
            $html .= view('components.suggestion', compact('suggestion'))->render();

        return response()->json(['content' => $html,'count'=>$count], 200);
    }

    public function destroy(RequestRequest $formFequest)
    {

        $q = \App\Models\Request::where('user_id', $formFequest->userId)
            ->where('request_id', $formFequest->requestId)
            ->delete();

        return response()->json(['status' => $q], 200);
    }
}
