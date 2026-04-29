const { createServer } = require('http');
const { Server } = require('socket.io');
const crypto = require('crypto');

const httpServer = createServer();
const io = new Server(httpServer, {
  cors: {
    origin: '*',
    methods: ['GET', 'POST'],
  },
});

const PORT   = process.env.PORT   || 3030;
const SECRET = process.env.CHAT_SECRET || 'senac-chat-secret-local';

const rooms = {};
const users = {};

// ── Validação do token HMAC assinado pelo Laravel ────────────
function verificarToken(token) {
  if (!token || typeof token !== 'string') return null;
  const dot = token.lastIndexOf('.');
  if (dot === -1) return null;

  const payload = token.substring(0, dot);
  const sig     = token.substring(dot + 1);
  const expected = crypto.createHmac('sha256', SECRET).update(payload).digest('hex');

  // comparação em tempo constante para evitar timing attacks
  if (!crypto.timingSafeEqual(Buffer.from(sig), Buffer.from(expected))) return null;

  let data;
  try {
    data = JSON.parse(Buffer.from(payload, 'base64').toString('utf8'));
  } catch {
    return null;
  }

  // verifica expiração
  if (!data.exp || Math.floor(Date.now() / 1000) > data.exp) return null;

  return data; // { ticketId, userId, role, name, exp }
}

io.on('connection', (socket) => {
  console.log(`[conexão] socket ${socket.id}`);

  /**
   * Evento: entrar na sala via token assinado pelo Laravel
   * payload: { token }
   */
  socket.on('join', ({ token }) => {
    const data = verificarToken(token);
    if (!data) {
      socket.emit('erro', { mensagem: 'Token inválido ou expirado. Recarregue a página.' });
      return;
    }

    const { ticketId, role, name } = data;
    const roomId = `ticket:${ticketId}`;

    // Remove de sala anterior se houver
    if (users[socket.id]) {
      socket.leave(`ticket:${users[socket.id].ticketId}`);
    }

    users[socket.id] = { ticketId, role, name };
    socket.join(roomId);

    if (!rooms[ticketId]) rooms[ticketId] = [];

    console.log(`[join] ${name} (${role}) entrou no ticket #${ticketId}`);

    // Confirma autorização ao cliente
    socket.emit('autorizado', { role });

    // Envia histórico
    socket.emit('historico', rooms[ticketId]);

    // Notifica demais
    socket.to(roomId).emit('sistema', {
      mensagem: `${name} (${role === 'atendente' ? 'Atendente' : 'Usuário'}) entrou no chat.`,
      timestamp: new Date().toISOString(),
    });
  });

  /**
   * Evento: enviar mensagem
   * payload: { texto }
   */
  socket.on('mensagem', ({ texto }) => {
    const user = users[socket.id];
    if (!user) {
      socket.emit('erro', { mensagem: 'Não autenticado.' });
      return;
    }

    if (!texto || typeof texto !== 'string' || texto.trim() === '') return;

    const { ticketId, role, name } = user;
    const roomId = `ticket:${ticketId}`;

    const msg = {
      role,
      name,
      texto: texto.trim().substring(0, 1000),
      timestamp: new Date().toISOString(),
    };

    if (!rooms[ticketId]) rooms[ticketId] = [];
    rooms[ticketId].push(msg);
    if (rooms[ticketId].length > 200) rooms[ticketId].shift();

    console.log(`[msg] ticket #${ticketId} | ${name}: ${msg.texto}`);
    io.to(roomId).emit('mensagem', msg);
  });

  /**
   * Digitando
   */
  socket.on('digitando', () => {
    const user = users[socket.id];
    if (!user) return;
    socket.to(`ticket:${user.ticketId}`).emit('digitando', { name: user.name, role: user.role });
  });

  socket.on('parou_digitar', () => {
    const user = users[socket.id];
    if (!user) return;
    socket.to(`ticket:${user.ticketId}`).emit('parou_digitar');
  });

  /**
   * Desconexão
   */
  socket.on('disconnect', () => {
    const user = users[socket.id];
    if (user) {
      const { ticketId, name, role } = user;
      socket.to(`ticket:${ticketId}`).emit('sistema', {
        mensagem: `${name} (${role === 'atendente' ? 'Atendente' : 'Usuário'}) saiu do chat.`,
        timestamp: new Date().toISOString(),
      });
      console.log(`[desconexão] ${name} saiu do ticket #${ticketId}`);
      delete users[socket.id];
    }
  });
});

httpServer.listen(PORT, () => {
  console.log(`Chat server rodando na porta ${PORT}`);
});
