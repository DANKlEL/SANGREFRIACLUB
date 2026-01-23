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
            closeButton: 'btn-cerrar-circular-fuera' 
        },
        showConfirmButton: false,
        showCloseButton: true,
        closeButtonHtml: '<i class="fa-solid fa-xmark"></i>', 
        allowOutsideClick: true,
        html: `
            <div class="swal-content-wrapper">
                <h3 class="swal-titulo-video" style="color:var(--azul-oscuro); font-weight:bold;">${titulo}</h3>
                <div class="swal-img-container">
                    <img src="https://i.ytimg.com/vi/${id}/hqdefault.jpg" class="img-recortada">
                    <div onclick="verMiniaturaGigante('${id}')" class="lupa-congelada">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </div>
                </div>
                <div class="swal-info-box">
                    <p><i class="fa-solid fa-user"></i> ARTISTA: ${canal}</p>
                    <p><i class="fa-solid fa-layer-group"></i> CATEGORÍA: ${infoExtra.tipo}</p>
                    <p><i class="fa-solid fa-calendar-day"></i> FECHA: ${infoExtra.fecha}</p>
                </div>
                <a href="https://www.youtube.com/watch?v=${id}" target="_blank" class="link-card-hielo">
                    <i class="fa-brands fa-youtube icon-yt-hielo"></i>
                    <span>VER EN YOUTUBE</span>
                </a>
            </div>
        `
    });
}

function verMiniaturaGigante(id) {
    Swal.fire({
        html: `<div style="width:100%; aspect-ratio:16/9; overflow:hidden; border-radius:20px;">
                 <img src="https://i.ytimg.com/vi/${id}/maxresdefault.jpg" class="img-full-recortada">
               </div>`,
        background: 'transparent',
        backdrop: `rgba(120, 166, 181, 0.4) blur(8px)`,
        showConfirmButton: false,
        showCloseButton: true,
        closeButtonHtml: '<i class="fa-solid fa-xmark"></i>',
        width: '95%',
        customClass: { 
            popup: 'popup-lupa-transparente',
            closeButton: 'btn-cerrar-circular-fuera' 
        }
    });
}
</script>