document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  if (toggle && links) toggle.addEventListener('click', () => links.classList.toggle('open'));

  document.querySelectorAll('[data-preview]').forEach((input) => {
    input.addEventListener('change', () => {
      const target = input.closest('form')?.querySelector('.preview');
      if (!target) return;
      target.innerHTML = '';
      Array.from(input.files || []).slice(0, 6).forEach((file) => {
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 5 * 1024 * 1024) return;
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = file.name;
        target.appendChild(img);
      });
    });
  });

  document.querySelectorAll('[data-validate]').forEach((form) => {
    form.addEventListener('submit', (event) => {
      const invalid = Array.from(form.querySelectorAll('[required]')).some((field) => !field.value.trim());
      if (invalid) {
        event.preventDefault();
        alert('Please complete all required fields.');
      }
    });
  });
});
