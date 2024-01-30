/* vite相关 */

export function isDev(mode: string): boolean {
    return mode === 'development'
}

export function isProd(mode: string | undefined): boolean {
    return mode === 'production'
}
