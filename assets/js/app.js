document.getElementById('menuBtn')?.addEventListener('click',()=>document.querySelector('.sidebar')?.classList.toggle('open'));
function confirmDelete(msg='Are you sure?'){return confirm(msg);}
