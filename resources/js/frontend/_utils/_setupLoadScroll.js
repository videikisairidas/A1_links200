export function setupLoadScroll(
    loadMoreCallback,
    checkStatusCallback,
    debounceDelay = 100,
    scrollThreshold = 300
) {
    const handleScroll = debounce(() => {
        const {isLoading, hasMore} = checkStatusCallback();

        if (isLoading || !hasMore) return; //close function

        // const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - scrollThreshold;
        const scrollTop = window.scrollY || window.pageYOffset;
        const windowHeight = window.innerHeight;
        const totalHeight = document.documentElement.scrollHeight;

        const nearBottom = (scrollTop + windowHeight) >= (totalHeight - scrollThreshold);

        if (nearBottom) {
            loadMoreCallback();
        }
    }, debounceDelay);
        
    window.addEventListener('scroll', handleScroll);

    return () => window.removeEventListener('scroll', handleScroll);
}

export function debounce(callback, delay) {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            callback(...args);
        }, delay);
    };
}