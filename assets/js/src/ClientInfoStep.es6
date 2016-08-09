import $ from 'jquery';
import config from 'dsConfig';
import Step from './Step.es6';

/**
 * Handles the Step where the customer's data is collected.
 */
class ClientInfoStep extends Step {
    /**
     * Initializes the object and registers event listeners.
     */
    constructor() {
        super();

        /**
         * @type {jQuery}
         */
        this.formEl = $('form.ds-client-info');

        /**
         * @type {jQuery}
         */
        this.buttonEl = this.formEl.find('button[type="submit"]');

        /**
         * @type {jQuery}
         */
        this.errorsEl = this.formEl.find('.error-container .error');

        /**
         * @type {?jQuery}
         */
        this._savedButtonEl = null;

        this._setHandlers();
    }

    /**
     * @private
     */
    _setHandlers() {
        super._setHandlers();

        let me = this,
            onAjaxFail = function() {
                me.buttonEl.replaceWith(me._savedButtonEl);
                alert('An error has occurred. If the problem persists please contact us.');
            },
            onAjaxDone = function(res) {
                if (res === 'ask-secondary') {
                    window.location.reload();
                } else if (res === 'ok') {
                    window.location = `${config.homeUrl}/ds-step/client-agreement/`;
                } else {
                    onAjaxFail();
                }
            };

        this.formEl.on('submit', function(e) {
            e.preventDefault();
            if (!$(this).valid()) {
                return;
            }

            me._savedButtonEl = me.buttonEl.replaceWith(me.loadingEl);
            me.buttonEl = me.loadingEl;

            $.ajax({
                method: 'POST',
                url: config.ajaxUrl,
                data: {
                    'action': 'saveCustomer',
                    'formData': $(this).serialize()
                },
                cache: false
            }).done(onAjaxDone).fail(onAjaxFail);
        });

        this.formEl.validate({
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors === 1
                        ? 'You missed 1 required field. It has been highlighted.'
                        : `You missed ${errors} required fields. They have been highlighted.`;
                    me.errorsEl.text(message);
                    me.errorsEl.show();
                } else {
                    me.errorsEl.hide();
                }
            },
            showErrors: function() {}
        });
    }
}

export default ClientInfoStep;