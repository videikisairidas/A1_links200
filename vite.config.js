import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    // publicDir: 'public/assets',
    plugins: [
        laravel({
            input: [
                "resources/css/frontend.min.css",
                "resources/css/dashboard.min.css",
                "resources/js/frontend.js",
                "resources/js/dashboard.js",
            ],
            refresh: [
                "resources/views/**/*.blade.php",
                "routes/**/*.php",
                "app/**/*.php", // controllers, models, middleware, etc.
            ],
            buildDirectory: "assets/build",
            manifest: false,
        }),
    ],
    build: {
        // Keep these settings
        outDir: "public/assets/build",
        emptyOutDir: true,
        // manifest: 'manifest.json', // Set this to 'false' to disable the manifest and hashing
        // minifest: false,
        rollupOptions: {
            output: {
                // Manually set the output filenames and structure
                entryFileNames: "js/[name].js",
                chunkFileNames: "js/[name].js",
                assetFileNames: (assetInfo) => {
                    const name = assetInfo.name.toLowerCase();
                    // css
                    if (name.endsWith(".css")) {
                        return "css/[name][extname]";
                    }
                    // return 'assets/[name].[extname]';
                    return "[name][extname]";
                },
            },
        },
    },
    server: {
        watch: {
            usePolling: true, // important on Windows
        },
    },
});
