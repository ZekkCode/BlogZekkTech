/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: '100%',
                    },
                },
                invert: {
                    css: {
                        '--tw-prose-body': 'var(--tw-prose-invert-body)',
                        '--tw-prose-headings': 'var(--tw-prose-invert-headings)',
                        '--tw-prose-lead': 'var(--tw-prose-invert-lead)',
                        '--tw-prose-links': 'var(--tw-prose-invert-links)',
                        '--tw-prose-bold': 'var(--tw-prose-invert-bold)',
                        '--tw-prose-counters': 'var(--tw-prose-invert-counters)',
                        '--tw-prose-bullets': 'var(--tw-prose-invert-bullets)',
                        '--tw-prose-hr': 'var(--tw-prose-invert-hr)',
                        '--tw-prose-quotes': 'var(--tw-prose-invert-quotes)',
                        '--tw-prose-quote-borders': 'var(--tw-prose-invert-quote-borders)',
                        '--tw-prose-captions': 'var(--tw-prose-invert-captions)',
                        '--tw-prose-code': 'var(--tw-prose-invert-code)',
                        '--tw-prose-pre-code': 'var(--tw-prose-invert-pre-code)',
                        '--tw-prose-pre-bg': 'var(--tw-prose-invert-pre-bg)',
                        '--tw-prose-th-borders': 'var(--tw-prose-invert-th-borders)',
                        '--tw-prose-td-borders': 'var(--tw-prose-invert-td-borders)',
                    },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
};
