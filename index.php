<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Video Downloader</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .input-group {
            height: 50px;
        }
        .custom-search-input {
            height: 100%;
            font-size: 18px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .custom-search-button {
            height: 100%;
            font-size: 18px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .custom-thumbnail {
            border: 2px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
        .loading {
            display: none;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            padding: 10px;
            background-color: #f8f9fa;
        }
        .video-details {
           
        }
        .btn-number-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            padding: 10px;
            background-color: #f8f9fa;
        }
        .btn-number {
            margin: 5px;
        }
        .btn-active {
            background-color: #28a745;
            color: white;
        }
       
        .container {
            max-width: 870px;
        }

       
        .card {
            max-width: 90%;
        }

        
        .card-body {
            padding: 1.5rem;
        }       

    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
    <div class="card">
        <div class="card-header text-center">
            YouTube Video Downloader
        </div>
        <div class="card-body">
                    <form id="youtubeForm" class="form-inline">
                        <div class="input-group w-100 mb-2">
                            <input type="text" class="form-control custom-search-input" id="youtubeUrl" name="youtubeUrl" placeholder="Insira o link do YouTube" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary custom-search-button">Baixar</button>
                            </div>
                        </div>
                        <div class="input-group w-100 mb-2">
                            <input type="text" class="form-control custom-search-input" id="playlistUrl" name="playlistUrl" placeholder="Ou insira o link da playlist">
                            <div class="input-group-append">
                                <button type="button" id="fetchPlaylist" class="btn btn-secondary custom-search-button">Carregar Playlist</button>
                            </div>
                        </div>
                    </form>

                    <div id="loading" class="loading">Buscando <img src="./img/carregando.gif" alt="Carregando..." width="25" height="25"></div>
                    <div id="result"></div>
                    <div id="playlistResult"></div>
                    <div id="videoDetails" class="video-details"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.getElementById('youtubeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const youtubeUrl = document.getElementById('youtubeUrl').value;
        const loading = document.getElementById('loading');
        const result = document.getElementById('result');
        
        // Show loading
        loading.style.display = 'block';
        result.innerHTML = '';

        fetch(`http://jonathanfonseca.rf.gd/youtube_to_mp3_api/api.php?url=${encodeURIComponent(youtubeUrl)}`)
            .then(response => response.json())
            .then(data => {
                // Hide loading
                loading.style.display = 'none';
                
                if (data.thumbnail) {
                    result.innerHTML = `
                        <div class="text-center mb-3">
                            <img src="${data.thumbnail}" class="img-fluid custom-thumbnail" alt="Thumbnail">
                        </div>
                        <h5 class="card-title">${data.title}</h5>
                        <p class="card-text"><strong>Canal:</strong> ${data.channelTitle}</p>
                        <p class="card-text"><strong>Qualidade do Áudio:</strong> ${data.audioQuality} kbps</p>
                        <p class="card-text"><strong>Qualidade do Vídeo:</strong> ${data.videoQuality}</p>
                        <div class="text-center">
                            <a href="${data.mp3DownloadUrl}" class="btn btn-primary mb-2">Download MP3</a>
                            <a href="${data.mp4DownloadUrl}" class="btn btn-success mb-2">Download MP4</a>
                        </div>
                        ${data.mp3Error ? `<div class="alert alert-danger">${data.mp3Error}</div>` : ''}
                        ${data.mp4Error ? `<div class="alert alert-danger">${data.mp4Error}</div>` : ''}
                    `;
                } else {
                    result.innerHTML = '<div class="alert alert-danger">Erro ao buscar informações do vídeo.</div>';
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                result.innerHTML = '<div class="alert alert-danger">Erro ao buscar informações do vídeo.</div>';
            });
    });

document.getElementById('fetchPlaylist').addEventListener('click', function() {
    const playlistUrl = document.getElementById('playlistUrl').value;
    const playlistResult = document.getElementById('playlistResult');
    const loading = document.getElementById('loading');
    
    if (!playlistUrl) {
        alert('Insira o link da playlist.');
        return;
    }

    // Extrair o ID da lista da URL fornecida
    const listIdMatch = playlistUrl.match(/[?&]list=([^&]+)/);
    if (listIdMatch) {
        const listId = listIdMatch[1];
        const newPlaylistUrl = `https://www.youtube.com/playlist?list=${listId}`;

        // Show loading
        loading.style.display = 'block';
        playlistResult.innerHTML = '';

        fetch(`http://jonathanfonseca.rf.gd/youtube_to_mp3_api/url.php?url=${encodeURIComponent(newPlaylistUrl)}`)
            .then(response => response.json())
            .then(videoUrls => {
                // Hide loading
                loading.style.display = 'none';
                
                if (Array.isArray(videoUrls) && videoUrls.length > 0) {
                    let playlistHtml = '';
                    playlistHtml += '<div class="btn-number-container">';
                    videoUrls.forEach((videoUrl, index) => {
                        playlistHtml += `
                            <button class="btn btn-secondary btn-number" id="btn-${index}" onclick="fetchVideoDetails('${videoUrl}', ${index})">${index + 1}</button>
                        `;
                    });
                    playlistHtml += '</div>';
                    playlistResult.innerHTML = playlistHtml;

                    // Restore button states
                    restoreButtonStates();
                } else {
                    playlistResult.innerHTML = '<div class="alert alert-danger">Nenhum vídeo encontrado na playlist.</div>';
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                playlistResult.innerHTML = '<div class="alert alert-danger">Erro ao buscar vídeos da playlist.</div>';
            });
    } else {
        playlistResult.innerHTML = '<div class="alert alert-danger">URL da playlist inválida. Certifique-se de que contém o parâmetro "list".</div>';
    }
});


    function fetchVideoDetails(videoUrl, buttonIndex) {
        const loading = document.getElementById('loading');
        const videoDetails = document.getElementById('videoDetails');
        
        // Show loading
        loading.style.display = 'block';
        videoDetails.innerHTML = '';

        fetch(`http://jonathanfonseca.rf.gd/youtube_to_mp3_api/api.php?url=${encodeURIComponent(videoUrl)}`)
            .then(response => response.json())
            .then(data => {
                // Hide loading
                loading.style.display = 'none';

                // Reset button colors
                document.querySelectorAll('.btn-number').forEach((btn, index) => {
                    btn.classList.remove('btn-active');
                });

                // Highlight the clicked button
                document.getElementById(`btn-${buttonIndex}`).classList.add('btn-active');
                
                // Save button state
                saveButtonState(buttonIndex);
                
                if (data.thumbnail) {
                    videoDetails.innerHTML = `
                        <div class="text-center mb-3">
                            <img src="${data.thumbnail}" class="img-fluid custom-thumbnail" alt="Thumbnail">
                        </div>
                        <h5 class="card-title">${data.title}</h5>
                        <p class="card-text"><strong>Canal:</strong> ${data.channelTitle}</p>
                        <p class="card-text"><strong>Qualidade do Áudio:</strong> ${data.audioQuality} kbps</p>
                        <p class="card-text"><strong>Qualidade do Vídeo:</strong> ${data.videoQuality}</p>
                        <div class="text-center">
                            <a href="${data.mp3DownloadUrl}" class="btn btn-primary mb-2">Download MP3</a>
                            <a href="${data.mp4DownloadUrl}" class="btn btn-success mb-2">Download MP4</a>
                        </div>
                        ${data.mp3Error ? `<div class="alert alert-danger">${data.mp3Error}</div>` : ''}
                        ${data.mp4Error ? `<div class="alert alert-danger">${data.mp4Error}</div>` : ''}
                    `;
                } else {
                    videoDetails.innerHTML = '<div class="alert alert-danger">Erro ao buscar informações do vídeo.</div>';
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                videoDetails.innerHTML = '<div class="alert alert-danger">Erro ao buscar informações do vídeo.</div>';
            });
    }

    function saveButtonState(buttonIndex) {
        let activeButtons = JSON.parse(sessionStorage.getItem('activeButtons')) || [];
        if (!activeButtons.includes(buttonIndex)) {
            activeButtons.push(buttonIndex);
            sessionStorage.setItem('activeButtons', JSON.stringify(activeButtons));
        }
    }

    function restoreButtonStates() {
        let activeButtons = JSON.parse(sessionStorage.getItem('activeButtons')) || [];
        activeButtons.forEach(buttonIndex => {
            const btn = document.getElementById(`btn-${buttonIndex}`);
            if (btn) {
                btn.classList.add('btn-active');
            }
        });
    }

    // Restore button states on page load
    window.onload = function() {
        restoreButtonStates();
    };
</script>
</body>
</html>
