<?php

namespace App\Http\Controllers;

use App\Models\Perfilgithub;
use Illuminate\Http\Request;

class PerfilgithubController extends Controller
{

    private $loggedUser;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function getPerfilGitHub($username)
    {
        $urlServico10 = 'https://api.github.com/users/' . $username;

        $cookie = "busca";

        $username = "";
        $password = "";
        $postdata = "busca";

        $headers[] = "Connection: keep-alive";
        $headers[] = "Keep-Alive: 300";


        // Inicia
        $curl = curl_init();
        // Configura
        curl_setopt_array($curl, [
            CURLOPT_URL => $urlServico10,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_REFERER => "https://api.github.com",
            CURLOPT_AUTOREFERER => true,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_COOKIEFILE => $cookie,
            CURLOPT_COOKIEJAR => $cookie,
            CURLOPT_REFERER => $urlServico10,
            CURLOPT_ENCODING =>  '',
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_POST => 1,


        ]);
        // Envio e armazenamento da resposta
        $response = curl_exec($curl);

        /*
        "login": "winifidelis",
        "id": 50714563,
        "node_id": "MDQ6VXNlcjUwNzE0NTYz",
        "avatar_url": "https://avatars.githubusercontent.com/u/50714563?v=4",
        "gravatar_id": "",
        "url": "https://api.github.com/users/winifidelis",
        "html_url": "https://github.com/winifidelis",
        "followers_url": "https://api.github.com/users/winifidelis/followers",
        "following_url": "https://api.github.com/users/winifidelis/following{/other_user}",
        "gists_url": "https://api.github.com/users/winifidelis/gists{/gist_id}",
        "starred_url": "https://api.github.com/users/winifidelis/starred{/owner}{/repo}",
        "subscriptions_url": "https://api.github.com/users/winifidelis/subscriptions",
        "organizations_url": "https://api.github.com/users/winifidelis/orgs",
        "repos_url": "https://api.github.com/users/winifidelis/repos",
        "events_url": "https://api.github.com/users/winifidelis/events{/privacy}",
        "received_events_url": "https://api.github.com/users/winifidelis/received_events",
        "type": "User",
        "site_admin": false,
        "name": "Winicius Fidelis",
        "company": "Winicius",
        "blog": "",
        "location": "Goiânia - GO",
        "email": null,
        "hireable": null,
        "bio": "Engenheiro de computação",
        "twitter_username": "winifidelis",
        "public_repos": 17,
        "public_gists": 0,
        "followers": 1,
        "following": 1,
        "created_at": "2019-05-16T17:34:03Z",
        "updated_at": "2021-07-11T06:10:36Z"
        */
        $response = json_decode($response, true);
        $user = [
            'identificador' => $response['id'],
            'login' => $response['login'],
            'foto' => base64_encode(file_get_contents($response['avatar_url'])),
        ];

        return $user;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfis = Perfilgithub::select("*")
            ->where("user_id", "=", $this->loggedUser->id)
            ->get();


        return response()->json([
            'lista' => $perfis,
            'message' => 'Lista de perfis',
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $perfilgithub = Perfilgithub::firstOrCreate([
                'url' => 'não_utilizado',
                'login' => $data['login'],
                'identificador' => $data['identificador'],
                'foto' => $data['foto'],
                'user_id' => $this->loggedUser->id,
            ]);
            return response()->json([
                'message' => 'Dados gravados',
                'perfilgravado' => $perfilgithub
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possivel gravar o perfil',
                'error' => $th->getMessage(),
                'dados' => $data
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $perfil = Perfilgithub::find($id);
            return response()->json([
                'message' => 'Perfil excluído',
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possivel excluir o perfil',
                'error' => $th->getMessage()
            ], 404);
        }
    }
}
