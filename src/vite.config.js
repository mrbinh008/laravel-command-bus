import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig(({ mode}) => {
    process.env = {...process.env, ...loadEnv(mode, process.cwd())};
    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true
            }),
            {
                name: 'blade',
                handleHotUpdate({file, server}) {
                    if (file.endsWith('.blade.php')) {
                        server.ws.send({
                            type: 'full-reload',
                            path: '*'
                        });
                    }
                }
            },
        ],
        server: {
            host: '0.0.0.0',
            hmr: {
                clientPort: Number(process.env.VITE_APP_PORT),
                host: 'localhost'
            }
        },
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js')
            }
        }
    }
})
