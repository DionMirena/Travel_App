
script.js

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.carousel').forEach(el => {
    const data = el.dataset.images || '';
    let imgs = data.split(',').map(s => s.trim()).filter(Boolean);


    if (imgs.length === 0) {
      imgs = ['assets/images/placeholder.jpg'];
    }
    const wrapper = document.createElement('div');
    wrapper.className = 'slides';
    wrapper.style.height = '100%';
    wrapper.style.position = 'relative';
    wrapper.style.overflow = 'hidden';

    imgs.forEach((src, i) => {
      const img = document.createElement('img');
      img.src = src;
      img.style.position = 'absolute';
      img.style.top = 0; img.style.left = 0;
      img.style.width = '100%'; img.style.height = '100%'; img.style.objectFit='cover';
      img.style.transition = 'transform 300ms';
      img.style.transform = `translateX(${i * 100}%)`;
      wrapper.appendChild(img);
    });

    let idx = 0;
    const next = () => {
      idx = (idx + 1) % imgs.length;
      update();
    };
    const prev = () => {
      idx = (idx - 1 + imgs.length) % imgs.length;
      update();
    };
    function update() {
      [...wrapper.children].forEach((child, i) => {
        child.style.transform = `translateX(${(i - idx) * 100}%)`;
      });
    }

    let startX = null;
    wrapper.addEventListener('touchstart', e => startX = e.touches[0].clientX);
    wrapper.addEventListener('touchend', e => {
      if (startX === null) return;
      const endX = e.changedTouches[0].clientX;
      const diff = endX - startX;
      if (diff > 40) prev();
      else if (diff < -40) next();
      startX = null;
    });

    wrapper.addEventListener('click', () => next());

    el.appendChild(wrapper);
  });
});
