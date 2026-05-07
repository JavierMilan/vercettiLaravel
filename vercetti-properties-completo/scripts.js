const cabecera = document.querySelector('.cabecera');
const logo = document.querySelector('.cabecera .logo img');

window.addEventListener('scroll', () => {
    if (window.scrollY > 80) {
        cabecera.classList.add('cabecera--scrolled');
    } else {
        cabecera.classList.remove('cabecera--scrolled');
    }
});

logo.addEventListener('click', () => {
    if (cabecera.classList.contains('cabecera--scrolled')) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});


/* cambio imagen formulario */
const bgImages = [
  'imagenes/habitacionInterior.png',
  'imagenes/fondoResultado.png',
  'imagenes/piscina.png',
  'imagenes/balcon.png'
];

const sliderA = document.getElementById('slider-a');
const sliderB = document.getElementById('slider-b');

let bgIndex = 0;
let activeSlider = sliderA;
let inactiveSlider = sliderB;

// Imagen inicial
sliderA.style.backgroundImage = `url('${bgImages[0]}')`;

setInterval(() => {
  bgIndex = (bgIndex + 1) % bgImages.length;

  // Carga la siguiente imagen en el slider que está oculto
  inactiveSlider.style.backgroundImage = `url('${bgImages[bgIndex]}')`;

  // Crossfade: uno sube, el otro baja al mismo tiempo
  inactiveSlider.style.opacity = '1';
  activeSlider.style.opacity = '0';

  // Intercambia los roles para la próxima vez
  [activeSlider, inactiveSlider] = [inactiveSlider, activeSlider];

}, 10000);