import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '192.168.10.10', // replace with the IP address of the Homestead machine
        https: false,
        cors: false,
        hmr: {
            host: '192.168.10.10', // replace with the IP address of the Homestead machine
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
