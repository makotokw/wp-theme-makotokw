const fs = require('fs');

const files = [
  'dist/revision.php',
  'amazonjs.css.map',
];

files.forEach((f) => {
  fs.unlink(f, (err) => {
    if (err) {
      return;
    }
    console.info(`deleted '${f}' file`);
  });
});
