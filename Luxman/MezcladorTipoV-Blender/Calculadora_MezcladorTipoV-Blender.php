<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Calculadora de Corte de Tubo - LUXMAN</title>
  <link rel="stylesheet" href="Calculadora_MezcladorTipoV-Blender.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
  <div class="main-content">
    <section class="form-section">
      <h1>LUXMAN</h1>
      <h2>Calculadora - Mezclador Tipo V-Blender</h2>

      <label for="angulo">Ángulo total entre tubos (°):</label>
      <input type="number" id="angulo" placeholder="Ingresa el ángulo total (Obligatorio)" required />

      <label for="diametro">Diámetro exterior del tubo (cm):</label>
      <input type="number" id="diametro" placeholder="Ej: 5" />

      <div class="buttons-row">
        <button onclick="calcular()">Calcular y Dibujar</button>
        <button onclick="descargarPDF()" class="download-btn">Descargar PDF</button>
      </div>
    </section>

    <section class="canvas-section">
      <canvas id="moldeCanvas" width="1000" height="300"></canvas>
    </section>

    <section class="tabla-datos">
      <h3>Resumen de Cálculos</h3>
      <table>
        <thead>
          <tr>
            <th>Dato</th>
            <th>Cálculo final</th>
            <th>Fórmula / Referencia</th>
            <th>Uso</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Ajuste del bisel de corte</td>
            <td><span id="biselCorte">-</span>°</td>
            <td>ángulo / 2</td>
            <td>Determina el ángulo para preparar el bisel del tubo para un ajuste preciso en la soldadura.</td>
          </tr>
          <tr>
            <td>Plantilla de corte</td>
            <td>Curva senoidal</td>
            <td>Fórmula trigonométrica</td>
            <td>Guía para cortar el tubo con forma ondulada que facilita el ensamblaje y soldadura entre tubos.</td>
          </tr>
          <tr>
            <td>Tamaño de plantilla</td>
            <td><span id="tamanoPlantilla">-</span> cm</td>
            <td>2πR</td>
            <td>Indica la longitud total que debe tener la plantilla para el corte alrededor del perímetro del tubo.</td>
          </tr>
          <tr>
            <td>Estimación de soldadura</td>
            <td>Dependiente de integración</td>
            <td>Integración curva</td>
            <td>Calcula la cantidad aproximada de material de soldadura necesario según la curva del bisel.</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calcular() {
  const angulo = parseFloat(document.getElementById('angulo').value);
  const diametro = parseFloat(document.getElementById('diametro').value);

  if (isNaN(angulo) || isNaN(diametro)) {
    Swal.fire({ icon: 'error', title: 'Faltan datos', text: 'Ingresa ángulo y diámetro válidos.' });
    return;
  }

  const anguloCorte = angulo / 2;
  const radio = diametro / 2;
  const perimetroCm = 2 * Math.PI * radio;

  dibujarCurvaEscalaReal(diametro, anguloCorte, perimetroCm);

  document.getElementById('biselCorte').textContent = anguloCorte.toFixed(2);
  document.getElementById('tamanoPlantilla').textContent = perimetroCm.toFixed(2);
}

function dibujarCurvaEscalaReal(diametro, anguloCorte, perimetroCm) {
  const dpi = 96;
  const cmToPxReal = dpi / 2.54; // ≈ 37.8 px por cm
  const escala = cmToPxReal;

  const canvasWidthPx = perimetroCm * escala;
  const canvasHeightPx = 300;

  const canvas = document.getElementById('moldeCanvas');
  canvas.width = canvasWidthPx;
  canvas.height = canvasHeightPx;

  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Líneas de referencia verticales
  ctx.strokeStyle = '#eee';
  for (let i = 0; i <= 10; i++) {
    const x = i * canvas.width / 10;
    ctx.beginPath();
    ctx.moveTo(x, 0);
    ctx.lineTo(x, canvas.height);
    ctx.stroke();
  }

  // Curva senoidal roja
  ctx.beginPath();
  ctx.strokeStyle = 'red';
  ctx.lineWidth = 2;

  for (let x = 0; x <= canvas.width; x++) {
    const t = (x / canvas.width) * (2 * Math.PI);
    const y = Math.sin(t) * Math.sin(anguloCorte * Math.PI / 180) * 100 + canvas.height / 2;
    if (x === 0) ctx.moveTo(x, y);
    else ctx.lineTo(x, y);
  }
  ctx.stroke();

  // Línea media horizontal punteada
  ctx.beginPath();
  ctx.setLineDash([4, 2]);
  ctx.moveTo(0, canvas.height / 2);
  ctx.lineTo(canvas.width, canvas.height / 2);
  ctx.strokeStyle = '#000';
  ctx.stroke();
  ctx.setLineDash([]);

  // Texto informativo
  ctx.fillStyle = 'black';
  ctx.font = '16px Arial';
  ctx.fillText(`Diámetro: ${diametro} cm`, 10, 20);
  ctx.fillText(`Ángulo total: ${(anguloCorte * 2).toFixed(1)}°`, 10, 40);
  ctx.fillText(`Perímetro real: ${perimetroCm.toFixed(2)} cm`, 10, 60);
  ctx.fillText(`Escala: 1:1 (100%)`, 10, 80);

  // Cuadro de 5 cm x 5 cm para verificar escala real
  const cuadroSizePx = 5 * escala;
  ctx.strokeStyle = 'black';
  ctx.lineWidth = 1;
  ctx.strokeRect(10, canvas.height - cuadroSizePx - 10, cuadroSizePx, cuadroSizePx);
  ctx.fillText('Cuadro de 5 cm x 5 cm', 10, canvas.height - cuadroSizePx - 15);
}

function descargarPDF() {
  const { jsPDF } = window.jspdf;
  const canvas = document.getElementById('moldeCanvas');
  const imgData = canvas.toDataURL('image/png');
  const pdf = new jsPDF({
    orientation: 'landscape',
    unit: 'pt',
    format: [canvas.width, canvas.height],
  });
  pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
  pdf.save('curva_tamano_escala_real.pdf');
}
</script>

</body>
</html>
