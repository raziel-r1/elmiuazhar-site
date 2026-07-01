document.addEventListener('mousemove', (e) => {
  const trail = document.getElementById('mouse-trail');
  // Получаем координаты мыши
  const x = e.clientX;
  const y = e.clientY;

  // Создаём «частицу» следа
  const dot = document.createElement('div');
  dot.classList.add('mouse-dot');
  dot.style.left = `${x}px`;
  dot.style.top = `${y}px`;

  trail.appendChild(dot);

  // Удаляем частицу через 1 секунду
  setTimeout(() => {
    dot.remove();
  }, 2000);
});
