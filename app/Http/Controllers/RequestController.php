<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\SongRequest;

use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new Client;
    }

    public function create(Request $request) {
        $request->validate([
            'public_key' => 'required|string',
            'song' => 'required|string'
        ]);

        $key = $request->get('public_key');
        $songId = $request->get('song');
        $user = User::where('public_key', $key)->first();

        if ($user == null) {
            return response('Invalid public key!', 400);
        }

        $res;

        try {
            $res = $this->client->get("https://beatsaver.com/api/maps/detail/{$songId}");
        } catch (\Exception $ex) {
            return response("Error fetching song details", 500);
        }

        $song = json_decode($res->getBody(), true);

        /*
        try {
            $coverURL = 'https://beatsaver.com' . $song["coverURL"];
            $cover = $this->client->get($coverURL);
            $coverIMG = base64_encode($cover->getBody()->getContents());
            
            $song["coverIMG"] = $coverIMG;
        } catch (\Exception $ex) {
            throw $ex;
            return response("Error fetching song cover", 500);
        }
        */

        $songRequest = new SongRequest;
        $songRequest->user_id = $user->id;
        $songRequest->song = json_encode($song, JSON_UNESCAPED_SLASHES);
        $songRequest->requester_ip = $request->ip();

        if (Auth::user()) {
            $songRequest->requester_id = Auth::user()->id;
        }

        $songRequest->save();

        return response("ok", 201);
    }

    public function fetch(Request $request) {
        $request->validate([
            "private_key" => "string|required|min:255|max:255"
        ]);

        $key = $request->get("private_key");
        $user = User::where('private_key', $key)->first();

        if ($user == null) {
            return response('', 404);
        }

        $res = new \stdClass();
        $res->songs = $user->fetchRequests();

        return json_encode($res, JSON_UNESCAPED_SLASHES);
    }

    public function list(Request $request) {
        $user = Auth::user();
        $requests = $user->getAllRequests()->map(function($request) {
            $result = [];
            $song = json_decode($request->song);
            $result["id"] = $request->id;
            $result["fetched"] = $request->fetched;
            $result["description"] = $song->description;
            $result["songName"] = $song->metadata->songName;
            $result["songAuthor"] = $song->metadata->songAuthorName;
            $result["coverURL"] = 'https://beatsaver.com' . $song->coverURL;
            
            return $result;
        });

        return json_encode($requests, JSON_UNESCAPED_SLASHES);
    }
}
