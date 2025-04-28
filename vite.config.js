import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    host: '0.0.0.0', // Allows access from any network
    https: true, // Enable HTTPS
    hmr: {
      host: '8000-idx-employees-stage-project-1745856783394.cluster-jbb3mjctu5cbgsi6hwq6u4btwe.cloudworkstations.dev', // Set HMR host for hot module reloading
      protocol: 'wss', // Use secure WebSocket
    },
  },
});