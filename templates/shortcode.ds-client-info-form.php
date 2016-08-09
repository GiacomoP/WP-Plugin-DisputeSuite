<?php

$cApplicant = $data['applicant'] === 'secondary' ? ucfirst($data['applicant']) . ' ' : '';

$td = \DisputeSuite\App::TEXT_DOMAIN;
$states = \DisputeSuite\Utils\States::getArray();
$privacyPolicy = home_url() . "/{$data['privacy']}";
$termsOfUse = home_url() . "/{$data['terms']}";
$submitLabel = $data['applicant'] === 'primary' && $data['coclient'] ? _x('Submit and continue to the secondary applicant', 'Client Information Form', $td) : _x('Proceed', 'Client Information Form', $td);

?>

<div class="ds-step-identifier" data-step="client-info"></div>
<form class="pure-form pure-form-stacked ds-client-info" autocomplete="off">
    <fieldset>
        <input type="hidden" name="applicant" value="<?php echo $data['applicant']; ?>">
        <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-2">
                <label for="first-name"><?php printf(_x('%sFirst Name', 'Client Information Form', $td), $cApplicant); ?></label>
                <input name="first-name" id="first-name" class="pure-u-23-24" type="text" placeholder="<?php echo _x('First Name', 'Client Information Form', $td); ?>" title="<?php echo _x('Please enter your name', 'Client Information Form', $td); ?>" required>
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
                <label for="last-name"><?php printf(_x('%sLast Name', 'Client Information Form', $td), $cApplicant); ?></label>
                <input name="last-name" id="last-name" class="pure-u-23-24" type="text" placeholder="<?php echo _x('Last Name', 'Client Information Form', $td); ?>" title="<?php echo _x('Please enter your name', 'Client Information Form', $td); ?>" required>
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
                <label for="email"><?php printf(_x('%sEmail', 'Client Information Form', $td), $cApplicant); ?></label>
                <input name="email" id="email" class="pure-u-23-24" type="email" placeholder="<?php echo _x('Email Address', 'Client Information Form', $td); ?>" title="<?php echo _x('Please enter a valid email address', 'Client Information Form', $td); ?>" required>
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
                <label for="phone"><?php printf(_x('%sPhone', 'Client Information Form', $td), $cApplicant); ?></label>
                <input name="phone" id="phone" class="pure-u-23-24" type="text" data-mask="999-999-9999" placeholder="<?php echo _x('Phone number', 'Client Information Form', $td); ?>" title="<?php echo _x('Please enter a valid phone number', 'Client Information Form', $td); ?>" required>
            </div>
            <div class="pure-u-1 pure-u-sm-1-2">
                <label for="addr1"><?php printf(_x('%sAddress', 'Client Information Form', $td), $cApplicant); ?></label>
                <input name="addr1" id="addr1" class="pure-u-23-24" type="text" placeholder="<?php echo _x('Address Line 1', 'Client Information Form', $td); ?>" title="<?php echo _x('Please enter a valid address', 'Client Information Form', $td); ?>" required>
                <input name="addr2" id="addr2" class="pure-u-23-24" type="text" placeholder="<?php echo _x('Address Line 2', 'Client Information Form', $td); ?>">
                <div class="pure-g form-row">
                    <div class="pure-u-1-3">
                        <input name="city" id="city" class="pure-u-23-24" type="text" placeholder="<?php echo _x('City', 'Client Information Form', $td); ?>" title="<?php echo _x('Please enter a valid city', 'Client Information Form', $td); ?>" required>
                    </div>
                    <div class="pure-u-1-3">
                        <select name="state" id="state" class="pure-u-23-24" title="<?php echo _x('Please enter a valid state', 'Client Information Form', $td); ?>" data-mask="aa" required>
                            <option selected disabled><?php echo _x('State', 'Client Information Form', $td); ?></option>
                            <?php foreach ($states as $value => $name) : ?>
                            <option value="<?php echo $value; ?>"><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="pure-u-1-3">
                        <input name="zip" id="zip" class="pure-u-1" type="text" data-mask="99999" placeholder="<?php echo _x('Postal Code', 'Client Information Form', $td); ?>" title="<?php echo _x('Please enter a valid postal code', 'Client Information Form', $td); ?>" required>
                    </div>
                </div>
                <span class="small-print"><?php echo _x('All fields are required. Your information will be sent over an encrypted connection.', 'Client Information Form', $td); ?></span>
            </div>
            <div class="pure-u-1 pure-u-sm-1-2">
                <div class="error-and-submit">
                    <div class="error-container">
                        <div class="error"></div>
                    </div>
                    <div class="submit-container">
                        <button type="submit"><?php echo $submitLabel; ?></button>
                        <p class="small-print"><?php printf(_x('By proceeding, I agree to be contacted by phone, SMS text and/or email regarding credit repair services. I also agree to the %sprivacy policy%s and %sterms of service%s.', 'Client Information Form', $td), "<a href=\"{$privacyPolicy}\" target=\"_blank\">", '</a>', "<a href=\"{$termsOfUse}\" target=\"_blank\">", '</a>'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>