import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

function getJsFiles(dir) {
    let files = [];
    fs.readdirSync(dir).forEach((file) => {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            files = [...files, ...getJsFiles(fullPath)];
        } else if (file.endsWith('.js')) {
            files.push(fullPath.replace(/\\/g, '/')); // Use forward slashes for compatibility
        }
    });
    return files;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...getJsFiles('resources/js')
            ],
            refresh: true,
        }),
    ],
});
