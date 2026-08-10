import hljs from 'highlight.js/lib/core'
import php from 'highlight.js/lib/languages/php'
import javascript from 'highlight.js/lib/languages/javascript'

hljs.registerLanguage('php', php)
hljs.registerLanguage('javascript', javascript)

document
    .querySelectorAll('pre')
    .forEach((block) => hljs.highlightElement(block));
