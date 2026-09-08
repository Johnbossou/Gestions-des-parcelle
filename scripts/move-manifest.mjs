import { existsSync, renameSync } from 'node:fs';

const from = 'public/build/.vite/manifest.json';
const to = 'public/build/manifest.json';

if (existsSync(from)) {
    renameSync(from, to);
    console.log('manifest déplacé: .vite/manifest.json -> manifest.json');
} else {
    console.log('aucun .vite/manifest.json à déplacer (déjà à la racine ?)');
}