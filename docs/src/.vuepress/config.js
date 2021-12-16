const {description} = require('../../package')
const {title} = require("./config");

module.exports = {
    /**
     * Ref：https://v1.vuepress.vuejs.org/config/#title
     */
    title: 'Laravel Paystack',
    /**
     * Ref：https://v1.vuepress.vuejs.org/config/#description
     */
    description: description,

    /**
     * Extra tags to be injected to the page HTML `<head>`
     *
     * ref：https://v1.vuepress.vuejs.org/config/#head
     */
    head: [
        ['meta', {name: 'theme-color', content: '#3eaf7c'}],
        ['meta', {name: 'apple-mobile-web-app-capable', content: 'yes'}],
        ['meta', {name: 'apple-mobile-web-app-status-bar-style', content: 'black'}]
    ],

    /**
     * Theme configuration, here is the default theme configuration for VuePress.
     *
     * ref：https://v1.vuepress.vuejs.org/theme/default-theme-config.html
     */
    themeConfig: {
        repo: 'iamolayemi/laravel-paystack',
        editLinks: true,
        docsDir: 'docs',
        editLinkText: 'Help us improve this page',
        lastUpdated: true,
        nav: [
            {
                text: 'Home',
                link: '/'
            },
            {
                text: 'Guide',
                link: '/guide/',
            },
        ],
        sidebar: [
            {
                title: 'Getting Started',   // required
                children: [
                    'guide/',
                    'guide/installation',
                    'guide/quickstart'
                    // '/endpoints'
                ]
            },

        ],
        displayAllHeaders: true,

    },
    markdown: {
        lineNumbers: true
    },

    /**
     * Apply plugins，ref：https://v1.vuepress.vuejs.org/zh/plugin/
     */
    plugins: [
        '@vuepress/plugin-back-to-top',
        '@vuepress/plugin-medium-zoom',
    ]
}
