document.addEventListener('DOMContentLoaded', () => {
  const hamburger = document.querySelector('.hamburger');
  const navLinks = document.querySelector('.nav-links');
  const overlay = document.querySelector('.mobile-overlay');

  function closeMenu() {
    hamburger?.classList.remove('active');
    navLinks?.classList.remove('open');
    overlay?.classList.remove('open');
    document.body.style.overflow = '';
  }

  function openMenu() {
    hamburger?.classList.add('active');
    navLinks?.classList.add('open');
    overlay?.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  if (hamburger) {
    hamburger.addEventListener('click', () => {
      navLinks?.classList.contains('open') ? closeMenu() : openMenu();
    });
  }

  overlay?.addEventListener('click', closeMenu);

  document.querySelectorAll('.nav-links a, .nav-links .nav-btn, .nav-links .nav-logout').forEach(link => {
    link.addEventListener('click', closeMenu);
  });

  document.querySelectorAll('[data-preview]').forEach(input => {
    input.addEventListener('change', () => {
      const target = input.closest('form')?.querySelector('.preview');
      if (!target) return;
      target.innerHTML = '';
      Array.from(input.files || []).slice(0, 6).forEach(file => {
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 5 * 1024 * 1024) return;
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = file.name;
        target.appendChild(img);
      });
    });
  });

  document.querySelectorAll('[data-validate]').forEach(form => {
    form.addEventListener('submit', event => {
      const invalid = Array.from(form.querySelectorAll('[required]')).some(field => !field.value.trim());
      if (invalid) {
        event.preventDefault();
        alert('Please complete all required fields.');
      }
    });
  });
});
