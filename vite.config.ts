import { resolve } from 'path'
import { loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import type { UserConfig, ConfigEnv } from 'vite'

const pathResolve = (dir: string): any => {
    return resolve(__dirname, '.', dir)
}

// https://vitejs.cn/config/
const viteConfig = ({ mode }: ConfigEnv): UserConfig => {
    const { VITE_PORT, VITE_OPEN, VITE_BASE_PATH } = loadEnv(mode, process.cwd())

    const alias: Record<string, string> = {
        '/@': pathResolve('./src/'),
        assets: pathResolve('./src/assets'),
        'vue-i18n': 'vue-i18n/dist/vue-i18n.cjs.prod.js',
    }

    return {
        plugins: [vue()],
        root: process.cwd(),
        resolve: { alias },
        base: VITE_BASE_PATH,
        build: {
            sourcemap: false,
            outDir: '../public/install/',
            emptyOutDir: true,
            rollupOptions: {
                output: {
                    entryFileNames: `assets/[name].js`,
                    chunkFileNames: `assets/[name].js`,
                    assetFileNames: `assets/[name].[ext]`,
                },
            },
        },
        server: {
            host: '0.0.0.0',
            port: parseInt(VITE_PORT),
            open: VITE_OPEN != 'false',
        },
        css: {
            postcss: {
                plugins: [
                    {
                        postcssPlugin: 'internal:charset-removal',
                        AtRule: {
                            charset: (atRule) => {
                                if (atRule.name === 'charset') {
                                    atRule.remove()
                                }
                            },
                        },
                    },
                ],
            },
        },
    }
}

export default viteConfig
