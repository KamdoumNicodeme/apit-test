import './bootstrap';
import Echo from 'laravel-echo';
import socketio from 'socket.io-client';

window.io = socketio;

const echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001' // Port utilisé par le serveur de websocket
});
