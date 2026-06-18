document.addEventListener('DOMContentLoaded', () => {
  const thread = document.querySelector('[data-thread]');
  if (thread) thread.scrollTop = thread.scrollHeight;
});
