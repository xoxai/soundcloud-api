<?php

use GuzzleHttp\Client as Client;

class SoundCloudApi 
{

    const CLIENT_ID = 'Na04L87fnpWDMVCCW2ngWldN4JMoLTAc';
    const BASE_URL = 'https://api-v2.soundcloud.com';


    private $client;


    public function __construct() 
    {
        $this->client = new Client(['cookies' => true]);
    }


    public function getUsers($username) 
    {
        $response = $this->client->request('GET', self::BASE_URL . '/search/users', [
            'query' => [
                'client_id' => self::CLIENT_ID,
                'q' => $username
            ]
        ]);
        return json_decode($response->getBody()->getContents())->collection;
    }


    public function getUser($username) 
    {
        $user = $this->getUsers($username)[0];
        return [
            'sc_id' => $user->id,
            'full_name' => $user->full_name,
            'avatar_url' => $user->avatar_url
        ];
    }


    public function getUserTracks($userId) 
    {
        $params = [
            'query' => [
                'client_id' => self::CLIENT_ID,
                'limit' => 200,
                'linked_partitioning' => 1,
            ]
        ];

        $response = $this->client->request('GET', self::BASE_URL . '/users/'. $userId . '/tracks', $params);
        $responseObj = json_decode($response->getBody()->getContents());
        
        $tracks = [];

        while (isset($responseObj->next_href)) {
            $tracks = array_merge($tracks, $responseObj->collection);
            $nextPageUrl = $responseObj->next_href;
            $nextPageParams = parse_url($nextPageUrl);
            parse_str($nextPageParams['query'], $query);
            $nextPageOffset = $query['offset'];
            $response = $this->client->request('GET', self::BASE_URL . '/users/' . $userId . '/tracks', 
                ['query' => ['client_id' => self::CLIENT_ID, 'limit' => 200, 'offset' => $nextPageOffset]]
            );
            $responseObj = json_decode($response->getBody()->getContents());
        }
        
        $output = [];
        foreach ($tracks as $track) {
            $output[] = [
                'sc_id' => $track->id,
                'title' => $track->title,
                'genre' => $track->genre == '' ? 'Unknown' : $track->genre,
                'duration' => $track->full_duration,
                'release_date' => $track->release_date == '' ? 'NULL' : $track->release_date
            ];
        }

        return $output;
    }
}
