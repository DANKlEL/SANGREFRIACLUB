<?php
// ID de tu playlist
$playlist_id = 'PLfRglv5Ul9MgC6RNj-4BKTmaLnEWI4_oY';

/**
 * Esta función obtiene el HTML de la playlist y extrae la información 
 * que YouTube oculta en el JSON interno de la página.
 */
function obtenerVideosPlaylist($id) {
    $url = "https://www.youtube.com/playlist?list=" . $id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    $videos = [];
    // Buscamos el objeto JSON que contiene los datos de los videos en el HTML
    preg_match('/var ytInitialData = (.*?);<\/script>/', $html, $matches);
    
    if (isset($matches[1])) {
        $json = json_decode($matches[1], true);
        $tabs = $json['contents']['twoColumnBrowseResultsRenderer']['tabs'] ?? [];
        $contents = $tabs[0]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['playlistVideoListRenderer']['contents'] ?? [];

        foreach ($contents as $item) {
            if (!isset($item['playlistVideoRenderer'])) continue;
            
            $v = $item['playlistVideoRenderer'];
            $title = $v['title']['runs'][0]['text'] ?? 'Sin título';
            $video_id = $v['videoId'];

            $tipo = "Visual";
            if (stripos($title, '3D') !== false) $tipo = "3D";
            elseif (stripos($title, 'Pixel') !== false) $tipo = "Pixel Art";
            elseif (stripos($title, 'Lyric') !== false) $tipo = "Lyric";

            $videos[] = [
                "titulo" => trim(preg_replace('/\(Shot by.*?\)|Video Oficial/i', '', $title)),
                "url"    => $video_id,
                "tipo"   => $tipo
            ];
        }
    }
    return $videos;
}

$videos = obtenerVideosPlaylist($playlist_id);
$categorias = ["TODOS", "3D", "Pixel Art", "Lyric"];
?>

<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/playlist/css/playlist.css">

<div class="playlist-neon-frame">
    <div class="custom-playlist-container">
        <?php if (empty($videos)): ?>
            <div style="text-align:center; color:#78a6b5; padding:40px;">
                <p>No se pudieron cargar los videos. Intenta recargar.</p>
            </div>
        <?php else: ?>
            
            <div id="main-player-area" class="main-playlist-card">
                <div class="video-responsive-container" id="video-wrapper">
                    <div class="card-img-wrapper" style="position:relative; cursor:pointer;" onclick="reproducirVideo('<?php echo $videos[0]['url']; ?>', '<?php echo addslashes($videos[0]['titulo']); ?>')">
                        <img src="https://i.ytimg.com/vi/<?php echo $videos[0]['url']; ?>/hqdefault.jpg" style="width:100%; display:block;">
                        <div class="card-overlay" style="position:absolute; inset:0; background:rgba(0,0,0,0.3); display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-circle-play" style="font-size:3rem; color:white;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-info" style="background:#1a1c1e; padding:15px; text-align:center;">
                    <h3 id="player-title" style="color:#78a6b5; margin:0; font-size:0.9rem; text-transform:uppercase;"><?php echo $videos[0]['titulo']; ?></h3>
                </div>
            </div>

            <div class="category-selector">
                <button onclick="prevCat()"><i class="fa-solid fa-chevron-left"></i></button>
                <span id="current-cat" style="font-weight:900;">TODOS</span>
                <button onclick="nextCat()"><i class="fa-solid fa-chevron-right"></i></button>
            </div>

            <div class="video-scroll-list" id="video-list">
                <?php foreach ($videos as $v): ?>
                    <div class="video-item" data-type="<?php echo $v['tipo']; ?>" style="cursor:pointer; margin-bottom:10px;" onclick="reproducirVideo('<?php echo $v['url']; ?>', '<?php echo addslashes($v['titulo']); ?>')">
                        <div class="video-clickable">
                            <img src="https://i.ytimg.com/vi/<?php echo $v['url']; ?>/mqdefault.jpg">
                            <div class="video-details">
                                <span class="v-title"><?php echo $v['titulo']; ?></span>
                                <span class="v-tag"><?php echo $v['tipo']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function reproducirVideo(id, titulo) {
    const wrapper = document.getElementById('video-wrapper');
    wrapper.innerHTML = `<iframe src="https://www.youtube.com/embed/${id}?autoplay=1&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%;"></iframe>`;
    document.getElementById('player-title').innerText = titulo;
}

const cats = <?php echo json_encode($categorias); ?>;
let indexCat = 0;

function updatePlaylist() {
    const current = cats[indexCat];
    document.getElementById('current-cat').innerText = current;
    document.querySelectorAll('.video-item').forEach(item => {
        const type = item.getAttribute('data-type').toUpperCase();
        item.style.display = (current === "TODOS" || type.includes(current.toUpperCase())) ? "flex" : "none";
    });
}
function nextCat() { indexCat = (indexCat + 1) % cats.length; updatePlaylist(); }
function prevCat() { indexCat = (indexCat - 1 + cats.length) % cats.length; updatePlaylist(); }
</script>