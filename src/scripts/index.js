import 'core-js/stable';
import '../styles/style.scss';
// Ensure Headroom is available as window.Headroom (legacy behavior)
import '../shims/headroom-global.js';
import Stage from './components/stage';

// eslint-disable-next-line no-unused-vars
const stage = new Stage();
