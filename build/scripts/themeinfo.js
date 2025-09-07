import ejs from 'ejs';
import fs from 'fs';

const buildNumber = (new Date()).getTime();
ejs.renderFile('./src/style.css.ejs', { buildNumber }, (err, str) => {
  if (err) {
    console.error(err);
    return;
  }
  try {
    fs.writeFileSync('style.css', str);
  } catch (e) {
    console.error(e);
  }
});
