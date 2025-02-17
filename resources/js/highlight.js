import hljs from 'highlight.js/lib/core'
import php from 'highlight.js/lib/languages/php'
import javascript from 'highlight.js/lib/languages/javascript'
import Typography from 'typography'

hljs.registerLanguage('php', php)
hljs.registerLanguage('javascript', javascript)

document
    .querySelectorAll('pre')
    .forEach((block) => hljs.highlightElement(block));

const typography = new Typography({
    baseFontSize: '18px',
    baseLineHeight: 1.666,
    headerFontFamily: ['Avenir Next', 'Helvetica Neue', 'Segoe UI', 'Helvetica', 'Arial', 'sans-serif'],
    bodyFontFamily: ['Georgia', 'serif'],
})

typography.injectStyles()