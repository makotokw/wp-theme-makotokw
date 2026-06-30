import {
  describe, it, expect, beforeEach,
} from 'vitest';
import Stage from '../../src/scripts/components/stage.js';

describe('Stage FontAwesome icons', () => {
  beforeEach(() => {
    document.body.innerHTML = '';
    window.FontAwesome = undefined;
  });

  it('prepends webfont icon elements without relying on the SVG runtime', () => {
    document.body.innerHTML = `
      <div class="enclosure-github">GitHub</div>
      <div class="enclosure">Default</div>
      <div class="enclosure-qiita">Qiita</div>
      <div class="enclosure-evernote">Evernote</div>
      <div class="note-link">Link</div>
      <div class="note-comment">Comment</div>
    `;
    const stage = Object.create(Stage.prototype);

    stage.initFontAwesome();

    expect(document.querySelector('.enclosure-github > i')?.className).toBe('fab fa-github');
    expect(document.querySelector('.enclosure > i')?.className).toBe('fas fa-bookmark');
    expect(document.querySelector('.enclosure-qiita > i')?.className).toBe('fas fa-bookmark');
    expect(document.querySelector('.enclosure-evernote > i')?.className).toBe('fab fa-evernote');
    expect(document.querySelector('.note-link > i')?.className).toBe('fas fa-bookmark');
    expect(document.querySelector('.note-comment > i')?.className).toBe('fas fa-comment');
    document.querySelectorAll('i').forEach((icon) => {
      expect(icon.getAttribute('aria-hidden')).toBe('true');
    });
  });
});
