import preset from './vendor/filament/filament/tailwind.config.preset'

export default {
  presets: [preset],
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{js,ts,vue}',
    './resources/css/**/*.css',
    './app/**/*.php',

    // Filament
    './vendor/filament/**/*.blade.php',
  ],
}