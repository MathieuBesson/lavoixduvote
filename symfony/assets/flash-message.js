module.exports = function flashMessage(message, icon) {

    addFlashMessage(message, icon);

    /**
     * Display flash message on screen and remove it
     * @param {string} message - Content of flash message
     * @param {string} icon - CSS class of the icon choose
     */
    function addFlashMessage(message, icon) {
        if (document.body.querySelector('.flash-message-wrapper') === null) {
            const flashMessage = createFlashMessage(message, icon);
            document.body.appendChild(flashMessage);
            setTimeout(() => {
                document.body.removeChild(flashMessage);
            }, 6000);
        }
    }

    /**
     * Create flash message element
     * @param {string} message - Content of flash message
     * @param {string} icon - CSS class of the icon choose
     * @return {Element} - The HTML flash message
     */
    function createFlashMessage(message, icon) {
        return htmlToElement(`<div class="flash-message-wrapper d-flex justify-content-center ">
                                                                <div class="flash-message-wrapper__content d-flex flex-sm-row flex-column align-items-center">
                                                                    <span>${message}</span>
                                                                </div>
                                                            </div>`)
    }

    /**
     * Transform a string to DOM element
     * @param {string} html - The string to stransform in HTML
     * @return {Element} A DOM element
     */
    function htmlToElement(html) {
        var template = document.createElement('template');
        html = html.trim(); // Never return a text node of whitespace as the result
        template.innerHTML = html;
        return template.content.firstChild;
    }
}

