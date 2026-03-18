export function initAdsbygoogle(adElement) {
    if (!adElement || typeof window === 'undefined') {
        return
    }

    if (
        adElement.dataset.adInitialized === 'true' ||
        adElement.getAttribute('data-adsbygoogle-status')
    ) {
        return
    }

    try {
        (window.adsbygoogle = window.adsbygoogle || []).push({})
        adElement.dataset.adInitialized = 'true'
    } catch (error) {
        console.error('Google AdSense init error:', error)
    }
}
