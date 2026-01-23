<?php
// Diccionario de categorías y fechas por Video ID
$info_videos_db = [
    'fdtGIXlSBYU' => ['tipo' => 'Full EP/Album Concept', 'fecha' => '20/05/2023'],
    'q-FcxH8VitQ' => ['tipo' => '3D | Pixel Art | Lyric', 'fecha' => '04/02/2022'],
    '1YhCMtuWXYI' => ['tipo' => 'Pixel Art', 'fecha' => '31/12/2021'],
    'NyeYJHwbMgw' => ['tipo' => 'Lyric Simple', 'fecha' => '15/02/2022'],
    'aEFW1vrqyBg' => ['tipo' => '3D | Anime AMV', 'fecha' => '22/07/2022'],
    'yCIsKctKyyk' => ['tipo' => '3D', 'fecha' => '28/02/2023'],
    'HaEf63Wk1Sc' => ['tipo' => 'Pixel Art', 'fecha' => '15/07/2022'],
    'kSxN_uQF5EY' => ['tipo' => '3D', 'fecha' => '12/10/2022'],
    'q2YLSjHLPeY' => ['tipo' => '3D', 'fecha' => '14/02/2022'],
    'gmlt0TecTZE' => ['tipo' => '3D | Pixel Art | Anime AMV', 'fecha' => '10/06/2022'],
    'ZRV_zPK18Gg' => ['tipo' => 'Lyric Portada', 'fecha' => '05/05/2022'],
    '9PfPgOhJYaA' => ['tipo' => '3D', 'fecha' => '18/08/2022'],
    'ih8asyTq1oQ' => ['tipo' => 'Pixel Art', 'fecha' => '30/09/2022'],
    'toA7TAhdJQM' => ['tipo' => 'Lyric Portada', 'fecha' => '15/11/2022'],
    'Sx8w6pJpb3A' => ['tipo' => 'Kinetic', 'fecha' => '20/01/2023'],
    'azfkhwF1jGw' => ['tipo' => '3D | Lyric Portada & Simple', 'fecha' => '10/02/2023'],
    'x1RprL97HJs' => ['tipo' => 'Lyric Simple', 'fecha' => '05/03/2023'],
    'ABS1KqO6Dro' => ['tipo' => 'Lyric Portada', 'fecha' => '15/04/2023'],
    'xUnf5UXAW5g' => ['tipo' => 'Anime AMV', 'fecha' => '20/05/2023'],
    '6h5MklJDZCk' => ['tipo' => 'Lyric Portada', 'fecha' => '01/06/2023'],
    'jzdxGmCmB_g' => ['tipo' => 'Pixel Art', 'fecha' => '15/07/2023'],
    'EAVGY5XqH6M' => ['tipo' => 'VideoClip Edit sin VFX', 'fecha' => '10/08/2023'],
    '90OnAT9ELks' => ['tipo' => 'VideoClip Edit con VFX', 'fecha' => '25/09/2023']
];

// Función para obtener info rápidamente
function getExtraInfo($id) {
    global $info_videos_db;
    return $info_videos_db[$id] ?? ['tipo' => 'Visual', 'fecha' => 'Reciente'];
}
?>