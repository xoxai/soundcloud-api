<?php

error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'classes/SoundCloudApi.php';

use GuzzleHttp\Client as Client;

$sc = new SoundCloudApi();
$pdo = new PDO('mysql:dbname=testing;host=localhost', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$artistsList = ['lakeyinspired', 'aljoshakonstanty', 'birocratic', 'dixxy-2', 'dekobe'];

foreach ($artistsList as $id => $username) {
    // insert artist
    $artist = $sc->getUser($username);
    $sql = 'INSERT INTO media_artists(sc_id, username, name, avatar_url) 
            VALUES (:scId, :username, :name, :avatarUrl)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'scId' => $artist['sc_id'],
        'username' => $username,
        'name' => $artist['full_name'],
        'avatarUrl' => $artist['avatar_url']
    ]);

    // insert artist tracks
    $tracks = $sc->getUserTracks($artist['sc_id']);
    $artistId = $id + 1;
    foreach ($tracks as $track) {
        $sql = 'INSERT INTO media_tracks(sc_id, artist_id, title, genre, duration, release_date) 
                VALUES (:scId, :artistId, :title, :genre, :duration, :releaseDate)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'scId' => $track['sc_id'],
            'artistId' => $artistId,
            'title' => $track['title'],
            'genre' => $track['genre'],
            'duration' => $track['duration'],
            'releaseDate' => $track['release_date']
        ]);
    }
}
