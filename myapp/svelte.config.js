import adapter from '@sveltejs/adapter-static';
const dev = process.argv.includes('dev');
import { defineConfig, loadEnv } from 'vite'

let dotenv = loadEnv('', process.cwd());

/** @type {import('@sveltejs/kit').Config} */
const config = {
	kit: {
		// adapter-auto only supports some environments, see https://kit.svelte.dev/docs/adapter-auto for a list.
		// If your environment is not supported or you settled on a specific environment, switch out the adapter.
		// See https://kit.svelte.dev/docs/adapters for more information about adapters.
		adapter: adapter({
			fallback: 'index.html'
		}),
		paths: {
			assets: dev ? '' : `${dotenv?.VITE_MYASSETSURL}`,
			base: dev ? '' : `${dotenv?.VITE_MYBASE}`,
		}
	}
};

export default config;
