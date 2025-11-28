// scripts.js
document.addEventListener('DOMContentLoaded', ()=> {
  const listaSalas = document.getElementById('lista-salas');
  const listaUsuarios = document.getElementById('lista-usuarios');
  const chatBox = document.getElementById('chat-box');
  const form = document.getElementById('formChat');
  const msgInput = document.getElementById('mensagem');
  const fileInput = document.getElementById('arquivo');
  const idSalaInput = document.getElementById('id_sala');
  const novaSalaBtn = document.getElementById('nova-sala');
  const emojiBtn = document.getElementById('emoji-btn');
  const beep = document.getElementById('beep');
  const newmsg = document.getElementById('newmsg');

  let notifGranted = false;
  if ("Notification" in window) Notification.requestPermission().then(p => notifGranted = (p === 'granted'));

  // create emoji picker
  const picker = new EmojiButton({ position: 'top-end' });
  emojiBtn && emojiBtn.addEventListener('click', ()=> picker.togglePicker(emojiBtn));
  picker.on('emoji', selection => { msgInput.value += selection.emoji; msgInput.focus(); });

  function loadSalas() {
    fetch('salas.php').then(r=>r.text()).then(html=>{ listaSalas.innerHTML = html; const first = listaSalas.querySelector('.sala-item'); if (first && !document.querySelector('.sala-item.active')) { first.classList.add('active'); idSalaInput.value = first.getAttribute('data-id'); } });
  }

  novaSalaBtn && novaSalaBtn.addEventListener('click', ()=> {
    const nome = prompt('Nome da nova sala:');
    if (!nome) return;
    const fd = new URLSearchParams();
    fd.append('novaSala', nome);
    fetch('salas.php', { method:'POST', body: fd }).then(()=> loadSalas());
  });

  function loadUsers() {
    fetch(`usuarios.php?user=${userID}`).then(r=>r.text()).then(html=> listaUsuarios.innerHTML = html);
  }

  function loadMessages() {
    const sala = idSalaInput.value || 1;
    fetch(`mensagens.php?sala=${sala}`).then(r=>r.text()).then(html=>{
      const prevIds = Array.from(chatBox.querySelectorAll('.msg')).map(n=>parseInt(n.getAttribute('data-msgid')||0));
      chatBox.innerHTML = html;
      chatBox.querySelectorAll('.msg').forEach(m=>{
        const mid = parseInt(m.getAttribute('data-msgid')||0);
        if (!prevIds.includes(mid)) m.classList.add('fade-in');
      });

      const msgs = chatBox.querySelectorAll('.msg');
      if (msgs.length) {
        const last = msgs[msgs.length-1];
        if (!last.classList.contains('msg-me')) { newmsg.currentTime=0; newmsg.play().catch(()=>{}); if (notifGranted) new Notification('Nova mensagem', { body: last.querySelector('.msg-author').innerText + ': ' + (last.querySelector('.msg-text')?.innerText||'') }); }
        else { beep.currentTime=0; beep.play().catch(()=>{}); }
      }

      attachMessageEvents();
      chatBox.scrollTop = chatBox.scrollHeight;
    });
  }

  form.addEventListener('submit', (e)=>{
    e.preventDefault();
    const fd = new FormData(form);
    fd.set('id_sala', idSalaInput.value);
    fetch('enviar.php', { method:'POST', body: fd }).then(r=>r.json()).then(obj=>{
      if (obj.ok) { form.reset(); loadMessages(); } else console.warn(obj);
    }).catch(()=> alert('Erro ao enviar'));
  });

  let typingTimer;
  msgInput && msgInput.addEventListener('input', ()=>{
    fetch('usuarios.php', { method:'POST', body: new URLSearchParams({ typing: '1' }) });
    clearTimeout(typingTimer);
    typingTimer = setTimeout(()=> fetch('usuarios.php', { method:'POST', body: new URLSearchParams({ typing: '0' }) }), 1200);
  });

  function attachMessageEvents() {
    chatBox.querySelectorAll('.btn-edit').forEach(btn=>{
      btn.onclick = ()=> {
        const id = btn.getAttribute('data-id');
        const textEl = btn.closest('.msg').querySelector('.msg-text');
        const novo = prompt('Edite a mensagem:', textEl.innerText);
        if (novo !== null) {
          const fd = new URLSearchParams();
          fd.append('action','edit'); fd.append('msg_id', id); fd.append('mensagem', novo);
          fetch('enviar.php',{ method:'POST', body: fd }).then(()=> loadMessages());
        }
      };
    });
    chatBox.querySelectorAll('.btn-delete').forEach(btn=>{
      btn.onclick = ()=> {
        if (!confirm('Remover mensagem?')) return;
        const id = btn.getAttribute('data-id');
        fetch('delete.php',{ method:'POST', body: new URLSearchParams({ msg_id: id }) }).then(()=> loadMessages());
      };
    });
    chatBox.querySelectorAll('.reaction-btn').forEach(btn=>{
      btn.onclick = ()=> {
        const emoji = btn.getAttribute('data-emoji');
        const msgid = btn.getAttribute('data-msgid');
        fetch('react.php',{ method:'POST', body: new URLSearchParams({ msg_id: msgid, emoji: emoji }) }).then(()=> loadMessages());
      };
    });
    // double click to open emoji picker for message
    chatBox.querySelectorAll('.msg').forEach(msg=>{
      msg.ondblclick = ()=> {
        picker.togglePicker(msg);
        picker.on('emoji', selection => {
          const emoji = selection.emoji;
          const msgid = msg.getAttribute('data-msgid');
          fetch('react.php',{ method:'POST', body: new URLSearchParams({ msg_id: msgid, emoji: emoji }) }).then(()=> loadMessages());
        });
      };
    });
  }

  listaSalas.addEventListener('click', (e)=>{
    const li = e.target.closest('.sala-item'); if (!li) return;
    document.querySelectorAll('.sala-item.active').forEach(n=>n.classList.remove('active'));
    li.classList.add('active');
    idSalaInput.value = li.getAttribute('data-id');
    loadMessages();
  });

  loadSalas(); loadUsers(); loadMessages();
  setInterval(loadUsers, 5000);
  setInterval(loadMessages, 1500);
});
