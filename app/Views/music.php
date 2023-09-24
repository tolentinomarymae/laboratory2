<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300&family=Poppins:wght@300&display=swap" rel="stylesheet">
    
    <style>
    body {
         font-family: 'Poppins', sans-serif;
         text-align: center;
         background-color: #f5f5f5;
         max-width: 100%;
     }

     h1 {
         color: #333;
         margin-top: 4vh;
         font-weight: bold;
     }

     #player-container {
         max-width: 400px;
         margin: 0 auto;
         padding: 20px;
         background-color: #fff;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
     }

     audio {
         width: 80%;
     }
     .myplaylist{
        background-color: transparent;
        color: 	#1DB954;
        background: none;
        border: none;
        margin-top: .7vh;
     }
     .navbar-expand-sm{
        background-color: #191414;
        color: 	#1DB954;
     }
     .navbar-expand-sm a{
        color: 	#1DB954;
     }
     .navbar-expand-sm a:hover{
        color: 	white;
     }
     #playlist {
         list-style: none;
         padding: 0;
     }

     #playlist li {
         cursor: pointer;
         padding: 10px;
         background-color: #eee;
         margin: 5px 0;
         transition: background-color 0.2s ease-in-out;
     }

     #playlist li:hover {
         background-color: #ddd;
     }

     #playlist li.active {
         background-color: #007bff;
         color: #fff;
     }
     .btn-primary{
        padding: 3px;
        font-size: 1vw;
     }
     .searchbar{
        font-size: .8vw;
        padding: 3px;
        width: 13vw;
     }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="javascript:void(0)"style="color:white">Spotify</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
        <button type="button" class="myplaylist" data-bs-toggle="modal" data-bs-target="#addsongmodal">
  Add Song
</button>
        </li>
        <li class="nav-item">
        <button type="button" class="myplaylist" data-bs-toggle="modal" data-bs-target="#createPlaylistModal">
  Add Playlist
</button>
        
        </li>
        <!-- Add this button to your navbar -->
        <button type="button" class="myplaylist" id="myPlaylistButton" data-bs-toggle="modal" data-bs-target="#myPlaylistModal">
    My Playlist
</button>

</li>

      </ul>
      
      <form action="/search" method="get">
    <input type="search" name="search" class="searchbar" placeholder="search song">
    <button type="submit" class="btn btn-primary">search</button>
  </form>
    </div>
  </div>
</nav>

<div class="modal fade" id="addToPlaylistModal" tabindex="-1" aria-labelledby="addToPlaylistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addToPlaylistModalLabel">Add to Playlist</h5>
            
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
                
                
            </div>
            <div class="modal-body">
                <form action="/addToPlaylist" method="post">
                    <input type="hidden" id="songId" name="song_id">
                    <div class="form-group">
                        <label for="playlistSelect">Select a Playlist:</label>
                        <select class="form-control" id="playlistSelect" name="playlist_id">
                            <?php foreach ($playlists as $playlist): ?>
                                <option value="<?= $playlist['id']; ?>"><?= $playlist['playlist']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add to Playlist</button>
                     </form>
            </div>
            <div class="modal-footer">
            
            </div>
        </div>
    </div>
</div>

<!--add new playlist-->
<div class="modal fade" id="createPlaylistModal" tabindex="-1" aria-labelledby="createPlaylistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPlaylistModalLabel">Create New Playlist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="create_playlist" method="post">
                    <div class="form-group">
                        <label for="playlistName">Playlist Name:</label>
                        <input type="text" class="form-control" id="playlistName" name="playlist_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Playlist</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!--end of add new playlist-->

<!-- Modal to display playlists -->
<div class="modal fade" id="myPlaylistModal" tabindex="-1" aria-labelledby="myPlaylistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myPlaylistModalLabel">My Playlists</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Playlist Name</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($playlists as $playlist): ?>
                            <tr>
                                <td><?= $playlist['playlist']; ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
  <div class="modal fade" id="addsongmodal" tabindex="-1" aria-labelledby="addsongmodal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Song</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <br>
          
          <form action="upload_song" method="post" enctype="multipart/form-data">
                        <label for="song">Upload a Song:</label><br>
                        <input type="file" name="song_file" accept=".mp3" required>
                        <input type="text" name="song_title" placeholder="Song Title" required>
                        <input type="submit" value="Upload">
                    </form>
         
              
              <br>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>
    <h1>Music Player</h1>
    

    <audio id="audio" controls autoplay></audio>
    <ul id="playlist"> 
      <?php if ($song):?>
    <?php foreach ($music as $m): ?>
        <li data-src="<?= base_url($music['playlist']); ?>"><?= $music['musictitle']; ?>
        <button class="addToPlaylist" data-song-id="<?= $m['id']; ?>" data-toggle="modal" data-target="#addToPlaylistModal">
            +
        </button></li>
    <?php endforeach;?>
    <?php else: ?>
      <?php foreach ($music as $m): ?>
        <li data-src="<?= base_url($m['playlist']); ?>"><?= $m['musictitle']; ?>
        <button class="addToPlaylist" data-song-id="<?= $m['id']; ?>" data-toggle="modal" data-target="#addToPlaylistModal">
            +
        </button></li>
    <?php endforeach;?>
    <?php endif;?>
    </ul>
    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Select from playlist</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
          <form action="/" method="post">
            <!-- <p id="modalData"></p> -->
            <input type="hidden" id="musicID" name="musicID">
            <select  name="playlist" class="form-control" >

              <option value="playlist">playlist</option>

            </select>
            <input type="submit" name="add">
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
    <div id="search-results-container">
    <ul id="playlist">
      <h1>fsdf</h1>
        <!-- Existing content goes here -->
    </ul>
</div>
    <script>
      
    $(document).ready(function () {
  // Get references to the button and modal
  const modal = $("#myModal");
  const modalData = $("#modalData");
  const musicID = $("#musicID");
  // Function to open the modal with the specified data
  function openModalWithData(dataId) {
    // Set the data inside the modal content
    modalData.text("Data ID: " + dataId);
    musicID.val(dataId);
    // Display the modal
    modal.css("display", "block");
  }

  // Add click event listeners to all open modal buttons

  // When the user clicks the close button or outside the modal, close it
  modal.click(function (event) {
    if (event.target === modal[0] || $(event.target).hasClass("close")) {
      modal.css("display", "none");
    }
  });
});
    /*$(document).ready(function () {
    // Get references to the playlist items
    const playlistItems = document.querySelectorAll('#playlist li');

    function playTrack(trackIndex) {
        if (trackIndex >= 0 && trackIndex < playlistItems.length) {
            const track = playlistItems[trackIndex];
            const trackSrc = track.getAttribute('data-src');
            const audio = new Audio(trackSrc);
            audio.play();
        }
    }

    // Add a click event listener to each playlist item to play the selected song
    playlistItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            playTrack(index);
        });
    });
});
*/
        const audio = document.getElementById('audio');
        const playlist = document.getElementById('playlist');
        const playlistItems = playlist.querySelectorAll('li');

        let currentTrack = 0;
        
        function playTrack(trackIndex) {
        if (trackIndex >= 0 && trackIndex < playlistItems.length) {
            const track = playlistItems[trackIndex];
            const trackSrc = track.getAttribute('data-src');
            const audio = new Audio(trackSrc);
            audio.play();
        }
    }

    // Add a click event listener to each playlist item to play the selected song
    playlistItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            playTrack(index);
        });
    });

        function nextTrack() {
            currentTrack = (currentTrack + 1) % playlistItems.length;
            playTrack(currentTrack);
        }

        function previousTrack() {
            currentTrack = (currentTrack - 1 + playlistItems.length) % playlistItems.length;
            playTrack(currentTrack);
        }

        playlistItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                playTrack(index);
            });
        });

        audio.addEventListener('ended', () => {
            nextTrack();
        });

        playTrack(currentTrack);
       
    $(document).ready(function () {
        // Get references to the button and modal
        const modal = $("#addToPlaylistModal");
        const addToPlaylistButtons = $(".addToPlaylist");

        // Function to open the modal with the specified data
        function openModalWithData(dataId) {
            // Set the data inside the modal content
            $("#songId").val(dataId);
            // Display the modal
            modal.modal("show");
        }

        // Add click event listeners to all "Add to Playlist" buttons
        addToPlaylistButtons.click(function (event) {
            const dataId = $(this).data("song-id");
            openModalWithData(dataId);
        });

        // When the user clicks the close button or outside the modal, close it
        modal.on("hidden.bs.modal", function () {
            // Clear the selected playlist (if needed)
            $("#playlistSelect").val("");
        });
    });

    $(document).ready(function () {
        // Get references to the button and modal
        const addToPlaylistModal = $("#addToPlaylistModal");
        const createPlaylistModal = $("#createPlaylistModal");
        const addToPlaylistButtons = $(".addToPlaylist");

        // Function to open the "Add to Playlist" modal with the specified data
        function openAddToPlaylistModal(dataId) {
            $("#songId").val(dataId);
            addToPlaylistModal.modal("show");
        }

        // Function to open the "Create New Playlist" modal
        function openCreatePlaylistModal() {
            createPlaylistModal.modal("show");
        }

        // Add click event listeners to all "Add to Playlist" buttons
        addToPlaylistButtons.click(function (event) {
            const dataId = $(this).data("song-id");
            openAddToPlaylistModal(dataId);
        });

        // Add click event listener to open "Create New Playlist" modal
        $("#createPlaylistButton").click(function () {
            openCreatePlaylistModal();
        });

        // When the user clicks the close button or outside the modal, close it
        addToPlaylistModal.on("hidden.bs.modal", function () {
            // Clear the selected playlist (if needed)
            $("#playlistSelect").val("");
        });

        createPlaylistModal.on("hidden.bs.modal", function () {
            // Clear the input field
            $("#playlistName").val("");
        });
    });
// Function to open "My Playlist" modal
function openMyPlaylistModal() {
    $("#myPlaylistModal").modal("show");
}

// Function to add a song to a playlist (you can customize this)
function addToPlaylist(playlistId) {
    // Implement the logic to add the current song to the selected playlist
    const songId = $("#songId").val();
    
    // You can make an AJAX request here to add the song to the playlist in the backend
    // For simplicity, I'm just displaying an alert message
    alert(`Added song with ID ${songId} to playlist with ID ${playlistId}`);
    
    // Close the modal
    $("#myPlaylistModal").modal("hide");
}

$(document).ready(function () {
    // Add click event listener to open "My Playlist" modal
    $("#myPlaylistButton").click(function () {
        openMyPlaylistModal();
    });
});

    $(document).ready(function () {
        // Handle form submission
        $('#search-form').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission
            const searchQuery = $('#search-input').val();

            // Use AJAX to send the search query to the server
            $.ajax({
                url: '/search', // Replace with the actual URL for searching
                method: 'GET',
                data: { search: searchQuery },
                success: function (data) {
                    // Update the content with the search results
                    $('#search-results-container').html(data);
                },
                error: function () {
                    // Handle errors if needed
                    console.error('Error occurred during search.');
                }
            });
        });
    });
    </script>
</body>
</html>
