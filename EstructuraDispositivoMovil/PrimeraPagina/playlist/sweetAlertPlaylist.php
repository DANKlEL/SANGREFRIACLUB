<?php include 'sweetAlertCategorias.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/playlist/css/sweetalertPlaylist.css">

<script>
const listaCategorias = <?php echo json_encode($info_videos_db); ?>;

function abrirInfoVideo(titulo, id, canal) {
    const infoExtra = listaCategorias[id] || { tipo: 'Visual', fecha: 'Reciente' };

    Swal.fire({
        customClass: {
            popup: 'aurora-bg-swal',
            closeButton: 'btn-cerrar-circular-hielo' 
        },
        showConfirmButton: false,
        showCloseButton: true,
        // El div con onclick asegura que cierre al 100%
        closeButtonHtml: '<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;" onclick="Swal.close()"><i class="fa-solid fa-xmark"></i></div>',
        allowOutsideClick: true,
        html: `
            <div class="swal-content-wrapper">
                <h3 class="swal-titulo-video">${titulo}</h3>
                <div class="swal-img-container">
                    <img src="https://i.ytimg.com/vi/${id}/hqdefault.jpg">
                    <div onclick="verMiniaturaGigante('${id}')" class="lupa-congelada">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </div>
                </div>
                <div class="swal-info-box">
                    <p><i class="fa-solid fa-user"></i> <b>ARTISTA:</b> ${canal}</p>
                    <p><i class="fa-solid fa-layer-group"></i> <b>CATEGORÍA:</b> ${infoExtra.tipo}</p>
                    <p><i class="fa-solid fa-calendar-day"></i> <b>FECHA:</b> ${infoExtra.fecha}</p>
                </div>
                <a href="https://www.youtube.com/watch?v=${id}" target="_blank" class="swal-yt-btn">
                    VER EN YOUTUBE <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        `
    });
}

function verMiniaturaGigante(id) {
    Swal.fire({
        imageUrl: `https://i.ytimg.com/vi/${id}/maxresdefault.jpg`,
        background: 'rgba(255,255,255,0.95)',
        backdrop: `rgba(120, 166, 181, 0.4) blur(8px)`,
        showConfirmButton: false,
        showCloseButton: true,
        closeButtonHtml: '<div onclick="Swal.close()"><i class="fa-solid fa-xmark"></i></div>',
        width: '95%',
        customClass: { closeButton: 'btn-cerrar-circular-hielo' }
    });
}
</script>