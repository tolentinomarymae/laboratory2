<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MainModel;
use App\Models\PlaylistModel;
use App\Models\MainModel as ModelsMainModel;

class MainController extends BaseController
{
    public function index()
    {
        $main = new MainModel();
        $data['music'] = $main->findAll();
        $data['song'] = [];
        $playlistModel = new PlaylistModel(); // Replace with your actual PlaylistModel
        $data['playlists'] = $playlistModel->findAll(); // Assuming you have a findAll method

        return view('music', $data);
    }

    public function upload_song()
    {
        // Check if a file was uploaded
        if ($this->request->getFile('song_file')->isValid()) {
            // Define your upload directory (make sure it's writable)
            $uploadDir = './uploads/';
            // Generate a unique filename for the uploaded song
            $songFilename = uniqid() . '.mp3';
            // Define the full path for the uploaded song file

            // Move the uploaded file to the defined directory
            if ($this->request->getFile('song_file')->move($uploadDir, $songFilename)) {
                // The song was successfully uploaded, you can now save its details to the database
                $songTitle = $this->request->getPost('song_title');

                // Save $songTitle and $songFilePath to your database table
                $mainModel = new MainModel();
                $data = [
                    'musictitle' => $songTitle,
                    'playlist' => '', // Initialize with an empty playlist
                ];
                $mainModel->insert($data);

                // Redirect to a success page or update the playlist and display a message
                return redirect()->to('/musicplayer')->with('success', 'Song uploaded successfully.');
            } else {
                // Handle the case where file upload failed
                return redirect()->to('/musicplayer')->with('error', 'Failed to upload song.');
            }
        } else {
            // Handle the case where no file was uploaded or there was an error
            return redirect()->to('/musicplayer')->with('error', 'No valid file uploaded.');
        }
    }

    public function addToPlaylist()
    {
        $songId = $this->request->getPost('song_id');
        $playlistId = $this->request->getPost('playlist_id');

        // Load your model and update the database to associate the song with the selected playlist
        $mainModel = new MainModel();

        // Get the existing playlist information from the database
        $existingPlaylist = $mainModel->find($songId);

        // Append the selected playlist to the existing playlist information
        $updatedPlaylist = $existingPlaylist['playlist'] . ', ' . $playlistId;

        // Update the database with the updated playlist information
        $mainModel->update($songId, ['playlist' => $updatedPlaylist]);

        return redirect()->to('/musicplayer')->with('success', 'Song added to the playlist.');
    }

    public function create_playlist()
    {
        $playlistName = $this->request->getPost('playlist_name');

        // Check if a playlist with the same name already exists
        $playlistModel = new PlaylistModel();
        $existingPlaylist = $playlistModel->where('playlist', $playlistName)->first();

        if ($existingPlaylist) {
            return redirect()->back()->withInput()->with('error', 'Playlist with this name already exists.');
        }

        // Insert the new playlist into the database
        $data = [
            'id' => null,
            'playlist' => $playlistName,
        ];

        try {
            $playlistModel->insert($data);
            return redirect()->to('/musicplayer')->with('success', 'Playlist created successfully.');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            return redirect()->back()->withInput()->with('error', 'Error creating playlist. Please try again later.');
        }
    }

    public function search()
    {
        $searchQuery = $this->request->getVar('search');
        $data['song'] = [];

        if ($searchQuery) {
            // Load the database connection if it's not already loaded
            $db = \Config\Database::connect();

            // Build your query using Query Builder
            $builder = $db->table('laboratorytwo'); // Replace with your actual table name
            $builder->like('musictitle', $searchQuery);

            // Get the results
            $data['song'] = $builder->get()->getResult();
        }

        return view('music', $data);
    }
}
