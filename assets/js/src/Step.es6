import $ from 'jquery';
import config from 'dsConfig';

/**
 * A generic Step.
 */
class Step {
    /**
     * Initializes the object.
     */
    constructor() {
        /**
         * @type {jQuery}
         */
        this.loadingEl = $(`<img src="${config.pluginUrl}/assets/images/spinner.gif" alt="Loading" class="loading">`);
    }

    /**
     * Initializes the jQuery Mask plugin.
     */
    _setHandlers() {
        if ($('form').length) {
            $('input[data-mask]').each(function() {
                $(this).mask($(this).attr('data-mask'));
            });
        }
    }

    /**
     * Retrieves the Step object which handles the currently loaded page.
     *
     * @returns {?Step}
     */
    static retrieveLoadedStep() {
        let identifier = $('.ds-step-identifier'),
            step = null;

        if (!identifier.length) {
            return null;
        }

        switch (identifier.attr('data-step')) {
            case 'client-info':
                let ClientInfoStep = require('./ClientInfoStep.es6').default;
                step = new ClientInfoStep();
                break;
            default:
                throw new Error(`The current Step "${identifier.attr['data-step']}" is not supported.`);
                break;
        }

        return step;
    }
}

export default Step;